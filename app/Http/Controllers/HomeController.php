<?php

namespace App\Http\Controllers;

use App\Models\Challenges;
use App\Models\Project;
use App\Models\Question;
use App\Models\YoutubeLink;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Day;
use App\Models\Article;
use App\Http\Controllers\SoalController;
use Illuminate\Support\Facades\Auth;


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
        return view('home', compact('menus', 'ttg'));
    }


    public function student_index(Request $request)
    {
        $students = Student::orderBy('name', 'asc')->get();
        return view('students.index', compact('students'));
    }

    public function student_show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.detail', compact('student'));
    }

    public function article_index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function article_show($id)
    {
        $article = Article::findOrFail($id);
        $links = YoutubeLink::where('article_id', $id)->orderBy('id', 'desc')->pluck('link');
        $questionIds = Question::where('article_id', $id)->pluck('id');
        return view('articles.detail', compact('article', 'links', 'questionIds'));
    }

    public function jadwal_pelajaran()
    {
        $days = Day::orderBy('id', 'asc')->get();
        return view('jadwal-pelajaran', compact('days'));
    }

    public function jadwal_piket()
    {
        $days = Day::orderBy('id', 'asc')->get();
        return view('jadwal-piket', compact('days'));
    }
    public function profile()
    {
        $user = Auth::user();
        $pesan = 'is Coming Soon.';
        return view('errors.503', compact('pesan'));
        // return view('profile', compact('user'));
    }
    public function questions_index()
    {
        $userId = auth()->id();
        $questions = Question::whereDoesntHave('codes', function ($query) use ($userId) {
            $query->where('author_id', $userId);
        })->orderBy('id', 'desc')->paginate(10);
        $nilai = Question::whereHas('codes', function ($query) use ($userId) {
            $query->where('author_id', $userId);
        })->orderBy('id', 'desc')->paginate(10);
        return view('soal.index', compact('questions', 'nilai'));
    }

    public function projects_index()
    {
        $projects = Project::whereDoesntHave('kelompok.users', function ($query) {
            $query->where('users.id', auth()->id());
        })->orderBy('id', 'desc')->paginate(10);
        $takenProjects = Project::whereHas('kelompok.users', function ($query) {
            $query->where('users.id', auth()->id());
        })->orderBy('id', 'desc')->paginate(10);
        return view('projects.index', compact('projects', 'takenProjects'));
    }



}
