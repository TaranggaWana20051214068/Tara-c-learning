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
        'judul',
        'deskripsi',
    ];


    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function codes()
    {
        return $this->hasMany(Code::class);
    }
}
