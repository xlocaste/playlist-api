<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Lagu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LaguPlaylistController extends Controller
{
    public function addSongToPlaylist(Request $request, $id)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token tidak ditemukan!'], 401);
        }

        $validator = Validator::make($request->all(), [
            'lagu_id' => 'required|exists:lagu,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $playlist = Playlist::find($id);

        if (!$playlist) {
            return response()->json(['message' => 'Playlist tidak ditemukan!'], 404);
        }

        $laguId = $request->input('lagu_id');

        // Cek apakah lagu sudah ada dalam playlist
        if ($playlist->lagu->contains($laguId)) {
            return response()->json(['message' => 'Lagu sudah ada dalam playlist!'], 400);
        }

        // Tambahkan lagu ke playlist
        $playlist->lagu()->attach($laguId);

        return response()->json(['message' => 'Lagu berhasil ditambahkan ke playlist!'], 200);
    }

    // Menghapus lagu dari playlist
    public function removeSongFromPlaylist($playlistId, $laguId)
    {
        $playlist = Playlist::find($playlistId);

        if (!$playlist) {
            return response()->json([
                'message' => 'Playlist not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $lagu = Lagu::find($laguId);

        if (!$lagu) {
            return response()->json([
                'message' => 'Song not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Menghapus lagu dari playlist
        $playlist->lagu()->detach($lagu->id);

        return response()->json([
            'message' => 'Song removed from playlist successfully'
        ], Response::HTTP_OK);
    }

    // Mendapatkan detail playlist termasuk lagu-lagu yang sudah ditambahkan
    public function getPlaylistDetail($playlistId)
    {
        $playlist = Playlist::with('lagu')->find($playlistId);

        if (!$playlist) {
            return response()->json([
                'message' => 'Playlist not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Tambahkan URL penuh untuk file MP3
        $playlist->lagu->each(function($lagu) {
            $lagu->mp3_url = url('storage/' . $lagu->mp3); // Assuming mp3 is stored in storage/app/public
        });

        return response()->json([
            'data' => $playlist
        ], Response::HTTP_OK);
    }

}
