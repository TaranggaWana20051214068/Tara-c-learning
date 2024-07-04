<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $search = request()->query('search');
        $periode = Periode::where('tahun', 'LIKE', "%$search%")->where('semester', 'LIKE', "%$search%")->orderBy('id', 'asc')->paginate(10);
        $periode->appends(['search' => $search]);
        return view('admin.periode.index', compact('periode'));
    }

    public function create()
    {
        return view('admin.periode.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'status' => 'required',
        ]);
        // Cek apakah sudah ada periode dengan status aktif
        if ($request->status == 1) {
            $existingActiveperiode = Periode::where('status', 1)->first();
            if ($existingActiveperiode) {
                session()->flash('error', "Gagal tambah periode $request->tahun $request->semester. Sudah ada periode aktif. Silakan nonaktifkan periode tersebut terlebih dahulu. ");
                return redirect()->back();
            }
        }
        $create = Periode::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);
        session()->flash('success', "Sukses tambah periode $request->tahun $request->semester");
        return redirect()->route('admin.periode.index');
    }

    public function edit($id)
    {
        $periode = Periode::find($id);
        $semester = ['ganjil', 'genap'];
        $status = ['aktif' => 1, 'nonaktif' => 0];
        return view('admin.periode.edit', compact('periode', 'semester', 'status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'status' => 'required',
        ]);
        // Cek apakah sudah ada periode dengan status aktif
        if ($request->status == 1) {
            $existingActiveperiode = Periode::where('status', 1)->first();
            if ($existingActiveperiode) {
                session()->flash('error', "Gagal tambah periode $request->tahun $request->semester. Sudah ada periode aktif. Silakan nonaktifkan periode tersebut terlebih dahulu. ");
                return redirect()->back();
            }
        }
        $create = Periode::find($id)->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);
        session()->flash('success', "Sukses update periode $request->tahun $request->semester");
        return redirect()->route('admin.periode.index');
    }

    public function destroy($id)
    {
        $periode = Periode::find($id);
        if ($periode->status == 1) {
            session()->flash('error', "Gagal hapus periode $periode->tahun $periode->semester. Periode ini sedang aktif. Silakan nonaktifkan periode tersebut terlebih dahulu. ");
            return redirect()->back();
        }
        $periode->delete();
        session()->flash('success', "Sukses hapus periode $periode->tahun $periode->semester");
        return redirect()->back();
    }
}
