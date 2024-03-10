<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeLink extends Model
{
    protected $fillable = ['article_id', 'link', 'title', 'description'];

    // Definisikan relasi dengan model Article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
