<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Tugas extends Model
{
    protected $fillable = [
        'nama_tugas',
        'deskripsi',
        'nilai',
        'catatan',
        'deadline',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'tugas_id');
    }
}
