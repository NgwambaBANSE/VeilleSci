<?php

use App\Http\Controllers\Api\OpportuniteController;
use Illuminate\Support\Facades\Route;

// ── Test rapide ───────────────────────────────────────────
Route::get('/ping', fn() => response()->json(['status' => 'API OK ✅']));

// ── Routes publiques (tout le monde, connecté ou non) ─────
Route::prefix('v1')->group(function () {

    Route::get('opportunites',       [OpportuniteController::class, 'index']);
    Route::get('opportunites/{id}',  [OpportuniteController::class, 'show']);
    Route::get('statistiques',       [OpportuniteController::class, 'statistiques']);

    // ── Routes protégées (connectés uniquement) ───────────
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('opportunites',        [OpportuniteController::class, 'store']);
        Route::put('opportunites/{id}',    [OpportuniteController::class, 'update']);
        Route::delete('opportunites/{id}', [OpportuniteController::class, 'destroy']);
    });
});