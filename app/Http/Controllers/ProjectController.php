<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Kelompok;
use App\Models\Tugas;

class ProjectController extends Controller
{
    public function joinProject(Request $request)
    {
        $request->validate([
            'project_id' => 'required'
        ]);
        $user = auth()->user();
        $project = Project::find($request->project_id);

        // Membuat Kelompok baru
        $kelompok = new Kelompok();
        $kelompok->nama_siswa = $user->name;
        $kelompok->project_id = $request->project_id;
        $kelompok->save();

        // Menambahkan pengguna ke kelompok
        $kelompok->users()->attach($user->id);
        return response()->json(['success' => "Berhasil gabung kelas $project->judul"], 200);
    }

    public function projects_show($id)
    {
        $project = Project::findOrFail($id);
        $tasks = Tugas::where('project_id', $id)->get();
        $kelompok = $project->kelompok;
        $users = $kelompok->users;
        return view('projects.detail', compact('project', 'tasks', 'users'));
    }


}
