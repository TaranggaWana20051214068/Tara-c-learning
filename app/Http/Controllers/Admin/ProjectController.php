<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Attachment;
use App\Models\Kelompok;
use Storage;
use Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $projects = Project::where('judul', 'LIKE', "%$search%")->orderBy('id', 'desc')->paginate(10);
        $projects->appends(['search' => $search]);

        // Check if there are any tasks with project_id from the projects table
        $projectIds = $projects->pluck('id');
        $cekTugas = Tugas::whereIn('project_id', $projectIds)
            ->get()
            ->groupBy('project_id')
            ->map(function ($tasks) {
                return $tasks->count() > 0;
            });

        return view('admin.projects.index', compact('projects', 'cekTugas'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projects = Project::findOrFail($id);
        $tugas = Tugas::where('project_id', $id)->with('attachments')->get();

        // Get attachments for the tasks
        $attachmentIds = $tugas->pluck('id');
        $attachments = Attachment::whereIn('tugas_id', $attachmentIds)->get();

        return view('admin.projects.tugas', compact('projects', 'tugas', 'attachments', 'id'));
    }



    public function create()
    {
        return view('admin.projects.add');
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
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $project = new Project();
        $project->judul = $request->judul;
        $project->deskripsi = $request->deskripsi;

        $photo = $request->file('thumbnail');
        $image_extension = $photo->extension();
        $image_name = Str::slug($request->judul) . "." . $image_extension;
        $photo->storeAs('/images/projects', $image_name, 'public');
        $project->thumbnail = $image_name;
        $project->save();

        session()->flash('success', "Sukses tambah Project $request->judul");
        return redirect()->route('admin.projects.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.projects.edit', compact('project'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $project = Project::find($id);
        $project->judul = $request->judul;
        $project->deskripsi = $request->deskripsi;
        if ($request->hasFile('thumbnail')) {
            Storage::delete('public/images/projects/' . $project->thumbnail);
            $photo = $request->file('thumbnail');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->judul) . "." . $image_extension;
            $photo->storeAs('/images/projects', $image_name, 'public');
            $project->thumbnail = $image_name;
        }
        $project->save();

        session()->flash('success', "Sukses update project $request->judul");
        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Project::findOrFail($id);
        $subject->delete();

        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }
    public function tugas(Request $request, $id)
    {
        if ($request->jenis === "add") {
            $request->validate([
                'judul' => 'required',
                'deskripsi' => 'required',
                'deadline' => 'required',
                'project_id' => 'required'
            ]);
            $tugas = new Tugas();
            $tugas->nama_tugas = $request->judul;
            $tugas->deskripsi = $request->deskripsi;
            $tugas->deadline = $request->deadline;
            $tugas->project_id = $request->project_id;
            $tugas->save();
            session()->flash('success', "Sukses tambah Tugas $request->judul");
            return redirect()->back();
        } else if ($request->jenis === "edit") {
            $request->validate([
                'judul' => 'required',
                'deskripsi' => 'required',
                'deadline' => 'required',
                'tugas_id' => 'required',
            ]);
            $create = Tugas::find($id)->update([
                'nama_tugas' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'deadline' => $request->deadline,
            ]);
            $tugas = Tugas::findOrFail($id);
            session()->flash('success', "Sukses Update Tugas $request->judul");
            return redirect()->route('admin.projects.show', ['project' => $tugas->project_id]);
        } else if ($request->jenis === "nilai") {
            $request->validate([
                'nilai' => 'required|numeric|between:1,100',
                'catatan' => 'required|string'
            ]);
            $tugas = Tugas::findorFail($id);
            $tugas->nilai = $request->nilai;
            $tugas->catatan = $request->catatan;
            $tugas->save();
            session()->flash('success', "Sukses Menilai Tugas $tugas->nama_tugas");
            return redirect()->back();
        } else {
            $tugas = Tugas::findOrFail($id);
            $tugas->delete();
            session()->flash('success', 'Sukses Menghapus Data');
            return redirect()->back();
        }
    }
    public function editTugas($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('admin.projects.editTugas', compact('tugas'));
    }
    public function siswaShow(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $search = $request->get('search');
        $students = Kelompok::where('project_id', $id)
            ->where('nama_siswa', 'LIKE', "%$search%")
            ->orderBy('id', 'desc')
            ->paginate(10);
        $students->appends(['search' => $search]);
        return view('admin.projects.detail', compact('students', 'project'));
    }

    public function siswa($id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $kelompok->delete();
        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }
}
