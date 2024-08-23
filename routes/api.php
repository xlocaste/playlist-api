<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LaguController;
use App\Http\Controllers\Api\PlaylistController;

// Lagu routes
Route::apiResource('/lagu', LaguController::class);

// Playlist routes
Route::apiResource('/playlist', PlaylistController::class);

// routes/api.php

use App\Http\Controllers\Api\LaguPlaylistController;

// Rute untuk mendapatkan lagu dari playlist
Route::get('/playlist/{playlist_id}/lagu', [LaguPlaylistController::class, 'index']);

// routes/api.php
Route::post('playlist/{id}/lagu', [PlaylistController::class, 'addSongToPlaylist']);

// Rute untuk menghapus lagu dari playlist
Route::delete('/laguplaylist/{playlist_id}/lagu/{lagu_id}', [LaguPlaylistController::class, 'destroy']);

// Routes
Route::get('lagu', [LaguController::class, 'getAllSongs']);

Route::post('/playlist/{playlistId}/lagu', [LaguPlaylistController::class, 'addSongToPlaylist']);

Route::delete('/playlist/{playlist_id}/lagu/{lagu_id}', [LaguPlaylistController::class, 'destroy']);
