<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan',
        'category',
        'file'
    ];
    protected $table = 'quiz_questions';
    public function choices()
    {
        return $this->hasMany(Choice::class, 'q_question_id');
    }
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'q_question_id');
    }
}
