<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use DB;
use App\Models\Choice;

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

}
