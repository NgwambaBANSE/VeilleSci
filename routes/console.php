<?php

use App\Jobs\SyncArticlesJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Inspire command
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ────────────────────────────────────────────────────────────────
// SCHEDULER - Mise à jour automatique des articles
// ────────────────────────────────────────────────────────────────

Schedule::command('articles:sync --all --limit=20')
    ->daily()  // Une fois par jour
    ->at('02:00')  // À 2h du matin
    ->name('sync-scientific-articles-all')
    ->withoutOverlapping()
    ->onSuccess(function () {
        \Illuminate\Support\Facades\Log::info('✅ Articles sync completed successfully');
    })
    ->onFailure(function () {
        \Illuminate\Support\Facades\Log::error('❌ Articles sync failed');
    });

// Sync spécifique par domaine - chaque 6 heures
Schedule::command('articles:sync --domaine="machine learning" --limit=15')
    ->hourly()  // Toutes les heures
    ->withoutOverlapping()
    ->name('sync-machine-learning-articles');

Schedule::command('articles:sync --domaine="artificial intelligence" --limit=15')
    ->hourly()  // Toutes les heures
    ->withoutOverlapping()
    ->name('sync-ai-articles');

// Alternative : utiliser les Jobs en queue (plus flexible)
Schedule::job(new SyncArticlesJob('artificial intelligence', 20))
    ->hourly()
    ->withoutOverlapping()
    ->name('sync-ai-job');

Schedule::job(new SyncArticlesJob('machine learning', 20))
    ->hourly()
    ->withoutOverlapping()
    ->name('sync-ml-job');
