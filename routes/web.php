<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
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

// ── Routes Profil (protégées) ───────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/modifier', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// ── Routes Admin (protégées) ──────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/opportunites/create', [AdminDashboardController::class, 'create'])->name('admin.create');
    Route::post('/admin/opportunites', [AdminDashboardController::class, 'store'])->name('admin.store');
    Route::get('/admin/opportunites/{opportunite}/edit', [AdminDashboardController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/opportunites/{opportunite}', [AdminDashboardController::class, 'update'])->name('admin.update');
    Route::delete('/admin/opportunites/{opportunite}', [AdminDashboardController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/opportunites/{opportunite}/toggle', [AdminDashboardController::class, 'toggle'])->name('admin.toggle');
});