<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaguController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\LaguPlaylistController;

//AUTHENTIKASI
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    //API SOURCE
    Route::apiResource('/lagu', LaguController::class);
    Route::apiResource('/playlist', PlaylistController::class);

    //LAGU
    Route::post('/lagu', [LaguController::class, 'store']);
    Route::get('/lagu', [LaguController::class, 'getAllSongs']);

    //PLAYLIST
    Route::get('/playlist', [PlaylistController::class, 'index']);

    //LAGU PLAYLIST
    Route::get('/playlist/{playlist_id}/lagu', [LaguPlaylistController::class, 'index']);
    Route::post('/playlist/{playlistId}/lagu', [LaguPlaylistController::class, 'addSongToPlaylist']);
    Route::delete('/laguplaylist/{playlist_id}/lagu/{lagu_id}', [LaguPlaylistController::class, 'destroy']);
    Route::post('/playlist/{id}/add-song', [LaguPlaylistController::class, 'addSongToPlaylist']);
    Route::delete('/playlist/{playlistId}/remove-song/{laguId}', [LaguPlaylistController::class, 'removeSongFromPlaylist']);
    Route::get('/playlist/{playlistId}', [LaguPlaylistController::class, 'getPlaylistDetail']);

    //user
    Route::get('/user', function (Request $request) {
        return $request->user();
        });
    });

    // Rute untuk mendapatkan CSRF token
    Route::get('/sanctum/csrf-cookie', function () {
        return response()->json(['message' => 'CSRF token set']);
    });
