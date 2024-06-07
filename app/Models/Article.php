<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
    public function youtubeLinks()
    {
        return $this->hasMany(YoutubeLink::class);
    }
}
