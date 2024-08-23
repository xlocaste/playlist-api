<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lagu extends Model
{
    use HasFactory;

    protected $table = 'lagu';

    protected $fillable = [
        'mp3',
        'title',
    ];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'laguplaylist', 'lagu_id', 'playlist_id');
    }
}
