<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrossrefService
{
    private const BASE_URL = 'https://api.crossref.org/v1';
    
    /**
     * Rechercher des articles par domaine/mot-clé
     */
    public function searchArticles(string $query, int $limit = 20, string $sort = 'published'): array
    {
        try {
            $response = Http::timeout(30)
                ->get(self::BASE_URL . '/works', [
                    'query' => $query,
                    'rows' => $limit,
                    'sort' => $sort,
                    'select' => 'title,author,published-online,DOI,URL,abstract,container-title',
                ]);

            if (!$response->successful()) {
                Log::warning('Crossref API error', ['status' => $response->status()]);
                return [];
            }

            $data = $response->json();
            return $this->parseResults($data);

        } catch (\Exception $e) {
            Log::error('CrossrefService error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Rechercher par domaine (ex: "machine-learning", "bioinformatics", etc.)
     */
    public function searchByField(string $field, int $limit = 20): array
    {
        $queries = [
            'machine-learning' => 'machine learning OR deep learning OR neural network',
            'bioinformatics' => 'bioinformatics OR genomics OR proteomics',
            'quantum' => 'quantum computing OR quantum algorithms',
            'ia' => 'artificial intelligence OR machine learning OR neural networks',
            'biologie' => 'biology OR cell biology OR molecular biology',
            'physique' => 'physics OR quantum physics OR particle physics',
            'chimie' => 'chemistry OR organic chemistry OR materials science',
            'mathematiques' => 'mathematics OR mathematical modeling OR numerical analysis',
        ];

        $query = $queries[$field] ?? $field;
        return $this->searchArticles($query, $limit);
    }

    /**
     * Parser les résultats Crossref
     */
    private function parseResults(array $data): array
    {
        $articles = [];

        if (!isset($data['message']['items'])) {
            return [];
        }

        foreach ($data['message']['items'] as $item) {
            $articles[] = [
                'titre' => $item['title'][0] ?? 'Sans titre',
                'auteurs' => $this->parseAuthors($item['author'] ?? []),
                'doi' => $item['DOI'] ?? null,
                'url' => $item['URL'] ?? null,
                'date_publication' => $this->parseDate($item['published-online'] ?? $item['created'] ?? null),
                'journal' => $item['container-title'][0] ?? 'Unknown Journal',
                'resume' => $item['abstract'] ?? null,
                'source' => 'crossref',
            ];
        }

        return $articles;
    }

    /**
     * Parser la liste des auteurs
     */
    private function parseAuthors(array $authors): string
    {
        if (empty($authors)) {
            return '';
        }

        $names = array_map(function ($author) {
            $name = $author['family'] ?? '';
            if (isset($author['given'])) {
                $name .= ' ' . $author['given'];
            }
            return trim($name);
        }, $authors);

        return implode('; ', array_slice($names, 0, 5)); // Max 5 auteurs
    }

    /**
     * Parser la date
     */
    private function parseDate($dateData): ?\DateTime
    {
        if (!$dateData) {
            return null;
        }

        try {
            if (isset($dateData['date-parts']) && !empty($dateData['date-parts'][0])) {
                $parts = $dateData['date-parts'][0];
                $year = $parts[0] ?? date('Y');
                $month = $parts[1] ?? 1;
                $day = $parts[2] ?? 1;

                return \DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
            }
        } catch (\Exception $e) {
            Log::warning('Date parsing error', ['data' => $dateData]);
        }

        return null;
    }
}
