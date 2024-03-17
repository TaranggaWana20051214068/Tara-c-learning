<?php



use Illuminate\Database\Seeder;
use App\Models\Challenges;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Challenges::create([
            'title' => 'Challenge 1',
            'markdown' => 'Deskripsi dari Challenge 1',
            'problem_type' => 'code',
            'score' => 10,
            'challenges_id' => '427bmqm2t',
            'validations' => json_encode([
                // Contoh validasi
                [
                    'id' => 1,
                    'input' => '5',
                    'output' => 'odd',
                    'label' => 'easy'
                ],
                [
                    'id' => 2,
                    'input' => '6',
                    'output' => 'even',
                    'label' => 'medium'
                ]
            ]),
            'author_id' => 1, // Ganti dengan id pengguna yang membuat tantangan
            'article_id' => 1, // Ganti dengan id artikel terkait jika ada
        ]);
    }
}
