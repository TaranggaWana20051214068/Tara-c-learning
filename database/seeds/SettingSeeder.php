<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            ['key' => 'WEB_TITLE', 'value' => 'C-Learning'],
            ['key' => 'WEB_LOGO_WHITE', 'value' => 'logo_white.png'],
            ['key' => 'WEB_LOGO', 'value' => 'logo.png'],
            ['key' => 'WEB_FAVICON', 'value' => 'favicon.png'],
            ['key' => 'HERO_TEXT_HEADER', 'value' => 'Selamat Datang di'],
            ['key' => 'HERO_TEXT_DESCRIPTION', 'value' => 'C-Learning adalah media pembelajaran yang dapat kamu akses sebagai sumber referensi materi serta dilengkapi berbagai latihan soal yang memudahkan kamu dalam proses pembelajaran.'],
            ['key' => 'HERO_BACKGROUND_IMAGE', 'value' => 'cool-background.svg'],
        ]);
    }
}
