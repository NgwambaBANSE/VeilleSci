<?php

use App\Http\Controllers\Api\OpportuniteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavorisController;
use Illuminate\Support\Facades\Route;

// Route de test rapide — ouvrez http://localhost:8000/api/ping
Route::get('/ping', function () {
    return response()->json(['status' => 'API opérationnelle ✅']);
});

// Routes d'authentification (publiques)
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

// Routes protégées par authentification
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Utilisateurs - Gestion des favoris
    Route::get('favoris',                       [FavorisController::class, 'index']);
    Route::post('favoris/{opportunite}',        [FavorisController::class, 'toggle']);
    Route::get('favoris/{opportunite}/check',   [FavorisController::class, 'check']);
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