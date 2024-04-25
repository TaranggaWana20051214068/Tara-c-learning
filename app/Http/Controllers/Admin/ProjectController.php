<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use DB;
use App\Models\Tugas;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $projects = Project::where('judul', 'LIKE', "%$search%")->orderBy('id', 'asc')->paginate(10);
        $projects->appends(['search' => $search]);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.add', compact('articles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $project = new Project();
        $project->judul = $request->judul;
        $project->deskripsi = $request->deskripsi;
        $project->save();

        session()->flash('success', "Sukses tambah Project $request->judul");
        return redirect()->route('admin.projects.index');
    }

    public function addTugas(Request $request)
    {
        $request->validate([
            'judul' => 'required|array',
            'deskripsi' => 'required|array',
            'project_id' => 'required'
        ]);
        $namaTugas = $request->nama_tugas;
        $deskripsiTugas = $request->deskripsi_tugas;
        foreach ($namaTugas as $key => $nama) {
            $tugas = new Tugas();
            $tugas->nama_tugas = $nama;
            $tugas->deskripsi = $deskripsiTugas[$key];
            $tugas->project_id = $request->project_id;
            $tugas->save();
        }
        session()->flash('success', "Sukses tambah Tugas $request->judul");
        return redirect()->route('admin.projects.indexTugas');
    }
}
