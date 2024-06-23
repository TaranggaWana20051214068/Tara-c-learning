<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use Illuminate\Http\Request;
use App\Models\QuizQuestion;

class QuizController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Dapatkan id pengguna yang sedang login

        $quizs = QuizQuestion::with('userAnswers')
            ->whereDoesntHave('userAnswers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->select('category')
            ->groupBy('category')
            ->orderBy('category', 'desc')
            ->get();
        // $quizs = QuizQuestion::with('userAnswers')
        // ->whereDoesntHave('userAnswers', function ($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // })
        // ->where('category', 'LIKE', "%$search%")
        // ->select('category')
        // ->groupBy('category')
        // ->orderBy('category', 'desc')
        // ->get();

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
                'file' => $question->file,
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
        $data = json_decode($request->input('data'), true);
        $answers = $request->input('answers');

        if (is_null($answers)) {
            // Jika ada pertanyaan yang tidak dijawab, kembalikan respons dengan kode status 422
            return response()->json(['error' => 'Harap jawab semua pertanyaan.'], 422);
        }
        // Periksa apakah semua pertanyaan telah dijawab
        $allQuestionsAnswered = true;
        foreach ($data as $item) {
            if (!array_key_exists($item['id'], $answers)) {
                $allQuestionsAnswered = false;
                break;
            }
        }

        if (!$allQuestionsAnswered) {
            // Jika ada pertanyaan yang tidak dijawab, kembalikan respons dengan kode status 422
            return response()->json(['error' => 'Harap jawab semua pertanyaan.'], 422);
        }

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
