<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Kelompok;
use App\Models\Tugas;
use App\User;
use Str;

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
        $users = User::whereHas('kelompok', function ($query) use ($id) {
            $query->where('project_id', $id);
        })->get();
        return view('projects.detail', compact('project', 'tasks', 'users'));
    }
    public function projects_tugas(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file',
        ]);
        $filename = $request->file('file')->getClientOriginalName();
        if (preg_match('/[@\-]/', $filename)) {
            return response()->json(['error' => 'Nama file tidak boleh mengandung karakter @ atau -'], 422);
        }
        if ($request->file('file')->getSize() > 10 * 1024 * 1024) {
            return response()->json(['error' => 'File terlalu besar. Ukuran file maksimal adalah 10MB'], 422);
        }
        $tasks = Tugas::findOrFail($id);
        $files = $request->file('file');
        $files->storeAs('/images/projects/tugas', $filename, 'public');
        $tasks->file = $filename;
        $tasks->save();

        return response()->json(['success' => "Berhasil Menyelesaikan Tugas $tasks->nama_tugas"], 200);
    }

}
