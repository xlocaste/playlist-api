<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LaguController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\LaguPlaylistController;

// AUTHENTIKASI
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// GROUP RUTE DENGAN MIDDLEWARE auth:sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Rute yang hanya dapat diakses oleh role tertentu
    Route::middleware('role:publisher')->group(function () {
        Route::get('/publisher', function(Request $request) {
            return response()->json([
                'message' => 'You have access to the publisher route',
                'user' => $request->user()
            ]);
        });
    });

    Route::middleware('role:public')->group(function () {
        Route::get('/public', function(Request $request) {
            return response()->json([
                'message' => 'You have access to the public route',
                'user' => $request->user()
            ]);
        });
    });

    // LAGU ROUTES
    Route::get('/lagu', [LaguController::class, 'index'])->middleware('permission:read-lagu');
    Route::post('/lagu', [LaguController::class, 'store'])->middleware('permission:create-lagu');
    Route::get('/lagu/{id}', [LaguController::class, 'show'])->middleware('permission:read-lagu');
    Route::put('/lagu/{id}', [LaguController::class, 'update'])->middleware('permission:update-lagu');
    Route::delete('/lagu/{id}', [LaguController::class, 'destroy'])->middleware('permission:delete-lagu');

    // PLAYLIST ROUTESm,
    Route::get('/playlist', [PlaylistController::class, 'index'])->middleware('permission:read-playlist');
    Route::post('/playlist', [PlaylistController::class, 'store'])->middleware('permission:create-playlist');
    Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->middleware('permission:read-playlist');
    Route::put('/playlist/{id}', [PlaylistController::class, 'update'])->middleware('permission:update-playlist');
    Route::delete('/playlist/{id}', [PlaylistController::class, 'destroy'])->middleware('permission:delete-playlist');

    // LAGU PLAYLIST ROUTES
    Route::get('/playlist/{playlist_id}/lagu', [LaguPlaylistController::class, 'index'])->middleware('permission:read-playlist');
    Route::post('/playlist/{playlistId}/lagu', [LaguPlaylistController::class, 'addSongToPlaylist'])->middleware('permission:create-playlist');
    Route::delete('/playlist/{playlistId}/lagu/{laguId}', [LaguPlaylistController::class, 'removeSongFromPlaylist'])->middleware('permission:delete-playlist');

    // Rute untuk mendapatkan data pengguna yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
