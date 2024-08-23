<?php

namespace App\Http\Controllers\Api;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaylistResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Lagu;


class PlaylistController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $playlist = Playlist::latest()->paginate(5);

        //return collection of playlist as a resource
        return new PlaylistResource(true, 'List Data Playlist', $playlist);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create playlist
        $playlist = Playlist::create([
            'title'     => $request->title,
        ]);

        //return response
        return new PlaylistResource(true, 'Data Playlist Berhasil Ditambahkan!', $playlist);
    }

    /**
     * show
     *
     * @param  mixed $playlist
     * @return void
     */
    public function show($id)
    {
        $playlist = Playlist::with('lagu')->findOrFail($id);
        return response()->json($playlist);
    }

    /**
     * update
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Playlist $playlist)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update playlist with new title
        $playlist->update([
            'title' => $request->title,
        ]);

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Data Playlist Berhasil Diubah!',
            'data'    => $playlist,
        ]);
    }


    /**
     * destroy
     *
     * @param  mixed $playlist
     * @return void
     */
    public function destroy(Playlist $playlist)
    {
        //delete playlist
        $playlist->delete();

        //return response
        return new PlaylistResource(true, 'Data Playlist Berhasil Dihapus!', null);
    }

    // Controller (PlaylistController.php)
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

        try {
            // Tambahkan lagu ke playlist
            $playlist->lagu()->attach($laguId);

            // Muat kembali playlist dengan lagu-lagunya
            return response()->json($playlist->load('lagu'), 200);
        } catch (QueryException $e) {
            // Tangani kesalahan query
            return response()->json(['error' => 'Terjadi kesalahan saat menambahkan lagu ke playlist', 'details' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            return response()->json(['error' => 'Terjadi kesalahan saat menambahkan lagu ke playlist', 'details' => $e->getMessage()], 500);
        }
    }

}
