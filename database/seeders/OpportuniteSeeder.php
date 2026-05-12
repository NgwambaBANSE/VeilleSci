<?php

namespace Database\Seeders;

use App\Models\Opportunite;
use Illuminate\Database\Seeder;

class OpportuniteSeeder extends Seeder
{
    public function run(): void
    {
        Opportunite::truncate(); // Évite les doublons

        $opportunites = [
            [
                'titre'       => 'Appel à articles - Revue Africaine de Recherche en Éducation',
                'categorie'   => 'Publications',
                'domaine'     => 'Éducation',
                'date_limite' => '2026-09-30',
                'pays'        => 'International',
                'description' => 'La RARE lance un appel à contributions pour son numéro spécial sur l\'innovation pédagogique en Afrique subsaharienne.',
                'lien'        => 'https://example.com/rare',
            ],
            [
                'titre'       => 'Conférence Internationale sur l\'Agriculture Durable en Afrique',
                'categorie'   => 'Conférences',
                'domaine'     => 'Agriculture',
                'date_limite' => '2026-10-15',
                'pays'        => 'Sénégal',
                'description' => 'Soumettez vos résumés pour la CIADA 2026 à Dakar. Thème : solutions locales pour une agriculture résiliente.',
                'lien'        => 'https://example.com/ciada',
            ],
            [
                'titre'       => 'Bourse de recherche CODESRIA 2026',
                'categorie'   => 'Bourses',
                'domaine'     => 'Sciences Sociales',
                'date_limite' => '2026-09-01',
                'pays'        => 'International',
                'description' => 'Le CODESRIA offre des bourses de recherche aux jeunes chercheurs africains en sciences sociales et humaines.',
                'lien'        => 'https://example.com/codesria',
            ],
            [
                'titre'       => 'Formation en Biostatistiques - Université de Ouagadougou',
                'categorie'   => 'Formations',
                'domaine'     => 'Santé',
                'date_limite' => '2026-08-25',
                'pays'        => 'Burkina Faso',
                'description' => 'Formation intensive de 2 semaines en biostatistiques et épidémiologie pour les professionnels de santé.',
                'lien'        => 'https://example.com/biostat',
            ],
            [
                'titre'       => 'Stage de recherche - IRD Montpellier',
                'categorie'   => 'Stages',
                'domaine'     => 'Environnement',
                'date_limite' => '2026-09-15',
                'pays'        => 'France',
                'description' => 'L\'Institut de Recherche pour le Développement propose des stages de 6 mois pour chercheurs africains en environnement.',
                'lien'        => 'https://example.com/ird',
            ],
            [
                'titre'       => 'Bourse Erasmus+ pour doctorants africains',
                'categorie'   => 'Bourses',
                'domaine'     => 'Tous domaines',
                'date_limite' => '2026-11-01',
                'pays'        => 'Europe',
                'description' => 'Programme de mobilité pour doctorants souhaitant effectuer une partie de leur thèse dans une université européenne.',
                'lien'        => 'https://example.com/erasmus',
            ],
            [
                'titre'       => 'Conférence TIC et Développement - Abidjan 2026',
                'categorie'   => 'Conférences',
                'domaine'     => 'Informatique',
                'date_limite' => '2026-10-01',
                'pays'        => 'Côte d\'Ivoire',
                'description' => 'Soumettez vos travaux sur l\'impact des technologies numériques dans les pays en développement.',
                'lien'        => 'https://example.com/tic',
            ],
            [
                'titre'       => 'Appel à publications - Journal of African Health Sciences',
                'categorie'   => 'Publications',
                'domaine'     => 'Santé',
                'date_limite' => '2026-12-01',
                'pays'        => 'International',
                'description' => 'Revue indexée cherche des articles originaux sur les systèmes de santé et maladies tropicales en Afrique.',
                'lien'        => 'https://example.com/jahs',
            ],
            [
                'titre'       => 'Programme de formation en IA - AIMS Sénégal',
                'categorie'   => 'Formations',
                'domaine'     => 'Informatique',
                'date_limite' => '2026-09-20',
                'pays'        => 'Sénégal',
                'description' => 'L\'AIMS propose une formation de 3 semaines en intelligence artificielle et apprentissage automatique pour chercheurs africains.',
                'lien'        => 'https://example.com/aims',
            ],
        ];

        foreach ($opportunites as $opp) {
            Opportunite::create($opp);
        }

        $this->command->info('✅ ' . count($opportunites) . ' opportunités insérées avec succès !');
    }
}