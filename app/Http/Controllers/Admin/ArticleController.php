<?php

namespace App\Http\Controllers\Admin;

use App\Models\Periode;
use App\Models\Subject;
use App\Models\YoutubeLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Str;
use Auth;
use Storage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $subject = $request->get('subject');

        $articles = Article::whereHas('periode', function ($query) {
            $query->where('status', 1);
        })->whereHas('subject', function ($query) use ($subject) {
            if ($subject) {
                $query->where('id', 'LIKE', "%$subject%");
            }
        })->where('title', 'LIKE', "%$search%")->orderBy('id', 'desc')->paginate(10);

        $articles->appends(['search' => $search, 'subject' => $subject]);
        $subjects = Subject::all();
        return view('admin.articles.index', compact('articles', 'subjects'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $subjects = Subject::all();
        return view('admin.articles.add', compact('subjects'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Periksa apakah thumbnail ada dan sesuai dengan persyaratan ukuran

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'youtube_links' => 'nullable',
            'subject' => 'required||integer',
        ]);
        // Dapatkan id periode yang sedang aktif
        $periodeId = Periode::where('status', 1)->first()->id;
        // Simpan artikel
        $article = new Article;
        $article->title = $request->title;
        $article->author_id = Auth::user()->id;
        $article->content = $request->content;
        $article->subject_id = $request->subject;
        $article->periode_id = $periodeId;

        // Simpan thumbnail jika ada
        $photo = $request->file('thumbnail');
        $image_extension = $photo->extension();
        $image_name = Str::slug($request->title) . "." . $image_extension;
        $photo->storeAs('/images/articles', $image_name, 'public');
        $article->thumbnail_image_name = $image_name;

        if ($request->hasFile('file_name')) {
            $photo = $request->file('file_name');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->title) . "." . $image_extension;
            $photo->storeAs('/images/articles/file', $image_name, 'public');
            $article->file_name = $image_name;
        }

        // Simpan artikel terlebih dahulu
        $article->save();

        // Simpan tautan YouTube jika ada
        if ($request->has('youtube_links')) {
            foreach ($request->youtube_links as $link) {
                YoutubeLink::create([
                    'article_id' => $article->id,
                    'link' => $link,
                    'title' => $article->title
                    // Tambahkan kolom-kolom lain yang diperlukan
                ]);
            }
        }

        session()->flash('success', "Sukses tambah Materi $article->title");
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $article = Article::findOrFail($id);
        $links = YoutubeLink::where('article_id', $id)->orderBy('id', 'desc')->pluck('link');
        $subjects = Subject::all();
        return view('admin.articles.edit', compact('article', 'links', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'nullable|file',
            'file' => 'nullable|file',
            'subject' => 'required||integer',
        ]);
        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->subject_id = $request->subject;
        if ($request->hasFile('thumbnail')) {
            Storage::delete('public/images/articles/' . $article->thumbnail_image_name);
            $photo = $request->file('thumbnail');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->title) . "." . $image_extension;
            $photo->storeAs('/images/articles', $image_name, 'public');
            $article->thumbnail_image_name = $image_name;
        }
        if ($request->hasFile('file')) {
            Storage::delete('public/images/articles/file/' . $article->image_name);
            $photo = $request->file('file');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->title) . "." . $image_extension;
            $photo->storeAs('/images/articles/file', $image_name, 'public');
            $article->file_name = $image_name;
        }
        $article->save();

        session()->flash('success', "Sukses ubah Materi $article->title");
        return redirect()->route('admin.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        Storage::delete('public/images/articles/' . $article->thumbnail_image_name);
        Storage::delete('public/images/articles/file/' . $article->file_name);
        $article->delete();

        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }

    public function getYoutubeVideoId($url)
    {
        // Mengambil ID video dari URL yang memiliki format 'youtu.be'
        if (strpos($url, 'youtu.be') !== false) {
            $parts = explode('/', $url);
            return end($parts);
        }

        // Mengambil ID video dari URL yang memiliki parameter 'v'
        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);
        if (isset($params['v'])) {
            return $params['v']; // Mengembalikan ID video jika ada
        } else {
            return null; // Mengembalikan null jika tidak ada ID video
        }
    }
    public function validateUrl($url)
    {

        if (strpos($url, 'youtube') !== false || strpos($url, 'youtu.be') !== false) {
            // Jika terdapat ID video setelah kata kunci 'youtube' atau 'youtu.be'
            if ($this->getYoutubeVideoId($url) !== null) {
                return filter_var($url, FILTER_VALIDATE_URL) !== false;
            }
        }
        return false;

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function url(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'link' => 'required|url',
            'id' => 'required',
            'title' => 'required'
        ]);
        // Validasi umum untuk link YouTube
        $request->validate(YoutubeLink::$rules, YoutubeLink::$messages);

        // Validasi unik untuk link berdasarkan artikel
        $youtubeLink = new YoutubeLink();

        $validatedData = $request->validate(['link' => $youtubeLink->rules()], $youtubeLink->messages());


        // Cek apakah ada link yang sama dalam artikel
        $existingLink = YoutubeLink::where('link', $validatedData['link'])
            ->where('article_id', $request->id)
            ->exists();

        if ($existingLink) {
            // Jika ada link yang sama dalam artikel, tampilkan pesan error
            session()->flash('error', 'URL tidak boleh sama');
            return redirect()->back();
        }
        if (!$this->validateUrl($request->link)) {
            // URL tidak valid, lakukan sesuatu di sini
            session()->flash('error', 'URL tidak valid');
            return redirect()->back();
        } else {
            $youtube = new YoutubeLink;
            $youtube->article_id = $request->id;
            $youtube->link = $request->link;
            $youtube->title = $request->title;
            $youtube->save();
            // Lakukan penyimpanan ke dalam database atau tempat penyimpanan lainnya

            // Berikan respons yang sesuai ke klien
            session()->flash('success', 'URL Berhasil Ditambahkan');
            return redirect()->back();
        }
    }
}
