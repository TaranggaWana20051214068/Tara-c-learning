<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'q_question_id',
        'choice_id',
    ];
    public function quizQuestion()
    {
        return $this->belongsTo(QuizQuestion::class, 'q_question_id');
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class, 'choice_id');
    }
}