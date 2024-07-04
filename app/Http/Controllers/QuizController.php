<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use App\Models\QuizQuestion;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id(); // Dapatkan id pengguna yang sedang login
        $subject = $request->get('subject');

        $quizs = QuizQuestion::whereHas('periode', function ($query) {
            $query->where('status', 1);
        })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->with('userAnswers')
            ->whereDoesntHave('userAnswers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->select('category')
            ->groupBy('category')
            ->orderBy('category', 'desc')
            ->get();

        $quizClear = QuizQuestion::whereHas('periode', function ($query) {
            $query->where('status', 1);
        })
            ->whereHas('subject', function ($query) use ($subject) {
                if ($subject) {
                    $query->where('id', $subject);
                }
            })
            ->with('userAnswers')
            ->whereHas('userAnswers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->groupBy('category');

        $data = $quizClear->map(function ($quizClear, $category) use ($userId) {
            $maxScore = $quizClear->count(); // Jumlah soal dalam kategori

            $totalScore = $quizClear->sum(function ($question) use ($userId) {
                $userAnswer = $question->userAnswers->where('user_id', $userId)->first();
                return $userAnswer && $userAnswer->choice->is_correct ? 1 : 0;
            });

            $normalizedScore = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

            return [
                'category' => $category,
                'score' => $normalizedScore,
            ];
        });

        $subjects = Subject::all();

        return view('quizs.index', compact('quizs', 'data', 'subjects'));
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
        return view('quizs.detail', compact('data', 'category'));
    }

    public function showJawaban($category)
    {
        $userId = auth()->id(); // Dapatkan id pengguna yang sedang login

        // Dapatkan semua pertanyaan dari kategori tertentu dan urutkan berdasarkan id
        $questions = QuizQuestion::where('category', $category)
            ->with([
                'choices',
                'userAnswers' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])
            ->orderBy('id')
            ->get();

        $data = $questions->map(function ($question, $index) use ($userId) {
            $userAnswer = $question->userAnswers->where('user_id', $userId)->first();
            $isCorrect = $userAnswer ? $userAnswer->choice->is_correct : null;

            return [
                'no_urut' => $index + 1,
                'question_text' => $question->pertanyaan,
                'file' => $question->file,
                'choices' => $question->choices->map(function ($choice) use ($userAnswer, $isCorrect) {
                    return [
                        'id' => $choice->id,
                        'choice_text' => $choice->choice_text,
                        'is_selected' => $userAnswer && $userAnswer->choice_id == $choice->id,
                        'is_correct' => $choice->is_correct, // Tambahkan kunci 'is_correct' di sini
                    ];
                })->all(),
                'user_answer_id' => $userAnswer ? $userAnswer->choice_id : null,
                'is_correct' => $isCorrect,
            ];
        });


        $totalScore = $questions->sum(function ($question) use ($userId) {
            $userAnswer = $question->userAnswers->where('user_id', $userId)->first();
            return $userAnswer && $userAnswer->choice->is_correct ? 1 : 0;
        });

        $maxScore = $questions->count();
        $normalizedScore = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

        return view('quizs.detail-jawaban', compact('data', 'category', 'normalizedScore'));
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
