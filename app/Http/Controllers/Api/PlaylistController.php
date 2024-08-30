<?php

namespace App\Http\Controllers\Api;

use App\Models\Playlist;
use App\Http\Requests\PlaylistRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    // Menampilkan daftar playlist milik user yang sedang login
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

    // Menyimpan playlist baru untuk user yang sedang login
    public function store(PlaylistRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $playlist = new Playlist();
        $playlist->user_id = $user->id;
        $playlist->title = $request->title;
        $playlist->save();

        return response()->json([
            'success' => true,
            'message' => 'Playlist berhasil dibuat!',
            'data'    => $playlist
        ]);
    }

    // Menampilkan playlist tertentu milik user yang sedang login beserta lagu-lagunya
    public function show($id)
    {
        $playlist = Playlist::with('lagu')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $playlist
        ]);
    }

    // Memperbarui playlist milik user yang sedang login
    public function update(PlaylistRequest $request, $id)
    {
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $playlist->update([
            'title' => $request->title,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Playlist berhasil diubah!',
            'data'    => $playlist,
        ]);
    }

    // Menghapus playlist milik user yang sedang login
    public function destroy($id)
    {
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $playlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Playlist berhasil dihapus!',
        ]);
    }

    // Menambahkan lagu ke dalam playlist milik user yang sedang login
    public function addSongToPlaylist(Request $request, $playlistId)
    {
        $request->validate([
            'lagu_id' => 'required|integer|exists:lagu,id',
        ]);

        $playlist = Playlist::where('id', $playlistId)->where('user_id', Auth::id())->firstOrFail();
        $laguId = $request->input('lagu_id');

        try {
            $playlist->lagu()->attach($laguId);
            return response()->json([
                'success' => true,
                'message' => 'Lagu berhasil ditambahkan ke playlist!',
                'data'    => $playlist->load('lagu')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Terjadi kesalahan saat menambahkan lagu ke playlist',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
