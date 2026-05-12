<?php

namespace Database\Seeders;

use App\Models\Opportunite;
use Illuminate\Database\Seeder;

class OpportuniteSeeder extends Seeder {
    public function run(): void {
        $opportunites = [
            [
                'titre'       => 'Appel à articles - Revue Africaine de Recherche en Éducation',
                'categorie'   => 'Publications',
                'domaine'     => 'Éducation',
                'date_limite' => '2026-06-30',
                'pays'        => 'International',
                'description' => 'La RARE lance un appel à contributions pour son numéro spécial sur l\'innovation pédagogique en Afrique subsaharienne.',
                'lien'        => 'https://example.com/rare',
            ],
            [
                'titre'       => 'Conférence Internationale sur l\'Agriculture Durable en Afrique',
                'categorie'   => 'Conférences',
                'domaine'     => 'Agriculture',
                'date_limite' => '2026-07-15',
                'pays'        => 'Sénégal',
                'description' => 'Soumettez vos résumés pour la CIADA 2026 à Dakar. Thème : solutions locales pour une agriculture résiliente.',
                'lien'        => 'https://example.com/ciada',
            ],
            [
                'titre'       => 'Bourse de recherche CODESRIA 2026',
                'categorie'   => 'Bourses',
                'domaine'     => 'Sciences Sociales',
                'date_limite' => '2026-06-01',
                'pays'        => 'International',
                'description' => 'Le CODESRIA offre des bourses de recherche aux jeunes chercheurs africains en sciences sociales et humaines.',
                'lien'        => 'https://example.com/codesria',
            ],
            [
                'titre'       => 'Formation en Biostatistiques - Université de Ouagadougou',
                'categorie'   => 'Formations',
                'domaine'     => 'Santé',
                'date_limite' => '2026-05-25',
                'pays'        => 'Burkina Faso',
                'description' => 'Formation intensive de 2 semaines en biostatistiques et épidémiologie pour les professionnels de santé.',
                'lien'        => 'https://example.com/biostat',
            ],
            [
                'titre'       => 'Stage de recherche - IRD Montpellier',
                'categorie'   => 'Stages',
                'domaine'     => 'Environnement',
                'date_limite' => '2026-06-15',
                'pays'        => 'France',
                'description' => 'L\'Institut de Recherche pour le Développement propose des stages de 6 mois pour chercheurs africains en environnement.',
                'lien'        => 'https://example.com/ird',
            ],
            [
                'titre'       => 'Appel à contributions - Journal de Médecine Tropicale',
                'categorie'   => 'Publications',
                'domaine'     => 'Santé',
                'date_limite' => '2026-07-30',
                'pays'        => 'International',
                'description' => 'Nous cherchons des articles originaux sur les maladies tropicales et la médecine dans les pays en développement.',
                'lien'        => 'https://example.com/jmt',
            ],
            [
                'titre'       => 'Bourse de doctorat - Fondation TWAS',
                'categorie'   => 'Bourses',
                'domaine'     => 'Sciences Exactes',
                'date_limite' => '2026-05-31',
                'pays'        => 'International',
                'description' => 'La TWAS offre des bourses de doctorat pour les jeunes chercheurs des pays en développement en sciences et technologie.',
                'lien'        => 'https://example.com/twas',
            ],
            [
                'titre'       => 'Colloque Africain d\'Informatique et d\'IA',
                'categorie'   => 'Conférences',
                'domaine'     => 'Informatique',
                'date_limite' => '2026-06-20',
                'pays'        => 'Côte d\'Ivoire',
                'description' => 'Conférence annuelle sur l\'intelligence artificielle, le big data et les applications technologiques en Afrique.',
                'lien'        => 'https://example.com/caia',
            ],
            [
                'titre'       => 'Formation en Chimie Analytique - Université de Kinshasa',
                'categorie'   => 'Formations',
                'domaine'     => 'Chimie',
                'date_limite' => '2026-06-01',
                'pays'        => 'RDC',
                'description' => 'Cours de perfectionnement en chimie analytique instrumentale pour les chercheurs et étudiants avancés.',
                'lien'        => 'https://example.com/chimie',
            ],
            [
                'titre'       => 'Subvention de recherche - African Academy of Sciences',
                'categorie'   => 'Bourses',
                'domaine'     => 'Multidisciplinaire',
                'date_limite' => '2026-07-31',
                'pays'        => 'International',
                'description' => 'L\'Académie africaine des sciences finance des projets de recherche innovants en Afrique.',
                'lien'        => 'https://example.com/aas',
            ],
            [
                'titre'       => 'Symposium sur l\'Énergie Renouvelable en Afrique',
                'categorie'   => 'Conférences',
                'domaine'     => 'Énergie',
                'date_limite' => '2026-06-10',
                'pays'        => 'Kenya',
                'description' => 'Présentez vos recherches sur l\'énergie solaire, éolienne et géothermique au symposium de Nairobi.',
                'lien'        => 'https://example.com/sera',
            ],
            [
                'titre'       => 'Programme de mobilité chercheurs - AMREC',
                'categorie'   => 'Stages',
                'domaine'     => 'Multidisciplinaire',
                'date_limite' => '2026-05-30',
                'pays'        => 'International',
                'description' => 'Le réseau AMREC facilite l\'échange de chercheurs africains pour des collaborations scientifiques.',
                'lien'        => 'https://example.com/amrec',
            ],
            [
                'titre'       => 'Appel à projets - Économie Circulaire en Afrique',
                'categorie'   => 'Bourses',
                'domaine'     => 'Environnement',
                'date_limite' => '2026-07-15',
                'pays'        => 'International',
                'description' => 'Financez vos projets de recherche sur l\'économie circulaire et la durabilité en contexte africain.',
                'lien'        => 'https://example.com/econ-circ',
            ],
            [
                'titre'       => 'Workshop en Bioinformatique - Université de Lagos',
                'categorie'   => 'Formations',
                'domaine'     => 'Biologie',
                'date_limite' => '2026-05-20',
                'pays'        => 'Nigeria',
                'description' => 'Atelier pratique de 5 jours en analyse génomique, phylogénétique et bioinformatique appliquée.',
                'lien'        => 'https://example.com/bioinf',
            ],
        ];

        foreach ($opportunites as $opp) {
            Opportunite::create($opp);
        }
        
    }
}