<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'students';
    protected $fillable = ['name', 'description', 'image_name'];
    protected $attributes = [
        'image_name' => 'default.png',
        'description' => null,
    ];
}
