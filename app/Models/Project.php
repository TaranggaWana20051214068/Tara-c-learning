<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
        'periode_id',
        'subject_id',
    ];

    public function kelompok()
    {
        return $this->hasOne(Kelompok::class);
    }


    public function tugas()
    {
        return $this->hasMany('App\Tugas');
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
