<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_id',
        'article_id',
        'judul',
        'deskripsi',
        'bahasa',
        'periode_id',
        'subject_id',
    ];


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function article_title()
    {
        return $this->belongsTo(User::class, 'article_id');
    }
    public function codes()
    {
        return $this->hasMany(Code::class);
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
