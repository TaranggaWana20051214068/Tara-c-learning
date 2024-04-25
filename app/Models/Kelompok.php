<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    protected $fillable = [
        'nama_siswa',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
