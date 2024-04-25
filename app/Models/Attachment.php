<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Attachment extends Model
{
    protected $fillable = [
        'file_name',
        'timestamp',
        'user_id',
        'tugas_id',
    ];

    public function tugas()
    {
        return $this->belongsTo('App\Tugas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
