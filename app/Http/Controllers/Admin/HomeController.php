<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Project;
use App\Models\Article;
use App\Models\Question;
use DB;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $data['count']['question'] = Question::count();
        $data['count']['student'] = Student::count();
        $data['count']['project'] = Project::count();
        $data['count']['article'] = Article::count();
        $data['articles'] = Article::orderBy('id', 'desc')->limit(10)->get();
        $periode = Periode::where('status', 1);
        return view('admin.home', $data, compact('periode'));
    }

    public function periode(Request $request)
    {
        $periodeId = $request->periode_id;
        $periode = Periode::find($periodeId);

        if (!$periode) {
            $periode = new Periode();
            $periode->tahun = $request->tahun;
            $periode->semester = $request->semester;
            $periode->status = $request->status;
            $periode->save();
            $pesan = "Periode baru berhasil ditambahkan " . $periode->tahun . " - " . $periode->semester;
        } else {
            $periode->tahun = $request->tahun;
            $periode->semester = $request->semester;
            $periode->status = $request->status;
            $periode->save();
            $pesan = "Periode berhasil diubah " . $periode->tahun . " - " . $periode->semester;
        }
        session()->flash('success', $pesan);
        return redirect()->back();
    }

}
