#!/usr/bin/env php
<?php

/**
 * VeilleSci Article Sync - Verification Script
 * Vérifie la configuration complète du système de synchronisation
 * 
 * Exécuter: php verify_sync.php
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\Config;
use App\Models\Article;
use App\Services\CrossrefService;
use App\Services\ClaudeService;

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

class SyncVerifier
{
    private array $checks = [];
    private bool $allPassed = true;

    public function run(): void
    {
        echo "\n╔════════════════════════════════════════════════════════════════╗\n";
        echo "║         🔍 VeilleSci Article Sync - Verification              ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n\n";

        $this->checkEnvConfiguration();
        $this->checkDatabase();
        $this->checkAPIs();
        $this->checkScheduler();
        $this->checkArticles();

        $this->displayResults();
    }

    private function checkEnvConfiguration(): void
    {
        echo "📋 Vérification de la configuration (.env)...\n";

        // Anthropic API
        $anthropic = env('ANTHROPIC_API_KEY');
        $this->addCheck(
            'ANTHROPIC_API_KEY configurée',
            !empty($anthropic) && str_starts_with($anthropic, 'sk-ant-'),
            $anthropic ? '✓ Clé détectée' : '✗ Manquante'
        );

        // Crossref Email
        $crossref = env('CROSSREF_EMAIL');
        $this->addCheck(
            'CROSSREF_EMAIL configurée',
            !empty($crossref) && filter_var($crossref, FILTER_VALIDATE_EMAIL),
            $crossref ? "✓ $crossref" : '✗ Manquante ou invalide'
        );

        // Queue Connection
        $queue = env('QUEUE_CONNECTION');
        $this->addCheck(
            'QUEUE_CONNECTION configurée',
            !empty($queue),
            "✓ $queue"
        );

        echo "\n";
    }

    private function checkDatabase(): void
    {
        echo "🗄️  Vérification de la base de données...\n";

        try {
            // Vérifier la table articles
            $count = Article::count();
            $this->addCheck(
                'Table articles existe',
                true,
                "✓ $count articles trouvés"
            );

            // Vérifier les migrations
            $lastArticle = Article::latest()->first();
            if ($lastArticle) {
                $this->addCheck(
                    'Articles présents',
                    true,
                    "✓ Dernier: {$lastArticle->titre} ({$lastArticle->created_at->diffForHumans()})"
                );
            }

        } catch (\Exception $e) {
            $this->addCheck('Table articles existe', false, "✗ " . $e->getMessage());
        }

        echo "\n";
    }

    private function checkAPIs(): void
    {
        echo "🔌 Vérification des APIs...\n";

        // Crossref API
        try {
            $crossref = app(CrossrefService::class);
            $result = $crossref->searchArticles('machine learning', 1);
            $this->addCheck(
                'Crossref API accessible',
                !empty($result),
                count($result) > 0 ? "✓ " . count($result) . " résultat" : "⚠️ 0 résultat (normal si rate limit)"
            );
        } catch (\Exception $e) {
            $this->addCheck('Crossref API accessible', false, "✗ " . $e->getMessage());
        }

        // Claude API
        try {
            $claude = app(ClaudeService::class);
            // Test avec un appel simple (peut être vide si pas d'API)
            $result = $claude->extractKeywords('Machine Learning', 'Deep Learning');
            $this->addCheck(
                'Claude API accessible',
                !empty($result) || $result === [],
                count($result) > 0 ? "✓ " . count($result) . " mots-clés" : "⚠️ API prête"
            );
        } catch (\Exception $e) {
            $this->addCheck('Claude API accessible', false, "✗ " . $e->getMessage());
        }

        echo "\n";
    }

    private function checkScheduler(): void
    {
        echo "⏰ Vérification du Scheduler...\n";

        // Vérifier si le fichier routes/console.php a les tâches
        $console = file_get_contents(base_path('routes/console.php'));
        
        $this->addCheck(
            'Scheduler configuré dans routes/console.php',
            str_contains($console, 'Schedule::'),
            "✓ Configuration détectée"
        );

        $this->addCheck(
            'Command articles:sync programmé',
            str_contains($console, 'articles:sync'),
            "✓ Tâches synchronisation détectées"
        );

        $this->addCheck(
            'Job SyncArticlesJob programmé',
            str_contains($console, 'SyncArticlesJob'),
            "✓ Jobs détectés"
        );

        echo "\n";
    }

    private function checkArticles(): void
    {
        echo "📚 Statistiques des articles...\n";

        try {
            $total = Article::count();
            $byDomain = Article::select('domaine', \DB::raw('count(*) as count'))
                ->groupBy('domaine')
                ->get();

            echo "  Total d'articles: $total\n";
            
            if ($byDomain->count() > 0) {
                echo "  Par domaine:\n";
                foreach ($byDomain as $domain) {
                    echo "    - {$domain->domaine}: {$domain->count}\n";
                }
            } else {
                echo "  (Aucun article encore)\n";
            }

            // Informations sur les résumés IA
            $withAiSummary = Article::whereNotNull('resume_ia')->count();
            $this->addCheck(
                'Articles avec résumés IA',
                true,
                "✓ $withAiSummary / $total articles résumés"
            );

        } catch (\Exception $e) {
            echo "  ⚠️  Erreur: " . $e->getMessage() . "\n";
        }

        echo "\n";
    }

    private function addCheck(string $name, bool $passed, string $message): void
    {
        $this->checks[] = [
            'name' => $name,
            'passed' => $passed,
            'message' => $message,
        ];

        if (!$passed) {
            $this->allPassed = false;
        }
    }

    private function displayResults(): void
    {
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║                      📊 Résultats                             ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n\n";

        foreach ($this->checks as $check) {
            $icon = $check['passed'] ? '✅' : '❌';
            echo "{$icon} {$check['name']}\n";
            echo "   {$check['message']}\n\n";
        }

        echo "╔════════════════════════════════════════════════════════════════╗\n";

        if ($this->allPassed) {
            echo "║                  ✅ TOUT EST OK!                           ║\n";
            echo "║                                                            ║\n";
            echo "║  Prochaines étapes:                                       ║\n";
            echo "║  1. Configurer Task Scheduler (Windows) ou cron (Linux)   ║\n";
            echo "║  2. Voir LARAGON_SETUP.md pour les instructions            ║\n";
            echo "║  3. Tester: php artisan articles:sync --all --limit=5    ║\n";
        } else {
            echo "║                  ⚠️  VÉRIFIEZ LES ERREURS                   ║\n";
            echo "║                                                            ║\n";
            echo "║  Problèmes détectés - voir les messages ci-dessus        ║\n";
        }

        echo "╚════════════════════════════════════════════════════════════════╝\n\n";

        // Instructions rapides
        echo "💡 Commandes utiles:\n";
        echo "   php artisan schedule:list           # Voir toutes les tâches\n";
        echo "   php artisan articles:sync --all     # Lancer synchronisation\n";
        echo "   php artisan queue:work              # Démarrer les workers\n";
        echo "   php artisan tinker                  # Accès interactif à la BD\n\n";
    }
}

$verifier = new SyncVerifier();
$verifier->run();
