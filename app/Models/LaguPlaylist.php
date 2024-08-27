<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaguPlaylist extends Model
{
    use HasFactory;

    protected $table = 'laguplaylist';

    protected $fillable = [
        'id',
        'lagu_id',
        'playlist_id',
    ];

    public function lagu()
    {
        return $this->belongsTo(Lagu::class);
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
