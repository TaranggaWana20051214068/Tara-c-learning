<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Str;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $users = User::where('name', 'LIKE', "%$search%")->orWhere('username', 'LIKE', "%$search%")->orderBy('id', 'asc')->paginate(10);
        $users->appends(['search' => $search]);
        $roles = ['admin', 'guru', 'siswa'];
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = ['guru', 'siswa'];

        return view('admin.users.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|email',
            'roles' => 'required',
            'image_name' => 'nullable'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->roles;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->hasFile('image_name')) {
            $photo = $request->file('image_name');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->name) . "." . $image_extension;
            $photo->storeAs('/images/faces', $image_name, 'public');
            $user->profile_pic = $image_name;
        }
        $user->save();
        if ($request->roles === 'siswa') {
            $student = new Student;
            $student->name = $request->name;
            $student->description = '';
            if ($request->hasFile('image_name')) {
                $photo = $request->file('image_name');
                $image_extension = $photo->extension();
                $image_name = Str::slug($request->name) . "." . $image_extension;
                $photo->storeAs('/images/students', $image_name, 'public');
            }
            $student->image_name = $request->hasFile('image_name') ? $image_name : 'default.png';
            $student->save();
        }

        session()->flash('success', "Sukses tambah data user $request->name");
        return redirect()->route('admin.users.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
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
            'name' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'email' => 'required|email'
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        if ($request->hasFile('photo')) {
            Storage::delete('public/images/faces/' . $user->profile_pic);
            $photo = $request->file('photo');
            $image_extension = $photo->extension();
            $image_name = Str::slug($request->name) . "." . $image_extension;
            $photo->storeAs('/images/faces', $image_name, 'public');
            $user->profile_pic = $image_name;
        }
        $user->save();

        session()->flash('success', "Sukses ubah data user $request->name");
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();
        if ($user->role === 'siswa') {
            $siswa = Student::where('name', $name)->first();
            ($siswa > 0) ? $siswa->delete() : '';
        }
        session()->flash('success', 'Sukses Menghapus Data');
        return redirect()->back();
    }
}
