<?php

use Illuminate\Support\Facades\Route;

// ── Page d'accueil (publique) ─────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Routes Breeze (login, register, logout...) ────────────
require __DIR__.'/auth.php';

// ── Application React (PUBLIQUE — aucun middleware auth) ──
Route::get('/app', function () {
    return view('app');      // Pas de ->middleware('auth') ici !
});