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
        session()->flash('success', 'Berhasil gabung kelas ' . $project->judul);
        return redirect()->back();
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
        })->with('kelompok')->get();
        $attachments = Attachment::whereIn('tugas_id', $taskss->pluck('id'))->get();
        $progress = $taskss->count() > 0 ? ($tasks->count() / $taskss->count()) * 100 : 0;
        $jadwal = logbooks::where('project_id', $id)->paginate(10);
        return view('projects.detail', compact('project', 'nextTask', 'tasks', 'users', 'attachments', 'progress', 'jadwal'));
    }

    public function projects_tugas(Request $request, $id)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:102400'
            ],
        ]);
        $tasks = Tugas::findOrFail($id);
        $files = $request->file('file');
        $image_extension = $files->extension();
        $filename = $id . "-" . $tasks->project->judul . "." . $image_extension;
        $files->storeAs('/images/projects/tugas', $filename, 'public');

        // Membuat instance baru dari model Attachment
        $attachment = new Attachment;
        $attachment->file_name = $filename;
        $attachment->user_id = auth()->id();
        $attachment->tugas_id = $tasks->id;
        $attachment->save();
        session()->flash('success', 'Berhasil Menyelesaikan Tugas ' . $tasks->nama_tugas);
        return redirect()->back();
    }
    public function projects_jadwal(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);
        $userId = auth()->id();
        $logbook = new logbooks();
        $logbook->title = $request->title;
        $logbook->description = $request->description;
        $logbook->date = $request->date;
        $logbook->project_id = $id;
        $logbook->user_id = $userId;
        $logbook->save();
        session()->flash('success', 'Berhasil Membuat Jadwal ' . $request->title);
        return redirect()->back();
    }

    public function role(Request $request, $id)
    {
        $request->validate([
            'roles' => 'required|array',
        ]);

        foreach ($request->roles as $userId => $role) {
            if ($role == null) {
                session()->flash('error', 'Lengkapi Role');
                return redirect()->back();
            }
        }
        $updatedUsers = [];

        foreach ($request->roles as $userId => $role) {
            $kelompok = Kelompok::whereHas('users', function ($query) use ($id, $userId) {
                $query->where('project_id', $id);
                $query->where('user_id', $userId);
            })->first();
            $kelompok->krole = $role;
            $kelompok->save();
            $user = User::findOrFail($userId);
            $updatedUsers[] = $user->name;
        }

        session()->flash('success', 'Berhasil ' . implode(', ', array_map(function ($name) {
            return "'$name'";
        }, $updatedUsers)) . ' berhasil diubah');

        session()->flash('success', 'Berhasil' . ' ' . implode(', ', $updatedUsers) . ' ' . 'berhasil diubah');
        return redirect()->back();
    }



    public function jadwal_destroy(logbooks $logbooks)
    {
        $logbooks->delete();
        session()->flash('success', 'Berhasil Menghapus');
        return redirect()->back();
    }
}
