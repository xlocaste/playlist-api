<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $table = 'playlist';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public function lagu()
    {
        return $this->belongsToMany(Lagu::class, 'laguplaylist', 'playlist_id', 'lagu_id');
    }

}
