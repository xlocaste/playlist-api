<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaguController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\LaguPlaylistController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/lagu', LaguController::class);
    Route::post('/lagu', [LaguController::class, 'store']);
    Route::get('/lagu', [LaguController::class, 'getAllSongs']);
    Route::post('/playlist/{id}/lagu', [PlaylistController::class, 'addSongToPlaylist']);
    Route::apiResource('/playlist', PlaylistController::class);
    Route::get('/playlist', [PlaylistController::class, 'index']);
    Route::get('/playlist/{playlist_id}/lagu', [LaguPlaylistController::class, 'index']);
    Route::post('/playlist/{playlistId}/lagu', [LaguPlaylistController::class, 'addSongToPlaylist']);
    Route::delete('/laguplaylist/{playlist_id}/lagu/{lagu_id}', [LaguPlaylistController::class, 'destroy']);
    Route::delete('/playlist/{playlist_id}/lagu/{lagu_id}', [LaguPlaylistController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Rute untuk mendapatkan CSRF token
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF token set']);
});
