<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Question;
use App\Models\Code;

class SoalController extends Controller
{

    public function questions_show($id)
    {
        $question = Question::findOrFail($id);
        if ($question->subject_id == 1) {
            $link = 'https://onecompiler.com/embed/' . $question->bahasa . '?listenToEvents=true&hideLanguageSelection=true&hideNew=true&hideNewFileOption=true&disableCopyPaste=true&hideTitle=true&codeChangeEvent=true&hideStdin=true';
            return view('soal.detail', compact('question', 'link'));
        } else {
            return view('soal.detailCustom', compact('question'));
        }
    }
    public function questions_code(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        if ($question->subject_id == 1) {

            $request->validate([
                'language' => 'required',
                'filee' => 'required|json',
                'stderr' => 'nullable|string',
                'stdin' => 'nullable|string',
                'output' => 'nullable|string',
            ]);
            $files = $request->filee;
            $fileeArray = json_decode($files, true);
            if ($request->stderr) {
                return response()->json(['error' => $request->stderr], 422);
            }
            $create = Code::create([
                'language' => $request->language,
                'output' => $request->output,
                'author_id' => Auth::user()->id,
                'question_id' => $id,
                'files' => $files,
                'kode' => $fileeArray[0]['content'],
            ]);
            return response()->json(['success' => 'Code berhasil disimpan.' . $request->output], 200);
        } else {
            $request->validate([
                'output' => 'required|string',
            ]);
            $create = Code::create([
                'output' => $request->output,
                'author_id' => Auth::user()->id,
                'question_id' => $id,
            ]);
            return redirect()->route('soal.index');
        }
    }

}
