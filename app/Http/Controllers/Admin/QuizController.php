<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use DB;
use App\Models\Choice;
use Illuminate\Pagination\LengthAwarePaginator;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $quizs = QuizQuestion::where('category', 'LIKE', "%$search%")
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->paginate(10);
        $quizs->appends(['search' => $search]);

        return view('admin.quizs.index', compact('quizs'));
    }

    public function create()
    {
        return view('admin.quizs.add');
    }
    public function addQuiz(Request $request)
    {
        if (empty($request->category)) {
            return response()->json(['error' => 'Judul tidak boleh Kosong'], 422);
        } else if (empty($request->question)) {
            return response()->json(['error' => 'Pertanyaan tidak boleh kosong'], 422);
        } else if (empty($request->choices) || !is_array($request->choices) || count($request->choices) != 4) {
            return response()->json(['error' => 'pilihan tidak boleh kosong dan harus berisi 4 item'], 422);
        } else if (empty($request->correct) || !is_numeric($request->correct) || $request->correct < 1 || $request->correct > 4) {
            return response()->json(['error' => 'Pilih jawaban benar dulu dan harus berupa angka antara 1 dan 4'], 422);
        }
        // Membuat pertanyaan baru
        $quizQuestion = QuizQuestion::create([
            'pertanyaan' => $request->question,
            'category' => $request->category,
        ]);

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
            ->orderBy('id', 'desc')
            ->paginate(10);
        $questions->appends(['search' => $search]);

        return view('admin.quizs.category', compact('questions'));
    }

    public function edit($id)
    {
        // Temukan quiz berdasarkan id
        $quiz = QuizQuestion::with('choices')->findOrFail($id);

        // Tampilkan view edit dengan quiz dan choices
        return view('admin.quizs.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        // Temukan quiz berdasarkan id
        $quizQuestion = QuizQuestion::findOrFail($id);

        // Validasi request
        $validated = $request->validate([
            'category' => 'required|string',
            'question' => 'required|string',
        ]);

        // Perbarui pertanyaan
        $quizQuestion->update([
            'pertanyaan' => $validated['question'],
            'category' => $validated['category'],
        ]);
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
                $query->where('name', 'like', "%{$search}%");
            })
            ->get();

        $groupedAnswers = $userAnswers->groupBy('user_id');

        $data = $groupedAnswers->map(function ($userAnswers, $userId) {
            $user = $userAnswers->first()->user;
            $totalScore = $userAnswers->sum(function ($userAnswer) {
                return $userAnswer->choice->is_correct ? 1 : 0;
            });

            return [
                'student_name' => $user->name,
                'completed_at' => $userAnswers->max('created_at'),
                'score' => $totalScore,
            ];
        });

        // Paginasi data
        // Paginasi manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $data->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginator = new LengthAwarePaginator($currentItems, count($data), $perPage, $currentPage, ['path' => LengthAwarePaginator::resolveCurrentPath()]);

        return view('admin.quizs.siswa', compact('data', 'paginator'));
    }



    public function destroy($id)
    {
        $quiz = QuizQuestion::findOrFail($id);
        $quiz->choices()->delete();
        $quiz->delete();

        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }

}
