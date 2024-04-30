<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $fillable = [
        'nama_tugas',
        'deskripsi',
        'nilai',
        'catatan',
        'deadline',
        'file',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'tugas_id');
    }
}
