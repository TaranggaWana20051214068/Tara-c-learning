<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Question;

class SoalController extends Controller
{

    public function questions_show($id)
    {
        $question = Question::findOrFail($id);
        $link = 'https://onecompiler.com/embed/php?listenToEvents=true&hideLanguageSelection=true&hideNew=true&hideNewFileOption=true&disableCopyPaste=true&hideTitle=true&codeChangeEvent=true';
        return view('soal.detail', compact('question', 'link'));
    }
    public function questions_code(Request $request, $id)
    {
        $request->validate([
            'language' => 'required',
            'filee' => 'required|json',
            'stderr' => 'nullable|string',
            'stdin' => 'nullable|string',
        ]);
        if ($request->stderr) {
            $i = $request->stderr;
            return response()->json(['error' => $i], 422);
        }
        $language = $request->language;
        $files = $request->files;
        $stdin = $request->stdin;
        session()->flash('success', "code benar $language and stdin: $stdin");
        return response()->json(['success' => 'Code berhasil disimpan.'], 200);
        ;
    }
    public function runCode($language, $stdin = null, $files)
    {
        $accessToken = env('API_KEY_COMPILER');
        try {
            $response = Http::post('https://onecompiler.com/api/v1/run?access_token=' . $accessToken, [
                'language' => $language,
                'stdin' => $stdin,
                'files' => $files,
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                // Jika tidak ada exception, kembalikan stdout
                if ($responseData['exception'] === null) {
                    return $responseData['stdout'];
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
}
