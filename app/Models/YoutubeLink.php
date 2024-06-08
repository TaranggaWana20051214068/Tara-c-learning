<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cohensive\OEmbed\Facades\OEmbed;

class YoutubeLink extends Model
{
    protected $fillable = ['article_id', 'link', 'title'];

    // Definisikan relasi dengan model Article
    public static $rules = [
        'link' => 'required|url',
    ];

    public static $messages = [
        'link.required' => 'Link YouTube wajib diisi.',
        'link.url' => 'Link YouTube tidak valid.',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Validasi unik untuk link berdasarkan artikel
    public function rules()
    {
        return array_merge(self::$rules, [
            'link' => 'unique:youtube_links,link,NULL,id,article_id,' . $this->article_id
        ]);
    }

    public function getEmbedCode()
    {
        if ($this->link) {
            $embed = OEmbed::get($this->link);
            if ($embed) {
                return $embed->html(['width' => 250, 'height' => 150]);
            }
        }
        return null;
    }

    public function messages()
    {
        return self::$messages;
    }
}
