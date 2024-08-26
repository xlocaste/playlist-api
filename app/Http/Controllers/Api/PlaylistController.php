<?php

namespace App\Http\Controllers\Api;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $playlists = Playlist::where('user_id', $user->id)->latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List Data Playlist',
            'data'    => $playlists
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $playlist = new Playlist();
        $playlist->user_id = $user->id;
        // Lanjutkan dengan penyimpanan playlist
    }

    public function show($id)
    {
        $playlist = Playlist::with('lagu')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($playlist);
    }

    public function update(Request $request, Playlist $playlist)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Ensure that the playlist belongs to the authenticated user
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $playlist->update([
            'title' => $request->title,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Playlist Berhasil Diubah!',
            'data'    => $playlist,
        ]);
    }

    public function destroy(Playlist $playlist)
    {
        // Ensure that the playlist belongs to the authenticated user
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $playlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Playlist Berhasil Dihapus!',
        ]);
    }

    public function addSongToPlaylist(Request $request, $playlistId)
    {
        $request->validate([
            'lagu_id' => 'required|integer|exists:lagu,id',
        ]);

        $playlist = Playlist::where('id', $playlistId)->where('user_id', Auth::id())->firstOrFail();
        $laguId = $request->input('lagu_id');

        try {
            $playlist->lagu()->attach($laguId);
            return response()->json($playlist->load('lagu'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menambahkan lagu ke playlist', 'details' => $e->getMessage()], 500);
        }
    }
}
