<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\CrossrefService;
use App\Services\ClaudeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncArticlesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $domaine;
    protected int $limit;

    public function __construct(string $domaine = 'artificial intelligence', int $limit = 20)
    {
        $this->domaine = $domaine;
        $this->limit = $limit;
    }

    public function handle(CrossrefService $crossrefService, ClaudeService $claudeService): void
    {
        Log::info("🔄 Démarrage sync pour domaine: {$this->domaine}");

        try {
            $articlesData = $crossrefService->searchByField($this->domaine, $this->limit);

            $created = 0;
            $skipped = 0;

            foreach ($articlesData as $data) {
                // Vérifier si l'article existe
                if ($data['doi'] && Article::where('doi', $data['doi'])->exists()) {
                    $skipped++;
                    continue;
                }

                try {
                    // Résumer avec Claude
                    $resumeIa = null;
                    if ($data['resume']) {
                        $resumeIa = $claudeService->summarizeArticle(
                            $data['titre'],
                            $data['resume']
                        );
                    }

                    // Extraire les mots-clés
                    $motsCles = $claudeService->extractKeywords(
                        $data['titre'],
                        $data['resume']
                    );

                    // Créer l'article
                    Article::create([
                        'titre' => $data['titre'],
                        'auteurs' => $data['auteurs'],
                        'domaine' => $this->domaine,
                        'doi' => $data['doi'],
                        'url' => $data['url'],
                        'date_publication' => $data['date_publication'],
                        'journal' => $data['journal'],
                        'resume' => $data['resume'],
                        'resume_ia' => $resumeIa,
                        'mots_cles' => implode(',', $motsCles),
                        'source' => 'crossref',
                        'active' => true,
                    ]);

                    $created++;

                } catch (\Exception $e) {
                    Log::error('Article sync error', [
                        'titre' => $data['titre'] ?? 'Unknown',
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            Log::info("✅ Sync terminé", [
                'domaine' => $this->domaine,
                'created' => $created,
                'skipped' => $skipped,
            ]);

        } catch (\Exception $e) {
            Log::error('SyncArticlesJob error: ' . $e->getMessage());
            throw $e;
        }
    }
}
