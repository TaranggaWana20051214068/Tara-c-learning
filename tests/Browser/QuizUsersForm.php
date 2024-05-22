<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class QuizUsersForm extends DuskTestCase
{
    /**
     * Ujian Dusk untuk menghantar jawapan kuiz oleh 10 pengguna serentak.
     *
     * @return void
     */
    public function testMultipleUsersSubmittingQuizAnswers()
    {
        // Cipta 10 pengguna ujian
        $users = User::factory()->count(10)->create();

        $this->browse(function (Browser $browser) use ($users) {
            foreach ($users as $index => $user) {
                $browser->loginAs($user)
                    ->visit('/quizs/php/') // Gantikan dengan URL form kuiz anda
                    ->assertSee('quiz') // Pastikan teks "Kuiz" dilihat di halaman

                    // Mengisi jawapan ke dalam form
                    ->type('answers[1]', 'choice_' . ($index + 1))
                    ->type('answers[2]', 'choice_' . ($index + 1))
                    ->type('answers[3]', 'choice_' . ($index + 1))
                    // Tambahkan lebih banyak isian jika diperlukan

                    ->press('Submit') // Klik butang hantar
                    ->assertPathIs('/path/to/confirmation') // Pastikan dihalakan ke halaman pengesahan
                    ->assertSee('Terima kasih'); // Pastikan mesej pengesahan dilihat
            }
        });
    }
}

