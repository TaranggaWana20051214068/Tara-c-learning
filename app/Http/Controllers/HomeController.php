<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Question;
use App\Models\QuizQuestion;
use App\Models\Subject;
use App\Models\UserAnswer;
use App\Models\YoutubeLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Str;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = [
            (object) [
                'image_name' => 'image_menu_1.png',
                'judul' => 'Materi',
                'description' => 'Pembelajaran interaktif dengan kemudahaan akses materi pembelajaran dimana saja dan kapan saja.',
            ],
            (object) [
                'image_name' => 'image_menu_2.png',
                'judul' => 'Tugas & Project',
                'description' => 'Pembelajaran interaktif yang memudahkan siswa berinteraksi langsung dengan materi.',
            ],
            (object) [
                'image_name' => 'image_menu_3.png',
                'judul' => 'Video Interaktif',
                'description' => 'Penyajian video tutorial yang dapat menunjang pengalaman belajar siswa.',
            ],
        ];
        $ttg = [
            'image_name' => 'bg_ttg.png',
            'description' => '"C-Learning: Platform pembelajaran daring yang menyediakan  sumber belajar lengkap untuk membantu siswa meningkatkan prestasi dan nilai akademik dalam bidang pengetahuan maupun keterampilan”',
        ];
        if (Auth::user()->role === 'siswa') {
            $today = date('Y-m-d');
            $userName = Auth::user()->name;
            $check = DB::table('presensis')->where([['tgl_presensi', $today], ['name', $userName]])->count();
            if ($check == 0) {
                session()->flash('warning-presensi', 'Anda belum presensi hari ini.');
            }
        }

        return view('home', compact('menus', 'ttg'));
    }
    public function updatedJawaban()
    {
        $tanggal_baru = '2023-06-03 00:00:00'; // Ganti dengan tanggal yang diinginkan
        $table_name = 'user_answers'; // Ganti dengan nama tabel yang ingin diubah

        DB::table($table_name)
            ->update([
                'created_at' => $tanggal_baru,
                'updated_at' => $tanggal_baru
            ]);

        return 'Nilai created_at dan updated_at berhasil diubah untuk tabel ' . $table_name;
    }

    public function article_index(Request $request)
    {
        $search = $request->get('search');
        $subject = $request->get('subject');

        $articles = Article::whereHas('periode', function ($query) {
            $query->where('status', 1);
        })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->where('title', 'LIKE', "%$search%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        $articles->appends(['search' => $search, 'subject' => $subject]);
        $subjects = Subject::all();
        return view('articles.index', compact('articles', 'subjects'));
    }

    public function article_show($id)
    {
        $article = Article::findOrFail($id);
        $links = YoutubeLink::where('article_id', $id)->orderBy('id', 'desc')->get();
        if ($links->first() && $links->first()->link) {
            $youtubeVideos = $links->map(function ($link) {
                return $link->getEmbedCode();
            });
        } else {
            $youtubeVideos = [];
        }
        // Mengambil embed code untuk setiap link YouTube

        $questionIds = Question::where('article_id', $id)->pluck('id');
        return view('articles.detail', compact('article', 'questionIds', 'youtubeVideos'));
    }

    public function profile()
    {
        // return view('errors.503', compact('pesan'));
        $user = Auth::user();
        $userId = Auth::user()->id;
        $pesan = 'is Coming Soon.';
        $nilai = Question::whereHas('codes', function ($query) use ($userId) {
            $query->where('author_id', $userId);
        })->orderBy('id', 'desc')->paginate(10);
        // Ambil data jawaban pengguna berdasarkan $userId
        $userAnswers = UserAnswer::where('user_id', $userId)->get();

        // Ambil kategori-kategori yang dijawab oleh pengguna
        $categories = $userAnswers->pluck('quizQuestion.category')->unique();

        $data = [];

        // Iterasi setiap kategori untuk menghitung nilai
        foreach ($categories as $category) {
            // Hitung jumlah soal dalam kategori
            $maxScore = QuizQuestion::where('category', $category)->count();

            // Filter jawaban pengguna berdasarkan kategori
            $userAnswersInCategory = $userAnswers->where('quizQuestion.category', $category);

            $totalScore = $userAnswersInCategory->sum(function ($userAnswer) {
                return $userAnswer->choice->is_correct ? 1 : 0;
            });

            // Normalisasi skor ke skala 100
            $normalizedScore = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

            // Tambahkan data kategori, tanggal, dan skor ke dalam array
            $data[] = [
                'category' => $category,
                'completed_at' => $userAnswersInCategory->max('created_at'),
                'score' => $normalizedScore,
            ];
        }

        // Urutkan data berdasarkan tanggal terakhir diurutkan dari yang terbaru
        usort($data, function ($a, $b) {
            return strtotime($b['completed_at']) - strtotime($a['completed_at']);
        });

        // Paginasi data
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator($currentItems, count($data), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);
        return view('profile', compact('user', 'nilai', 'paginator'));
    }

    public function profile_edit()
    {
        $user = Auth::user();
        return view('profile_edit', compact('user'));

    }
    public function profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'email' => 'required|email'
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('photo')) {
            Storage::delete('public/images/faces/' . $user->profile_pic);
            $photo = $request->file('photo');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->name) . "." . $image_extension;
            $photo->storeAs('/images/faces', $image_name, 'public');
            $user->profile_pic = $image_name;
        }
        $user->save();

        session()->flash('success', "Sukses ubah data $request->name");
        return redirect()->route('user.profile');
    }
    public function questions_index(Request $request)
    {
        $userId = auth()->id();
        $subject = $request->get('subject');

        // Ambil semua pertanyaan dengan informasi 'codes' terkait
        $questions = Question::with([
            'codes' => function ($query) use ($userId) {
                $query->where('author_id', $userId);
            }
        ])
            ->whereHas('periode', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Siapkan data 'nilai' untuk setiap pertanyaan
        $questions->each(function ($question) use ($userId) {
            $question->nilai = $question->codes->first() ? $question->codes->first()->score : null;
        });

        $questions->appends(['subject' => $subject]);

        $subjects = Subject::all();
        return view('soal.index', compact('questions', 'subjects'));
    }



    public function projects_index(Request $request)
    {
        $subject = $request->get('subject');

        $projects = Project::whereDoesntHave('kelompok.users', function ($query) {
            $query->where('users.id', auth()->id());
        })
            ->whereHas('periode', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        $takenProjects = Project::whereHas('kelompok.users', function ($query) {
            $query->where('users.id', auth()->id());
        })
            ->whereHas('periode', function ($query) {
                $query->where('status', 1);
            })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $subjects = Subject::all();

        return view('projects.index', compact('projects', 'takenProjects', 'subjects'));
    }


    public function panduan()
    {
        return view('panduan');
    }


}
