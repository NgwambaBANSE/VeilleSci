<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    private const MODEL = 'claude-3-5-sonnet-20241022';
    private const BASE_URL = 'https://api.anthropic.com/v1';

    /**
     * Résumer un article scientifique
     */
    public function summarizeArticle(string $titre, ?string $resume, ?string $contenu = null): ?string
    {
        try {
            $apiKey = config('services.anthropic.key');
            if (!$apiKey) {
                Log::warning('Anthropic API key not configured');
                return null;
            }

            $texte = $titre . "\n\n";
            if ($resume) {
                $texte .= $resume . "\n\n";
            }
            if ($contenu) {
                $texte .= substr($contenu, 0, 2000); // Limiter à 2000 caractères
            }

            $prompt = <<<PROMPT
Tu es un expert scientifique. Résume cet article en français en 3-4 phrases claires et concises, 
en mettant en avant les résultats et implications principales. Sois objectif et technique.

Article:
$texte

Résumé (3-4 phrases):
PROMPT;

            $response = Http::timeout(30)
                ->withHeader('x-api-key', $apiKey)
                ->withHeader('anthropic-version', '2023-06-01')
                ->post(self::BASE_URL . '/messages', [
                    'model' => self::MODEL,
                    'max_tokens' => 300,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ]
                    ],
                ]);

            if (!$response->successful()) {
                Log::warning('Claude API error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $data = $response->json();
            return $data['content'][0]['text'] ?? null;

        } catch (\Exception $e) {
            Log::error('ClaudeService error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extraire les mots-clés
     */
    public function extractKeywords(string $titre, ?string $resume): array
    {
        try {
            $apiKey = config('services.anthropic.key');
            if (!$apiKey) {
                return [];
            }

            $texte = $titre . "\n\n" . ($resume ?? '');

            $prompt = <<<PROMPT
Extrais 5-7 mots-clés pertinents de ce texte scientifique en français.
Retourne UNIQUEMENT les mots-clés séparés par des virgules, sans numérotation.

Texte:
$texte

Mots-clés:
PROMPT;

            $response = Http::timeout(30)
                ->withHeader('x-api-key', $apiKey)
                ->withHeader('anthropic-version', '2023-06-01')
                ->post(self::BASE_URL . '/messages', [
                    'model' => self::MODEL,
                    'max_tokens' => 150,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ]
                    ],
                ]);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();
            $keywords = $data['content'][0]['text'] ?? '';
            return array_map('trim', explode(',', $keywords));

        } catch (\Exception $e) {
            Log::error('ClaudeService keyword extraction error: ' . $e->getMessage());
            return [];
        }
    }
}
