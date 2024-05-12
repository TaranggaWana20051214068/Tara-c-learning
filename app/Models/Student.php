<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = ['name', 'description', 'image_name'];
    protected $attributes = [
        'image_name' => 'default.png',
        'description' => null,
    ];
}
