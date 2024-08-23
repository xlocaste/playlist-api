<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaguPlaylist extends Model
{
    use HasFactory;

    protected $table = 'laguplaylist';

    public function lagu()
    {
        return $this->belongsTo(Lagu::class);
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
