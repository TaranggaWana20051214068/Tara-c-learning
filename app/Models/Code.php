<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'output',
        'score',
        'user_id',
        'author_id',
        'question_id',
        'kode',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
