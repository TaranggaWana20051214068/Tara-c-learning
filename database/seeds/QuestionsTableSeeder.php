<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\User;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        Question::insert([
            'judul' => 'html',
            'deskripsi' => 'Deskripsi pertanyaan 1',
            'author_id' => User::inRandomOrder()->first()->id,
            'article_id' => 1, // Sesuaikan dengan id artikel yang relevan jika ada
            'created_at' => now(),
        ]);
        Question::insert([
            'judul' => 'css',
            'deskripsi' => 'Deskripsi pertanyaan 2',
            'author_id' => User::inRandomOrder()->first()->id,
            'article_id' => 2,
            'created_at' => now(),
        ]);
        Question::insert([
            'judul' => 'php',
            'deskripsi' => 'Deskripsi pertanyaan 3',
            'author_id' => User::inRandomOrder()->first()->id,
            'article_id' => 3,
            'created_at' => now(),
        ]);
    }
}