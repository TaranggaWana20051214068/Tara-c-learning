<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Code;
use Illuminate\Http\Request;
use App\Models\Question;
use Auth;
use Illuminate\Support\Facades\Http;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $questions = Question::leftJoin('articles', 'questions.article_id', '=', 'articles.id')
            ->where('questions.judul', 'LIKE', "%$search%")
            ->orWhere('articles.title', 'LIKE', "%$search%")
            ->orderBy('questions.id', 'asc')
            ->select('questions.*', 'articles.title as article_title')
            ->paginate(10);
        $questions->appends(['search' => $search]);

        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = Article::orderBy('id', 'asc')->get();
        return view('admin.questions.add', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'materi' => 'required',
        ]);

        $create = Question::create([
            'judul' => $request->judul,
            'deskripsi' => $request->judul,
            'author_id' => Auth::user()->id,
            'article_id' => $request->materi,
        ]);

        session()->flash('success', "Sukses tambah Soal $request->judul");
        return redirect()->route('admin.questions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $articles = Article::orderBy('id', 'asc')->get();
        return view('admin.questions.edit', compact('question', 'articles'));
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
            'judul' => 'required',
            'deskripsi' => 'required',
            'materi' => 'required',
        ]);

        $create = Question::find($id)->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'article_id' => $request->materi,
        ]);

        session()->flash('success', "Sukses ubah Soal $request->judul");
        return redirect()->route('admin.questions.index');
    }
    /**
     *
     *@param  int  $id
     *@return \Illuminate\Http\Response
     */
    public function show(request $request, $id)
    {
        $question = Question::with(['codes', 'author'])->findOrFail($id);
        $codes = Code::where('question_id', $id)->orderBy('id', 'asc')->paginate(10);

        // Check if there are any codes for the question
        if ($codes->isEmpty()) {
            $request->session()->flash('error', 'Belum ada yang menyelesaikan Soal ini');
            return redirect()->back();
        }

        $search = $request->get('search');
        $questions = Code::leftJoin('questions', 'codes.question_id', '=', 'questions.id')
            ->where('codes.question_id', $id)
            ->where(function ($query) use ($search) {
                $query->where('codes.author_id', 'LIKE', "%$search%")
                    ->orWhere('codes.score', 'LIKE', "%$search%")
                    ->orWhere('questions.judul', 'LIKE', "%$search%");
            })
            ->orderBy('codes.id', 'asc')
            ->paginate(10);

        $questions->appends(['search' => $search]);
        return view('admin.questions.detail', compact('question', 'codes'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nilai(Request $request, $id)
    {
        if ($request->has('score') && empty($request->score)) {
            $pesan = 'Nilai tidak boleh kosong!';
            return response()->json(['error' => $pesan], 422);
        }
        if (is_null($id)) {
            return response()->json(['error' => 'ID tidak valid'], 422);
        }

        $create = Code::find($id)->update([
            'score' => $request->score,
        ]);

        return response()->json(['success' => 'Berhasil Memberi Nilai ' . $request->name . ' : ' . $request->score], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editNilai(Request $request, $id)
    {
        if ($request->has('scoress') && empty($request->scoress)) {
            $pesan = 'Nilai tidak boleh kosong!';
            return response()->json(['error' => $pesan], 422);
        }
        if (is_null($id)) {
            return response()->json(['error' => 'ID tidak valid'], 422);
        }

        $create = Code::find($id)->update([
            'score' => $request->scoress,
        ]);
        return response()->json(['success' => 'Berhasil Mengubah Nilai ' . $request->name . ' : ' . $request->scoress], 200);
    }
    public function runCode($language, $files)
    {
        $accessToken = env('API_KEY_COMPILER');
        try {
            $response = Http::post('https://onecompiler.com/api/v1/run?access_token=' . $accessToken, [
                'language' => $language,
                'stdin' => '',
                'files' => $files,
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                // Jika tidak ada exception, kembalikan stdout
                if ($responseData['exception'] === null) {
                    return 'Code tidak ada error : ' . $responseData['stdout'];
                } else {
                    // Jika ada exception, kembalikan stderr
                    return $responseData['stderr'];
                }
            } else {
                // Tangani jika permintaan tidak berhasil
                throw new \Exception('Gagal mengirim permintaan: ' . $response->status());
            }
        } catch (\Exception $e) {
            // Tangani jika terjadi kesalahan dalam menjalankan permintaan
            return $e->getMessage();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Code::findOrFail($id);
        $subject->delete();

        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }

}
