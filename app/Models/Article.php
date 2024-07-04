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

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
