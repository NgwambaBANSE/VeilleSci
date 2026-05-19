<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrossrefService
{
    private const BASE_URL = 'https://api.crossref.org/v1';

    // ── Identifiez votre app (Crossref "Polite Pool" = réponses plus rapides) ──
    // Remplacez par votre vrai email dans .env : CROSSREF_EMAIL=votre@email.com
    private string $mailto;

    public function __construct()
    {
        $this->mailto = config('app.crossref_email', env('CROSSREF_EMAIL', 'contact@veillescibf.bf'));
    }

    // ────────────────────────────────────────────────────────────────
    // MÉTHODE PRINCIPALE : recherche générale
    // ────────────────────────────────────────────────────────────────
    public function searchArticles(
        string $query,
        int    $limit  = 20,
        int    $offset = 0,
        string $sort   = 'relevance',  // relevance | published | is-referenced-by-count
        ?int   $fromYear = null
    ): array {
        try {
            $params = [
                'query'            => $query,
                'rows'             => min($limit, 50),   // max 50 par appel
                'offset'           => $offset,
                'sort'             => $sort,
                'order'            => 'desc',
                'mailto'           => $this->mailto,     // Polite Pool Crossref
            ];

            // Filtrer par année si demandé
            if ($fromYear) {
                $params['filter'] = "from-pub-date:{$fromYear}";
            }

            $response = Http::timeout(30)
                ->withHeaders(['User-Agent' => "VeilleSciBot/1.0 (mailto:{$this->mailto})"])
                ->get(self::BASE_URL . '/works', $params);

            if (!$response->successful()) {
                Log::warning('Crossref API error', [
                    'status' => $response->status(),
                    'query'  => $query,
                    'body'   => $response->body(),
                ]);
                return [];
            }

            return $this->parseResults($response->json());

        } catch (\Exception $e) {
            Log::error('CrossrefService::searchArticles — ' . $e->getMessage());
            return [];
        }
    }

    // ────────────────────────────────────────────────────────────────
    // RECHERCHE PAR DOMAINE (domaines pertinents pour VeilleSci BF)
    // ────────────────────────────────────────────────────────────────
    public function searchByField(string $field, int $limit = 20, ?int $fromYear = null): array
    {
        $queries = [
            // Sciences de la santé
            'sante'            => 'malaria OR tuberculosis OR HIV Africa OR tropical diseases OR epidemiology Africa',
            'medecine'         => 'medicine Africa OR public health Africa OR healthcare Burkina Faso',
            'nutrition'        => 'nutrition Africa OR food security Sahel OR malnutrition children Africa',

            // Agriculture & Environnement
            'agriculture'      => 'agriculture Africa OR agroecology Sahel OR crop production Burkina Faso',
            'environnement'    => 'climate change Africa OR desertification Sahel OR deforestation West Africa',
            'eau'              => 'water resources Africa OR groundwater Sahel OR irrigation West Africa',

            // Informatique & IA
            'ia'               => 'artificial intelligence Africa OR machine learning developing countries',
            'informatique'     => 'computer science Africa OR digital technology development',
            'telecommunications' => 'telecommunications Africa OR mobile networks Sub-Saharan',

            // Sciences sociales
            'education'        => 'education Africa OR school enrollment Burkina Faso OR literacy West Africa',
            'economie'         => 'economic development West Africa OR poverty reduction Sahel OR economies OR économie OR finance OR public policy OR fiscal policy OR monetary policy OR microfinance OR macroeconomics',
            'sciences-sociales'=> 'social sciences Africa OR governance West Africa',

            // Sciences fondamentales
            'biologie'         => 'biology Africa OR biodiversity West Africa OR ecology Sahel',
            'chimie'           => 'chemistry Africa OR materials science developing countries',
            'physique'         => 'physics Africa OR renewable energy Sahel OR solar energy Burkina',
            'mathematiques'    => 'mathematics education Africa OR mathematical modeling',

            // Énergie & Mines
            'energie'          => 'renewable energy Africa OR solar power Sahel OR energy access West Africa',
            'mines'            => 'mining Africa OR mineral resources West Africa OR geology Burkina Faso',

            // Recherche générale
            'general'          => 'research Africa OR scientific publication Sub-Saharan Africa',
        ];

        $query = $queries[$field] ?? $field;
        return $this->searchArticles($query, $limit, 0, 'relevance', $fromYear);
    }

    // ────────────────────────────────────────────────────────────────
    // RECHERCHE PAR DOI (article spécifique)
    // ────────────────────────────────────────────────────────────────
    public function getByDoi(string $doi): ?array
    {
        try {
            $doi = $this->cleanDoi($doi);
            if (!$doi) return null;

            // ⚠️ Ne PAS utiliser urlencode() — le / dans le DOI doit rester intact
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => "VeilleSciBot/1.0 (mailto:{$this->mailto})"])
                ->get(self::BASE_URL . '/works/' . $doi);

            if (!$response->successful()) return null;

            $item = $response->json()['message'] ?? null;
            return $item ? $this->parseItem($item) : null;

        } catch (\Exception $e) {
            Log::error('CrossrefService::getByDoi — ' . $e->getMessage());
            return null;
        }
    }

    // ────────────────────────────────────────────────────────────────
    // NETTOYAGE D'UN DOI (méthode utilitaire)
    // ────────────────────────────────────────────────────────────────
    public function cleanDoi(string $doi): ?string
    {
        $doi = trim($doi);

        // Supprimer les préfixes courants
        $doi = preg_replace('#^https?://(dx\.)?doi\.org/#i', '', $doi);
        $doi = preg_replace('#^doi:\s*#i', '', $doi);
        $doi = ltrim($doi, '/');

        // Un DOI valide commence toujours par "10."
        if (!preg_match('#^10\.\d{4,}/#', $doi)) {
            Log::warning("DOI invalide : {$doi}");
            return null;
        }

        return $doi;
    }

    // ────────────────────────────────────────────────────────────────
    // ARTICLES LES PLUS CITÉS (trending)
    // ────────────────────────────────────────────────────────────────
    public function getMostCited(string $query, int $limit = 10): array
    {
        return $this->searchArticles($query, $limit, 0, 'is-referenced-by-count');
    }

    // ────────────────────────────────────────────────────────────────
    // ARTICLES RÉCENTS (dernière année)
    // ────────────────────────────────────────────────────────────────
    public function getRecent(string $query, int $limit = 10): array
    {
        return $this->searchArticles($query, $limit, 0, 'published', date('Y') - 1);
    }

    // ────────────────────────────────────────────────────────────────
    // PARSING DES RÉSULTATS
    // ────────────────────────────────────────────────────────────────
    private function parseResults(array $data): array
    {
        if (!isset($data['message']['items'])) return [];

        $articles = [];
        foreach ($data['message']['items'] as $item) {
            $parsed = $this->parseItem($item);
            if ($parsed) $articles[] = $parsed;
        }

        return $articles;
    }

    private function parseItem(array $item): ?array
    {
        // Ignorer les entrées sans titre
        if (empty($item['title'][0])) return null;

        $titre = $this->cleanText($item['title'][0]);
        if (strlen($titre) < 5) return null;

        return [
            'titre'            => $titre,
            'auteurs'          => $this->parseAuthors($item['author'] ?? []),
            'doi'              => $this->cleanDoi($item['DOI'] ?? ''),
            'url'              => $this->buildDoiUrl($item),
            'date_publication' => $this->parseDate($item['published-print'] ?? $item['published-online'] ?? $item['created'] ?? null),
            'journal'          => $this->cleanText($item['container-title'][0] ?? 'Journal inconnu'),
            'resume'           => $this->cleanAbstract($item['abstract'] ?? null),
            'domaine'          => $this->inferDomaine($item),
            'mots_cles'        => $this->parseSubjects($item['subject'] ?? []),
            'citations'        => $item['is-referenced-by-count'] ?? 0,
            'langue'           => $item['language'] ?? 'en',
            'type'             => $item['type'] ?? 'journal-article',
            'source'           => 'crossref',
        ];
    }

    // ────────────────────────────────────────────────────────────────
    // NETTOYAGE ET PARSING
    // ────────────────────────────────────────────────────────────────

    /**
     * Nettoie les balises JATS/XML des résumés Crossref
     * Ex: <jats:p>Texte</jats:p> → Texte
     */
    private function cleanAbstract(?string $abstract): ?string
    {
        if (!$abstract) return null;

        // Supprimer les balises JATS XML, insensible à la casse
        $clean = preg_replace('/<jats:[^>]+>/i', '', $abstract);
        $clean = preg_replace('/<\/jats:[^>]+>/i', '', $clean);

        // Supprimer toutes les autres balises HTML
        $clean = strip_tags($clean);

        // Décode les entités HTML et nettoie les espaces multiples
        $clean = html_entity_decode($clean, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = trim($clean);

        return strlen($clean) > 20 ? $clean : null;
    }

    private function cleanText(string $text): string
    {
        return trim(strip_tags(html_entity_decode($text)));
    }

    private function buildDoiUrl(array $item): ?string
    {
        // Priorité 1 : URL directe fournie par Crossref
        if (!empty($item['URL'])) {
            $url = trim($item['URL']);
            if (filter_var($url, FILTER_VALIDATE_URL)) return $url;
        }

        // Priorité 2 : construire depuis le DOI propre
        $doi = $this->cleanDoi($item['DOI'] ?? '');
        if ($doi) return 'https://doi.org/' . $doi;

        return null;
    }

    private function parseAuthors(array $authors): string
    {
        if (empty($authors)) return 'Auteurs inconnus';

        $names = array_map(function ($author) {
            if (isset($author['name'])) return $author['name']; // Org author
            $family = $author['family'] ?? '';
            $given  = isset($author['given']) ? ' ' . $author['given'][0] . '.' : '';
            return trim($family . $given);
        }, $authors);

        $names  = array_filter($names);
        $total  = count($names);
        $sample = array_slice($names, 0, 3);

        return implode(', ', $sample) . ($total > 3 ? " et al. ({$total} auteurs)" : '');
    }

    private function parseDate($dateData): ?\DateTime
    {
        if (!$dateData) return null;

        try {
            if (isset($dateData['date-parts'][0])) {
                $parts = $dateData['date-parts'][0];
                $year  = (int)($parts[0] ?? date('Y'));
                $month = (int)($parts[1] ?? 1);
                $day   = (int)($parts[2] ?? 1);

                // Vérification basique
                if ($year < 1900 || $year > (int)date('Y') + 1) return null;
                $month = max(1, min(12, $month));
                $day   = max(1, min(31, $day));

                return \DateTime::createFromFormat('Y-m-d', "$year-$month-$day") ?: null;
            }
        } catch (\Exception $e) {
            Log::debug('Date parsing error', ['data' => $dateData]);
        }

        return null;
    }

    private function parseSubjects(array $subjects): string
    {
        return implode(', ', array_slice($subjects, 0, 5));
    }

    /**
     * Déduit le domaine à partir des sujets Crossref
     */
    private function inferDomaine(array $item): string
    {
        $subjects = array_map('strtolower', $item['subject'] ?? []);
        $title    = strtolower($item['title'][0] ?? '');
        $text     = implode(' ', $subjects) . ' ' . $title;

        $mapping = [
            'Santé'          => ['health', 'medicine', 'disease', 'malaria', 'hiv', 'epidemiology', 'clinical', 'pharmacology'],
            'Agriculture'    => ['agriculture', 'farming', 'crop', 'soil', 'irrigation', 'food security', 'agronomy'],
            'Environnement'  => ['climate', 'environment', 'ecology', 'biodiversity', 'forest', 'water', 'sustainability'],
            'Informatique'   => ['computer', 'software', 'algorithm', 'data', 'network', 'artificial intelligence', 'machine learning'],
            'Éducation'      => ['education', 'learning', 'teaching', 'school', 'university', 'literacy'],
            'Économie'       => ['economics', 'économie', 'finance', 'finance comportementale', 'poverty', 'développement', 'development', 'market', 'trade', 'politique économique', 'public policy', 'fiscal policy', 'monetary policy', 'microfinance', 'macroeconomics'],
            'Biologie'       => ['biology', 'genetics', 'genomics', 'cell', 'molecular', 'microbiology'],
            'Chimie'         => ['chemistry', 'chemical', 'polymer', 'material', 'synthesis'],
            'Physique'       => ['physics', 'energy', 'solar', 'quantum', 'optics'],
            'Mathématiques'  => ['mathematics', 'statistics', 'modeling', 'algebra', 'calculus'],
            'Sciences sociales' => ['sociology', 'anthropology', 'political', 'governance', 'social'],
            'Énergie'        => ['energy', 'renewable', 'solar', 'wind', 'power', 'electricity'],
        ];

        foreach ($mapping as $domaine => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($text, $kw)) return $domaine;
            }
        }

        return 'Sciences générales';
    }
}