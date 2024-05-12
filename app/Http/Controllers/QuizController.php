<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use Illuminate\Http\Request;
use App\Models\QuizQuestion;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $userId = auth()->id(); // Dapatkan id pengguna yang sedang login

        $quizs = QuizQuestion::where('category', 'LIKE', "%$search%")
            ->select('category')
            ->groupBy('category')
            ->orderBy('category', 'desc')
            ->whereDoesntHave('userAnswers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->paginate(10);

        $quizs->appends(['search' => $search]);

        return view('quizs.index', compact('quizs'));
    }


    public function show($category)
    {
        // Dapatkan semua pertanyaan dari kategori tertentu dan urutkan berdasarkan id
        $questions = QuizQuestion::where('category', $category)->with('choices')->orderBy('id')->get();

        // Ubah setiap pertanyaan dan pilihannya menjadi array
        $data = $questions->map(function ($question, $index) {
            return [
                'no_urut' => $index + 1,
                'id' => $question->id,
                'question_text' => $question->pertanyaan,
                'choices' => $question->choices->map(function ($choice) {
                    return [
                        'id' => $choice->id,
                        'choice_text' => $choice->choice_text,
                    ];
                })->all(),
            ];
        });
        $categorys = $category;
        return view('quizs.detail', compact('data', 'categorys'));
    }
    public function add(Request $request)
    {
        $answers = $request->input('answers');

        foreach ($answers as $questionId => $choiceId) {
            // Simpan jawaban pengguna ke database
            UserAnswer::create([
                'user_id' => auth()->id(),
                'q_question_id' => $questionId,
                'choice_id' => $choiceId,
            ]);
        }

        // Redirect pengguna ke halaman berikutnya
        return response()->json(['success' => 'Kamu Berhasil Menyelesaikan Quiz.'], 200);
    }


}
