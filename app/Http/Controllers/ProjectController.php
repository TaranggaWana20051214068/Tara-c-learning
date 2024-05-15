<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Kelompok;
use App\Models\Tugas;
use App\User;
use Str;
use App\Models\Attachment;
use App\Models\logbooks;

class ProjectController extends Controller
{
    public function joinProject($id)
    {
        $user = auth()->user();
        $project = Project::findOrFail($id);

        // Membuat Kelompok baru
        $kelompok = new Kelompok();
        $kelompok->nama_siswa = $user->name;
        $kelompok->project_id = $id;
        $kelompok->save();

        // Menambahkan pengguna ke kelompok
        $kelompok->users()->attach($user->id);
        return response()->json(['success' => "Berhasil gabung kelas $project->judul"], 200);
    }

    public function projects_show($id)
    {
        $project = Project::findOrFail($id);
        $taskss = Tugas::where('project_id', $id)
            ->with('attachments')
            ->get();
        $tasks = $taskss->filter(function ($task) {
            return $task->attachments->isNotEmpty();
        });
        $incompleteTasks = $taskss->filter(function ($task) {
            return $task->attachments->isEmpty();
        });
        $nextTask = $incompleteTasks->first();
        $kelompok = $project->kelompok;
        $users = User::whereHas('kelompok', function ($query) use ($id) {
            $query->where('project_id', $id);
        })->get();
        $attachments = Attachment::whereIn('tugas_id', $taskss->pluck('id'))->get();
        $progress = $taskss->count() > 0 ? ($tasks->count() / $taskss->count()) * 100 : 0;
        $jadwal = logbooks::where('project_id', $id)->get();
        return view('projects.detail', compact('project', 'nextTask', 'tasks', 'users', 'attachments', 'progress', 'jadwal'));
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

        // Membuat instance baru dari model Attachment
        $attachment = new Attachment;
        $attachment->file_name = $filename;
        $attachment->user_id = auth()->id();
        $attachment->tugas_id = $tasks->id;
        $attachment->save();

        return response()->json(['success' => "Berhasil Menyelesaikan Tugas $tasks->nama_tugas"], 200);
    }
    public function projects_jadwal(Request $request, $id)
    {
        if (!$request->title) {
            return response()->json(['error' => 'title tidak boleh kosong'], 422);
        } else if (!$request->description) {
            return response()->json(['error' => 'deskripsi tidak boleh kosong'], 422);
        } else if (!$request->date) {
            return response()->json(['error' => 'tanggal tidak boleh kosong'], 422);
        }
        $userId = auth()->id();
        $logbook = new logbooks();
        $logbook->title = $request->title;
        $logbook->description = $request->description;
        $logbook->date = $request->date;
        $logbook->project_id = $id;
        $logbook->user_id = $userId;
        $logbook->save();

        return response()->json(['success' => "Berhasil Membuat $request->title"], 200);
    }


}
