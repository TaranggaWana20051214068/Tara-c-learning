<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'user_id',
        'status_hasil',
        'score',
        'access_code',
        'tab_changes',
        'completed_by',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenges::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
