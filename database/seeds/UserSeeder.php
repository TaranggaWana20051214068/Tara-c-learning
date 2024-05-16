<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'tara',
            'username' => 'tarangga11@gmail.com',
            'password' => Hash::make('tara11'),
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'wana',
            'username' => 'wana49@gmail.com',
            'password' => Hash::make('wana11'),
            'role' => 'guru',
        ]);
    }
}
