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
        'file',
        'periode_id',
        'subject_id',
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
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
