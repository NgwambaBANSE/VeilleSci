<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Page d'accueil (publique) ─────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Routes Breeze (login, register, logout...) ────────────
require __DIR__.'/auth.php';

// ── Routes OAuth Google ──────────────────────────────────
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// ── Application React (protégée — authentification requise) ──
Route::middleware('auth')->get('/app', function () {
    return view('app');
});

// ── Routes Profil (protégées) ───────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
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

    // ── Gestion des Administrateurs ──────────────────────────
    // ⚠️ Route AJAX search DOIT être AVANT le resource pour éviter le conflit avec {admin}
    Route::get('/admin/admins/search-users', [AdminManagementController::class, 'search'])
        ->middleware('throttle:30,1')  // 30 requêtes par minute
        ->name('admin.admins.search');
    
    Route::resource('admin/admins', AdminManagementController::class, [
        'names' => [
            'index' => 'admin.admins.index',
            'create' => 'admin.admins.create',
            'store' => 'admin.admins.store',
            'show' => 'admin.admins.show',
            'destroy' => 'admin.admins.destroy',
        ]
    ])->only(['index', 'create', 'store', 'show', 'destroy']);
});

// ── Articles Scientifiques — routes publiques ────────────
Route::get('/articles',        [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', function ($id) {
    $article = \App\Models\Article::find($id);

    return $article
        ? redirect()->route('articles.show', $article)
        : abort(404);
})->where('id', '[0-9]+');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

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
    Route::post('/articles/{article:slug}/favori',    [ArticleController::class, 'addFavori'])    ->name('articles.favori.add');
    Route::delete('/articles/{article:slug}/favori',  [ArticleController::class, 'removeFavori'])  ->name('articles.favori.remove');

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