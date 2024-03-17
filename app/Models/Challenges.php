<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Challenges extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'markdown',
        'problem_type',
        'score',
        'challenges_id',
        'validations',
        'created_by',
        'article_id',
    ];

    protected $casts = [
        'validations' => 'array',
    ];
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
