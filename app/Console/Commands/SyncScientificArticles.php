<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\CrossrefService;
use App\Services\ClaudeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncScientificArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:sync 
                            {--domaine=machine learning : Domaine à synchroniser}
                            {--limit=20 : Nombre d\'articles à récupérer}
                            {--all : Synchroniser tous les domaines}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchroniser les articles scientifiques de Crossref et résumer avec Claude';

    protected $crossrefService;
    protected $claudeService;

    /**
     * Create a new command instance.
     */
    public function __construct(CrossrefService $crossrefService, ClaudeService $claudeService)
    {
        parent::__construct();
        $this->crossrefService = $crossrefService;
        $this->claudeService = $claudeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Démarrage de la synchronisation des articles scientifiques...');

        $domaines = $this->option('all') 
            ? ['machine learning', 'bioinformatics', 'quantum computing', 'artificial intelligence', 'biology']
            : [$this->option('domaine')];

        $limit = $this->option('limit');
        $totalCreated = 0;
        $totalSkipped = 0;

        foreach ($domaines as $domaine) {
            $this->info("\n📚 Récupération des articles pour: $domaine");
            
            $bar = $this->output->createProgressBar();
            $bar->start();

            $articlesData = $this->crossrefService->searchArticles($domaine, $limit);

            foreach ($articlesData as $data) {
                $bar->advance();

                // Vérifier si l'article existe
                if ($data['doi'] && Article::where('doi', $data['doi'])->exists()) {
                    $totalSkipped++;
                    continue;
                }

                try {
                    // Résumer avec Claude
                    $resumeIa = null;
                    if ($data['resume']) {
                        $this->line("  ⏳ Résumé de: {$data['titre']}...");
                        $resumeIa = $this->claudeService->summarizeArticle(
                            $data['titre'],
                            $data['resume']
                        );
                    }

                    // Extraire les mots-clés
                    $motsCles = $this->claudeService->extractKeywords(
                        $data['titre'],
                        $data['resume']
                    );

                    // Créer l'article
                    Article::create([
                        'titre' => $data['titre'],
                        'auteurs' => $data['auteurs'],
                        'domaine' => $domaine,
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

                    $totalCreated++;

                } catch (\Exception $e) {
                    Log::error('Article sync error', [
                        'titre' => $data['titre'],
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $bar->finish();
            $this->newLine();
            $this->info("✅ Domaine '$domaine': $totalCreated créés, $totalSkipped ignorés");
        }

        $this->newLine();
        $this->info("🎉 Synchronisation terminée!");
        $this->info("📊 Total: $totalCreated articles créés, $totalSkipped doublons ignorés");

        return 0;
    }
}
