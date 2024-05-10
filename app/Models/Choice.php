<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    protected $fillable = [
        'q_question_id',
        'choice_text',
        'is_correct'
    ];
    public function quizQuestion()
    {
        return $this->belongsTo(QuizQuestion::class, 'q_question_id');
    }
}
