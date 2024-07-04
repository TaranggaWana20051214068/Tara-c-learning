<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Code;
use App\Models\Periode;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Question;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class SoalController extends Controller
{
    /**
     * Menampilkan daftar pertanyaan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Mengambil kata kunci pencarian dan ID mata pelajaran dari permintaan
        $search = $request->get('search');
        $subject = $request->get('subject');

        // Melakukan query pada tabel pertanyaan dengan left join pada tabel artikel
        $questions = Question::leftJoin('articles', 'questions.article_id', '=', 'articles.id')
            // Memfilter pertanyaan berdasarkan periode aktif
            ->whereHas('periode', function ($query) {
                $query->where('status', 1);
            })
            // Memfilter pertanyaan berdasarkan ID mata pelajaran
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            // Memfilter pertanyaan berdasarkan kata kunci pencarian
            ->where(function ($query) use ($search) {
                $query->where('questions.judul', 'LIKE', "%$search%")
                    ->orWhere('articles.title', 'LIKE', "%$search%");
            })
            // Mengurutkan hasil berdasarkan ID pertanyaan secara ascending
            ->orderBy('questions.id', 'asc')
            // Memilih kolom yang diinginkan dari tabel pertanyaan dan artikel
            ->select('questions.*', 'articles.title as article_title')
            // Membatasi hasil dengan 10 item per halaman
            ->paginate(10);

        // Menambahkan parameter pencarian dan mata pelajaran ke tautan paginasi
        $questions->appends(['search' => $search, 'subject' => $subject]);

        // Mengambil semua mata pelajaran
        $subjects = Subject::all();

        // Meneruskan data pertanyaan dan mata pelajaran ke view
        return view('admin.questions.index', compact('questions', 'subjects'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(): View
    // {
    //     $articles = Article::orderBy('id', 'asc')->get();
    //     $subjects = Subject::all();
    //     return view('admin.questions.add', compact('articles', 'subjects'));
    // }
    public function createCustom(Request $request): View
    {
        if ($request->subject == '1') {
            $articles = Article::orderBy('id', 'asc')->get();
            return view('admin.questions.add', compact('articles'));
        } else {
            $articles = Article::orderBy('id', 'asc')->get();
            $subjects = Subject::all();
            return view('admin.questions.addCustom', compact('articles', 'subjects'));
        }

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
            'subject' => 'required||integer',
        ]);
        // Dapatkan id periode yang sedang aktif
        $periodeId = Periode::where('status', 1)->first()->id;
        if ($request->subject == '1') {
            $bahasa = $request->bahasa;
        } else {
            $bahasa = '';
        }
        $create = Question::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bahasa' => $request->bahasa,
            'author_id' => Auth::user()->id,
            'article_id' => $request->materi,
            'periode_id' => $periodeId,
            'subject_id' => $request->subject,
        ]);

        if ($create) {
            session()->flash('success', "Sukses tambah Soal $request->judul");
            return redirect()->route('admin.questions.index');
        } else {
            session()->flash('error', "Gagal tambah Soal $request->judul");
            return redirect()->route('admin.questions.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $question = Question::findOrFail($id);
        $articles = Article::orderBy('id', 'asc')->get();
        if ($question->subject_id == 1) {
            $bahasa = [
                'html',
                'php',
                'mysql',
            ];
            return view('admin.questions.edit', compact('question', 'articles', 'bahasa'));
        } else {
            $subjects = Subject::all();
            return view('admin.questions.editCustom', compact('question', 'articles', 'subjects'));

        }
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
            'subject' => 'required||integer',
        ]);
        if ($request->subject == '1') {
            $bahasa = $request->bahasa;
        } else {
            $bahasa = '';
        }
        $create = Question::find($id)->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bahasa' => $request->bahasa,
            'article_id' => $request->materi,
            'subject_id' => $request->subject,
        ]);
        if ($create) {
            session()->flash('success', "Sukses ubah Soal $request->judul");
            return redirect()->route('admin.questions.index');
        } else {
            session()->flash('error', "Gagal ubah Soal $request->judul");
            return redirect()->route('admin.questions.index');
        }
    }
    /**
     *
     *@param  int  $id
     *@return \Illuminate\Http\Response
     */
    public function show(request $request, $id): View
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
        if ($question->subject_id == 1) {
            return view('admin.questions.detail', compact('question', 'codes'));
        } else {
            return view('admin.questions.detailCustom', compact('question', 'codes'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nilai(Request $request, $id)
    {

        if (is_null($id)) {
            return response()->json(['error' => 'ID tidak valid'], 422);
        }

        if ($request->has('score')) {
            if ($request->score < 1 || $request->score > 100) {
                $pesan = 'Nilai harus antara 1 dan 100!';
                return response()->json(['error' => $pesan], 422);
            }
        } else {
            $pesan = 'Nilai tidak boleh kosong!';
            return response()->json(['error' => $pesan], 422);
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
        $question = Question::findOrFail($id);
        $question->delete();

        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }

}
