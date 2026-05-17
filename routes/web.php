<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ForumController;
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
    Route::get('/admin/utilisateurs', [AdminDashboardController::class, 'listUsers'])->name('admin.users');
    Route::get('/admin/opportunites/create', [AdminDashboardController::class, 'create'])->name('admin.create');
    Route::post('/admin/opportunites', [AdminDashboardController::class, 'store'])->name('admin.store');
    Route::get('/admin/opportunites/{opportunite}/edit', [AdminDashboardController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/opportunites/{opportunite}', [AdminDashboardController::class, 'update'])->name('admin.update');
    Route::delete('/admin/opportunites/{opportunite}', [AdminDashboardController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/opportunites/{opportunite}/toggle', [AdminDashboardController::class, 'toggle'])->name('admin.toggle');
});

// ── Articles Scientifiques — routes publiques ────────────
Route::get('/articles',        [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// ── Forum — routes publiques ──────────────────────────────
// ⚠️ /forum/nouveau DOIT être avant /forum/{forum}
Route::get('/forum',         [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/nouveau', [ForumController::class, 'create'])->name('forum.create');
Route::get('/forum/{forum}', [ForumController::class, 'show'])->name('forum.show');

// ── Routes privées (connectés uniquement) ─────────────────
Route::middleware('auth')->group(function () {

    // Profil
    Route::get('/profil',          [ProfileController::class, 'show'])  ->name('profile.show');
    Route::get('/profil/modifier', [ProfileController::class, 'edit'])  ->name('profile.edit');
    Route::put('/profil',          [ProfileController::class, 'update'])->name('profile.update');

    // Articles — favoris
    Route::post('/articles/{article}/favori',    [ArticleController::class, 'addFavori'])    ->name('articles.favori.add');
    Route::delete('/articles/{article}/favori',  [ArticleController::class, 'removeFavori'])  ->name('articles.favori.remove');

    // Forum — écriture
    Route::post  ('/forum',                          [ForumController::class, 'store'])            ->name('forum.store');
    Route::post  ('/forum/{forum}/repondre',         [ForumController::class, 'reply'])            ->name('forum.reply');
    Route::post  ('/forum/{forum}/resoudre',         [ForumController::class, 'resoudre'])         ->name('forum.resoudre');
    Route::post  ('/forum/reply/{reply}/meilleure',  [ForumController::class, 'meilleureReponse']) ->name('forum.meilleure');
    Route::delete('/forum/{forum}',                  [ForumController::class, 'destroy'])          ->name('forum.destroy');
    Route::delete('/forum/reply/{reply}',            [ForumController::class, 'destroyReply'])     ->name('forum.reply.destroy');
});

// ── Routes Admin — Articles ──────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/articles/sync', [ArticleController::class, 'sync'])->name('articles.sync');
});