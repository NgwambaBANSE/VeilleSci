<?php

use Illuminate\Support\Facades\Route;

// ── 1. Page d'accueil (publique) ──────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── 2. Routes Breeze (login, register, etc.) ──────────────
require __DIR__.'/auth.php';

// ── 3. Page application React (privée) ───────────────────
Route::middleware('auth')->get('/app', function () {
    return view('app');
});