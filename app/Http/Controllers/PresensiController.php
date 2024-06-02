<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $userName = Auth::user()->name;
        $check = DB::table('presensis')->where([['tgl_presensi', $today], ['name', $userName]])->count();
        $name = Auth::user()->name;
        $presensi = DB::table('presensis')->where([
            ['tgl_presensi', $today],
            ['name', $userName]
        ])->first();
        // history
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return view('presensi.index', compact('check', 'monthName', 'presensi'));
    }

    public function store(Request $request)
    {
        $name = Auth::user()->name;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');

        $check = DB::table('presensis')->where([['tgl_presensi', $tgl_presensi], ['name', $name]])->count();

        # To store different file name
        if ($check > 0) {
            $writeName = "out";
        } else {
            $writeName = "in";
        }

        # Check data exist or not
        if ($check > 0) {
            $data_pulang = [
                'jam_out' => $jam
            ];
            $post = DB::table('presensis')->where([['tgl_presensi', $tgl_presensi], ['name', $name]])->update($data_pulang);
            if ($post) {
                echo "success|Good bye, take care!|out";
            } else {
                echo "error|Oops, data failed to save!|out";
            }
        } else {
            $data_masuk = [
                'name' => $name,
                'tgl_presensi' => $tgl_presensi,
                'jam_in' => $jam
            ];
            $post = DB::table('presensis')->insert($data_masuk);
            if ($post) {
                echo "success|Thank you, happy learning!|in";
            } else {
                echo "error|Oops, data failed to save!|in";
            }

        }

    }

    public function history()
    {
        $monthName = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return view('presensi.history', compact('monthName'));
    }

    public function getHistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $name = Auth::user()->name;

        $history = DB::table('presensis')
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->where('name', $name)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.get-history', compact('history'));
    }
    public function getIzin()
    {
        $name = Auth::user()->name;
        $datas = DB::table('pengajuan_izins')->where('name', $name)->get();

        return view('presensi.get-izin', compact('datas'));
    }

    public function storeizin(Request $request)
    {
        $post = DB::table('pengajuan_izins')->insert([
            'name' => Auth::user()->name,
            'tgl_izin' => $request->tgl_izin,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'status_approved' => 0
        ]);

        if ($post) {
            return redirect()->back()->with(['success' => 'Data berhasil disimpan!']);
        } else {
            return redirect()->back()->with(['error' => 'Data gagal disimpan!']);
        }
    }
}
