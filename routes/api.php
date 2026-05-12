<?php

use App\Http\Controllers\Api\OpportuniteController;
use Illuminate\Support\Facades\Route;

// Route de test rapide — ouvrez http://localhost:8000/api/ping
Route::get('/ping', function () {
    return response()->json(['status' => 'API opérationnelle ✅']);
});

// Routes publiques (lecture seule)
Route::prefix('v1')->group(function () {
    Route::get('opportunites',      [OpportuniteController::class, 'index']);
    Route::get('opportunites/{id}', [OpportuniteController::class, 'show']);
    Route::get('statistiques',      [OpportuniteController::class, 'statistiques']);

    // Routes protégées (admin uniquement)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('opportunites',         [OpportuniteController::class, 'store']);
        Route::put('opportunites/{id}',     [OpportuniteController::class, 'update']);
        Route::delete('opportunites/{id}',  [OpportuniteController::class, 'destroy']);
    });
});