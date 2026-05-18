<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\ClaudeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateArticleSummaries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:generate-summaries 
                            {--limit=20 : Nombre d\'articles à traiter}
                            {--force : Regénérer les résumés existants}
                            {--all : Traiter tous les articles sans résumé}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Générer les résumés IA et mots-clés pour les articles sans résumé';

    protected ClaudeService $claudeService;

    public function __construct(ClaudeService $claudeService)
    {
        parent::__construct();
        $this->claudeService = $claudeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 Génération des résumés IA...');

        $query = Article::query();

        // Si --all, traiter tous les articles
        if ($this->option('all')) {
            // Garder tous les articles
        } else if ($this->option('force')) {
            // Forcer la regénération de tous
            $this->warn('⚠️  Mode force - regénération de tous les résumés');
        } else {
            // Par défaut, seulement ceux sans résumé
            $query->whereNull('resume_ia');
        }

        $limit = (int)$this->option('limit');
        if (!$this->option('all')) {
            $query->limit($limit);
        }

        $articles = $query->get();
        $total = $articles->count();

        if ($total === 0) {
            $this->info('✅ Aucun article à traiter');
            return 0;
        }

        $this->info("📚 Traitement de $total articles...\n");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $generated = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($articles as $article) {
            $bar->advance();

            try {
                // Générer le résumé IA
                $summary = null;
                if ($article->resume) {
                    $summary = $this->claudeService->summarizeArticle(
                        $article->titre,
                        $article->resume
                    );
                }

                // Générer les mots-clés
                $keywords = $this->claudeService->extractKeywords(
                    $article->titre,
                    $article->resume
                );

                // Mettre à jour l'article
                $article->update([
                    'resume_ia' => $summary,
                    'mots_cles' => implode(',', $keywords),
                ]);

                $generated++;
                Log::info("Article résumé: {$article->titre}");

            } catch (\Exception $e) {
                $failed++;
                Log::error('Summary generation error', [
                    'article_id' => $article->id,
                    'titre' => $article->titre,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Résumés générés: $generated");
        $this->info("⚠️  Erreurs: $failed");
        $this->info("📊 Total traité: $total");

        if ($generated > 0) {
            Log::info("Article summaries generated: $generated");
        }

        return 0;
    }
}
