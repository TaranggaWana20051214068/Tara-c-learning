<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\QuizQuestion;
use App\Models\Subject;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use DB;
use App\Models\Choice;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;
use Str;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $subject = $request->get('subject');

        $quizs = QuizQuestion::whereHas('periode', function ($query) {
            $query->where('status', 1);
        })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->where('category', 'LIKE', "%$search%")
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->paginate(10);

        $quizs->appends(['search' => $search, 'subject' => $subject]);

        $subjects = Subject::all();

        return view('admin.quizs.index', compact('quizs', 'subjects'));
    }


    public function create()
    {
        $subjects = Subject::all();
        return view('admin.quizs.add', compact('subjects'));
    }

    public function addQuiz(Request $request)
    {
        if (empty($request->category)) {
            return response()->json(['error' => 'Judul tidak boleh Kosong'], 422);
        } else if (empty($request->question)) {
            return response()->json(['error' => 'Pertanyaan tidak boleh kosong'], 422);
        } else if (empty($request->choices) || !is_array($request->choices) || count($request->choices) != 5) {
            return response()->json(['error' => 'pilihan tidak boleh kosong dan harus berisi 5 item'], 422);
        } else if (empty($request->correct) || !is_numeric($request->correct) || $request->correct < 1 || $request->correct > 5) {
            return response()->json(['error' => 'Pilih jawaban benar dulu dan harus berupa angka antara 1 dan 5'], 422);
        } else if ($request->hasFile('file')) {
            $photo = $request->file('file');
            if ($photo->getSize() > 2000000) { // ukuran dalam bytes
                return response()->json(['error' => 'Ukuran file tidak boleh lebih dari 2MB'], 422);
            }
        }
        // Dapatkan id periode yang sedang aktif
        $periodeId = Periode::where('status', 1)->first()->id;
        // Membuat pertanyaan baru
        $quizQuestion = new QuizQuestion;
        $quizQuestion->pertanyaan = $request->question;
        $quizQuestion->category = $request->category;
        $quizQuestion->periode_id = $periodeId;
        $quizQuestion->subject_id = $request->subject;
        if ($request->hasFile('file')) {
            $photo = $request->file('file');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->category) . "-" . uniqid() . "." . $image_extension;
            $photo->storeAs('/images/quizs', $image_name, 'public');
            $quizQuestion->file = $image_name;
        }
        $quizQuestion->save();
        // Membuat pilihan jawaban
        foreach ($request->choices as $index => $choice_text) {
            $is_correct = ($request->correct == $index + 1);

            Choice::create([
                'q_question_id' => $quizQuestion->id,
                'choice_text' => $choice_text,
                'is_correct' => $is_correct,
            ]);
        }


        return response()->json(['success' => 'Berhasil'], 200);
    }

    public function show(Request $request, $category)
    {
        $search = $request->get('search');
        $questions = QuizQuestion::where('category', $category)
            ->where('pertanyaan', 'LIKE', "%$search%")
            ->with('choices')
            ->orderBy('id', 'asc')
            ->paginate(10);
        $questions->appends(['search' => $search]);

        return view('admin.quizs.category', compact('questions'));
    }

    public function edit($id)
    {
        $subjects = Subject::all();

        // Temukan quiz berdasarkan id
        $quiz = QuizQuestion::with('choices')->findOrFail($id);

        // Tampilkan view edit dengan quiz dan choices
        return view('admin.quizs.edit', compact('quiz', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        // Temukan quiz berdasarkan id
        $quizQuestion = QuizQuestion::findOrFail($id);

        // Validasi request
        $validated = $request->validate([
            'category' => 'required|string',
            'question' => 'required|string',
            'file' => 'nullable|max:2048',
            'subject' => 'required|numeric',
        ]);

        // Perbarui pertanyaan
        $quizQuestion = QuizQuestion::find($id);
        $quizQuestion->pertanyaan = $validated['question'];
        $quizQuestion->category = $validated['category'];
        $quizQuestion->subject_id = $validated['subject'];
        if ($request->hasFile('file')) {
            Storage::delete('public/images/quizs/' . $quizQuestion->file);
            $photo = $request->file('file');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->category) . "-" . uniqid() . "." . $image_extension;
            $photo->storeAs('/images/quizs', $image_name, 'public');
            $quizQuestion->file = $image_name;
        }
        $quizQuestion->save();
        session()->flash('success', "Sukses Mengubah Data");
        return redirect()->route('admin.quizs.detail', ['category' => $quizQuestion->category]);
    }

    public function siswa(Request $request, $category)
    {
        $search = $request->get('search');

        // Dapatkan semua jawaban dari kategori tertentu
        $userAnswers = UserAnswer::whereHas('quizQuestion', function ($query) use ($category) {
            $query->where('category', $category);
        })
            ->whereHas('user', function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
            })
            ->get();

        $groupedAnswers = $userAnswers->groupBy('user_id');

        // Hitung jumlah soal dalam kategori
        $maxScore = QuizQuestion::where('category', $category)->count();

        $data = $groupedAnswers->map(function ($userAnswers, $userId) use ($maxScore) {
            $user = $userAnswers->first()->user;
            $totalScore = $userAnswers->sum(function ($userAnswer) {
                return $userAnswer->choice->is_correct ? 1 : 0;
            });

            // Normalisasi skor ke skala 100
            $normalizedScore = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

            return [
                'user_id' => $userId,
                'student_name' => $user->name,
                'completed_at' => $userAnswers->max('created_at'),
                'score' => $normalizedScore,
            ];
        })->values(); // values() untuk memastikan indeks dimulai dari 0

        // Paginasi data
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginator = new LengthAwarePaginator($currentItems, $data->count(), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        return view('admin.quizs.siswa', compact('paginator', 'data', 'category'));
    }


    public function destroy_siswa($user_id, $category)
    {
        UserAnswer::whereHas('quizQuestion', function ($query) use ($category) {
            $query->where('category', $category);
        })
            ->where('user_id', $user_id)
            ->delete();
        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $quiz = QuizQuestion::findOrFail($id);

        // Hapus semua jawaban pengguna yang terkait dengan pilihan yang akan dihapus
        UserAnswer::whereHas('choice', function ($query) use ($quiz) {
            $query->where('q_question_id', $quiz->id);
        })->delete();

        // Setelah itu, hapus pilihan dan pertanyaan
        Storage::delete('public/images/quizs/' . $quiz->file);
        $quiz->choices()->delete();
        $quiz->delete();

        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }


}
