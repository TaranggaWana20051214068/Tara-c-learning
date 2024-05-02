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
    ];

    public function kelompok()
    {
        return $this->hasOne(Kelompok::class);
    }


    public function tugas()
    {
        return $this->hasMany('App\Tugas');
    }
}
