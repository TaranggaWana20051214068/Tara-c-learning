<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use DB;
use Auth;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $siswa = Student::pluck('name');
        return view('admin.presensis.index', compact('monthName', 'siswa'));
    }
    public function getHistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $name = $request->name;

        $query = DB::table('presensis')->orderBy('tgl_presensi');
        if (empty($bulan)) {
            $query->whereRaw('YEAR(tgl_presensi) = ?', [$tahun]);
        } else {
            $query->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
                ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun]);
        }
        if (!empty($name)) {
            $query->where('name', $name);
        }

        $history = $query->get();

        return view('admin.presensis.get-history', compact('history'));
    }

    public function show(Request $request)
    {
        $search = $request->get('search');
        $approv = $request->approv;

        $students = DB::table('pengajuan_izins')
            ->where(function ($query) use ($search, $approv) {
                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('status_approved', $approv);
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        $students->appends(['search' => $search, 'approv' => $approv]);

        return view('admin.presensis.detail', compact('students'));
    }

    public function storeIzin(Request $request)
    {

        try {
            $updated = DB::table('pengajuan_izins')
                ->where('id', $request->id)
                ->update(['status_approved' => 1]);

            if ($updated) {
                return redirect()->back()->with(['success' => 'Data berhasil disimpan!']);
            } else {
                return redirect()->back()->with(['error' => 'Data gagal disimpan!']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


}
