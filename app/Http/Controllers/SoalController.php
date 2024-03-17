<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SoalController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Periksa apakah user_api_token kosong
        if (empty ($user->user_api_token)) {
            // Jika kosong, panggil fungsi createUser() untuk membuat pengguna baru
            $apiToken = $this->createUser($user->name, $user->email);

            // Simpan user_api_token yang diperoleh ke dalam kolom user_api_token dalam tabel users
            if ($apiToken) {
                $user->update(['user_api_token' => $apiToken]);

                // Lanjutkan dengan menampilkan halaman soal atau melakukan tindakan lain yang diperlukan
                session()->flash('success', 'User Berhasil Ditambahkan.');
            } else {
                // Tangani jika terjadi kesalahan saat membuat pengguna
                session()->flash('error', 'Gagal membuat pengguna baru. Silakan coba lagi.');
            }
        }
    }

    public function createUser($name, $email)
    {
        $client = new Client();
        $url = 'https://onecompiler.com/api/v1/createUser';
        $accessToken = env('API_KEY_COMPILER');

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => [
                    'name' => $name,
                    'email' => $email,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            // Simpan data yang diperlukan dari respon
            if (isset ($body['api']['token'])) {
                return $body['api']['token'];
            } else {
                return null;
            }
        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi saat mengirim permintaan
            return null;
        }
    }

}
