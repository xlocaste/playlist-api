<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lagu;
use App\Models\Playlist;
use App\Models\LaguPlaylist;
use Illuminate\Http\Request;

class LaguPlaylistController extends Controller
{
    // Get all songs in a playlist
    public function index($playlist_id)
    {
        $songs = Playlist::findOrFail($playlist_id)->lagu;
        return response()->json($songs);
    }


    // Remove a song from a playlist
    public function destroy($playlist_id, $lagu_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $playlist->lagu()->detach($lagu_id);

        return response()->json(null, 204);
    }


    // Get all songs
    public function getAllSongs()
    {
        // Mengambil semua lagu dari database
        $lagu = Lagu::all();
        return response()->json($lagu);
    }

    public function addSongToPlaylist(Request $request, $playlistId)
    {
        // Validasi input
        $request->validate([
            'lagu_id' => 'required|integer|exists:lagu,id',
        ]);

        // Temukan playlist berdasarkan ID
        $playlist = Playlist::findOrFail($playlistId);

        // Ambil ID lagu dari request
        $laguId = $request->input('lagu_id');

        // Tambahkan lagu ke playlist
        $playlist->lagu()->attach($laguId);

        // Muat kembali playlist dengan lagu-lagunya
        return response()->json($playlist->load('lagu'));
    }
}
