<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\YoutubeLink;

class UrlController extends Controller
{
    public function store(Request $request)
    {
        // Validasi request jika diperlukan
        $validatedData = $request->validate([
            'url' => 'required|url',
            'id' => 'required'
        ]);

        // Simpan URL ke dalam database atau tempat penyimpanan lainnya
        // Misalnya:
        $url = $validatedData['url'];
        $id = $validatedData['id'];
        YoutubeLink::create([
            'article_id' => $id,
            'link' => $url,
            // Tambahkan kolom-kolom lain yang diperlukan
        ]);
        // Lakukan penyimpanan ke dalam database atau tempat penyimpanan lainnya

        // Berikan respons yang sesuai ke klien
        return response()->json(['message' => 'URL berhasil disimpan'], 200);
    }
}
