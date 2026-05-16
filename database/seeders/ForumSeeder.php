<?php

namespace Database\Seeders;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        // ── Créer des utilisateurs de test ────────────────
        $users = [
            ['name' => 'Dr. Amadou Traoré',    'email' => 'amadou@veillescibf.com'],
            ['name' => 'Pr. Fatoumata Diallo',  'email' => 'fatoumata@veillescibf.com'],
            ['name' => 'M. Issouf Ouédraogo',   'email' => 'issouf@veillescibf.com'],
            ['name' => 'Mme Aïssata Sawadogo',  'email' => 'aissata@veillescibf.com'],
            ['name' => 'Dr. Boukary Compaoré',  'email' => 'boukary@veillescibf.com'],
        ];

        $createdUsers = [];
        foreach ($users as $u) {
            $createdUsers[] = User::firstOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make('password')]
            );
        }

        // ── Données des sujets ────────────────────────────
        $topics = [

            // ── Bourses ───────────────────────────────────
            [
                'user'      => $createdUsers[0],
                'titre'     => 'Comment postuler à la bourse CODESRIA 2026 ?',
                'categorie' => 'Bourses',
                'epingle'   => true,
                'resolu'    => true,
                'contenu'   => "Bonjour à tous,\n\nJe souhaite postuler à la bourse de recherche CODESRIA 2026 mais je ne sais pas exactement quels documents sont requis ni comment rédiger la proposition de recherche.\n\nQuelqu'un a-t-il déjà postulé à cette bourse ? Pouvez-vous partager votre expérience et les étapes à suivre ?\n\nMerci d'avance pour vos retours.",
                'vues'      => 142,
                'replies'   => [
                    [
                        'user'             => $createdUsers[1],
                        'contenu'          => "Bonjour Dr. Traoré,\n\nJ'ai postulé et obtenu cette bourse en 2024. Voici les documents essentiels :\n\n1. CV académique détaillé (max 5 pages)\n2. Proposition de recherche (8-10 pages)\n3. Lettre de motivation\n4. Deux lettres de recommandation\n5. Relevés de notes des diplômes\n\nLe plus important est la cohérence de votre proposition avec les axes prioritaires du CODESRIA. Bonne chance !",
                        'meilleure'        => true,
                    ],
                    [
                        'user'    => $createdUsers[2],
                        'contenu' => "Je confirme les informations de Pr. Diallo. J'ajouterais que la proposition doit impérativement démontrer la pertinence de votre recherche pour le développement africain. Le comité est très sensible à cet aspect.",
                        'meilleure' => false,
                    ],
                ],
            ],

            // ── Publications ──────────────────────────────
            [
                'user'      => $createdUsers[1],
                'titre'     => 'Quelles revues indexées acceptent des articles sur l\'agriculture au Burkina ?',
                'categorie' => 'Publications',
                'epingle'   => false,
                'resolu'    => false,
                'contenu'   => "Chères collègues,\n\nJe finalise un article sur les pratiques agroécologiques dans le Sahel burkinabè et je cherche des revues scientifiques indexées (Scopus ou Web of Science) qui publient dans ce domaine.\n\nAvez-vous des suggestions de revues avec un bon taux d'acceptation pour les chercheurs africains ? Le délai de révision est aussi un critère important pour moi.",
                'vues'      => 89,
                'replies'   => [
                    [
                        'user'      => $createdUsers[3],
                        'contenu'   => "Bonjour,\n\nJe vous recommande ces revues :\n\n• African Journal of Agricultural Research (accès ouvert)\n• Journal of Arid Environments (Elsevier)\n• Agriculture, Ecosystems & Environment\n• Cahiers Agricultures\n\nLes deux dernières sont indexées Scopus et ont des délais raisonnables (3-4 mois). African Journal est très favorable aux chercheurs africains.",
                        'meilleure' => false,
                    ],
                ],
            ],

            // ── Conférences ───────────────────────────────
            [
                'user'      => $createdUsers[2],
                'titre'     => 'Conférence CIADA 2026 — Comment préparer un bon résumé ?',
                'categorie' => 'Conférences',
                'epingle'   => false,
                'resolu'    => false,
                'contenu'   => "Bonjour la communauté,\n\nLa conférence CIADA 2026 à Dakar approche et je dois soumettre un résumé avant le 15 juillet. C'est ma première participation à une conférence internationale.\n\nComment structurer un bon résumé scientifique ? Y a-t-il des erreurs courantes à éviter ? La limite est de 300 mots.",
                'vues'      => 67,
                'replies'   => [
                    [
                        'user'      => $createdUsers[0],
                        'contenu'   => "Excellente question ! Un bon résumé de conférence doit suivre la structure IMReD :\n\n• Introduction : contexte et problématique (50 mots)\n• Méthodes : approche méthodologique (60 mots)\n• Résultats : résultats principaux chiffrés (100 mots)\n• Discussion/Conclusion : apport et perspectives (90 mots)\n\nErreurs à éviter : les généralités vagues, l'absence de résultats concrets et les références bibliographiques dans le résumé.",
                        'meilleure' => false,
                    ],
                    [
                        'user'      => $createdUsers[4],
                        'contenu'   => "Je complète : pensez à utiliser des mots-clés forts dès le titre et la première phrase. Le comité de sélection lit des centaines de résumés, votre première phrase doit accrocher immédiatement. Bonne chance !",
                        'meilleure' => false,
                    ],
                ],
            ],

            // ── Formations ────────────────────────────────
            [
                'user'      => $createdUsers[3],
                'titre'     => 'Formation biostatistiques à l\'UJK — Retour d\'expérience',
                'categorie' => 'Formations',
                'epingle'   => false,
                'resolu'    => true,
                'contenu'   => "Bonjour,\n\nJ'ai participé à la formation en biostatistiques organisée par l'Université Joseph Ki-Zerbo en mai 2026. Je voulais partager mon retour d'expérience avec la communauté.\n\nLa formation était très complète : R, SPSS, épidémiologie descriptive et analytique. Le niveau était adapté aux débutants comme aux initiés. Je recommande vivement !",
                'vues'      => 54,
                'replies'   => [
                    [
                        'user'      => $createdUsers[2],
                        'contenu'   => "Merci pour ce retour ! Y a-t-il une prochaine session prévue ? Et les frais d'inscription étaient-ils élevés ?",
                        'meilleure' => false,
                    ],
                    [
                        'user'      => $createdUsers[3],
                        'contenu'   => "La prochaine session est prévue en octobre 2026. Les frais étaient de 50 000 FCFA pour les étudiants et 80 000 FCFA pour les professionnels. Des bourses partielles sont disponibles sur demande.",
                        'meilleure' => true,
                    ],
                ],
            ],

            // ── Stages ────────────────────────────────────
            [
                'user'      => $createdUsers[4],
                'titre'     => 'Stage IRD Montpellier — Conditions et critères de sélection ?',
                'categorie' => 'Stages',
                'epingle'   => false,
                'resolu'    => false,
                'contenu'   => "Bonjour à tous,\n\nJ'ai vu l'annonce du stage de recherche à l'IRD Montpellier sur la plateforme. Je suis doctorant en 2ème année en sciences de l'environnement.\n\nQuelqu'un connaît-il les critères de sélection réels ? Est-ce que le niveau de français exigé est très élevé ? Y a-t-il une aide au logement prévue ?",
                'vues'      => 38,
                'replies'   => [
                    [
                        'user'      => $createdUsers[1],
                        'contenu'   => "J'ai effectué un stage à l'IRD en 2023. Le niveau de français doit être B2 minimum (DELF/DALF apprécié). L'IRD fournit une aide au logement de 400€/mois via le CROUS. La sélection se base sur votre dossier académique, la lettre de motivation et un entretien avec le directeur de stage.",
                        'meilleure' => false,
                    ],
                ],
            ],

            // ── Méthodologie ──────────────────────────────
            [
                'user'      => $createdUsers[0],
                'titre'     => 'Quelle méthode d\'analyse qualitative pour une thèse en sciences sociales ?',
                'categorie' => 'Méthodologie',
                'epingle'   => false,
                'resolu'    => false,
                'contenu'   => "Bonjour,\n\nJe débute ma thèse sur les perceptions communautaires du changement climatique dans la région du Sahel burkinabè. J'hésite entre l'analyse thématique, l'analyse de contenu et la théorie ancrée (Grounded Theory).\n\nMon corpus comprend 40 entretiens semi-directifs. Quelle méthode me conseilleriez-vous et pourquoi ?",
                'vues'      => 76,
                'replies'   => [
                    [
                        'user'      => $createdUsers[1],
                        'contenu'   => "Pour votre problématique, je recommande l'analyse thématique selon Braun & Clarke (2006). Elle est très adaptée aux entretiens semi-directifs et aux études de perception.\n\nLa Grounded Theory serait pertinente si vous souhaitez construire une théorie nouvelle, mais elle exige une collecte itérative des données difficile à gérer en thèse.\n\nL'analyse de contenu est plus quantitative et moins adaptée à l'exploration de perceptions.",
                        'meilleure' => false,
                    ],
                    [
                        'user'      => $createdUsers[3],
                        'contenu'   => "Je rejoins Pr. Diallo. Avec 40 entretiens, l'analyse thématique avec le logiciel NVivo ou MAXQDA vous donnera une grande rigueur analytique tout en restant maniable. Il existe des licences gratuites pour les doctorants africains via certains programmes de l'IRD.",
                        'meilleure' => false,
                    ],
                ],
            ],

            // ── Général ───────────────────────────────────
            [
                'user'      => $createdUsers[2],
                'titre'     => 'Bienvenue sur le forum VeilleSci Burkina !',
                'categorie' => 'Général',
                'epingle'   => true,
                'resolu'    => false,
                'contenu'   => "Chères et chers collègues chercheurs,\n\nBienvenue sur le forum de VeilleSci Burkina !\n\nCet espace est le vôtre pour :\n✅ Poser vos questions sur les opportunités de recherche\n✅ Partager vos expériences (bourses, conférences, publications)\n✅ Demander des conseils méthodologiques\n✅ Créer des collaborations scientifiques\n\nN'hésitez pas à participer activement. Plus vous contribuez, plus la communauté est forte !\n\nBonne recherche à tous 🔬",
                'vues'      => 215,
                'replies'   => [
                    [
                        'user'      => $createdUsers[3],
                        'contenu'   => "Merci pour cette initiative ! C'est exactement ce dont la communauté scientifique burkinabè avait besoin. Je suis ravie de rejoindre ce forum.",
                        'meilleure' => false,
                    ],
                    [
                        'user'      => $createdUsers[4],
                        'contenu'   => "Excellente plateforme ! J'espère que nous serons nombreux à contribuer et à partager nos connaissances pour faire avancer la recherche au Burkina Faso.",
                        'meilleure' => false,
                    ],
                ],
            ],
        ];

        // ── Insérer les données ───────────────────────────
        ForumTopic::truncate();
        ForumReply::truncate();

        foreach ($topics as $topicData) {
            $topic = ForumTopic::create([
                'user_id'   => $topicData['user']->id,
                'titre'     => $topicData['titre'],
                'contenu'   => $topicData['contenu'],
                'categorie' => $topicData['categorie'],
                'epingle'   => $topicData['epingle'],
                'resolu'    => $topicData['resolu'],
                'vues'      => $topicData['vues'],
            ]);

            foreach ($topicData['replies'] as $replyData) {
                ForumReply::create([
                    'user_id'          => $replyData['user']->id,
                    'forum_topic_id'   => $topic->id,
                    'contenu'          => $replyData['contenu'],
                    'meilleure_reponse'=> $replyData['meilleure'],
                ]);
            }

            $this->command->info("✅ Sujet créé : {$topic->titre}");
        }

        $this->command->info("\n🎉 Forum seedé avec succès !");
        $this->command->info("📧 Comptes de test (mot de passe : password) :");
        foreach ($createdUsers as $u) {
            $this->command->info("   → {$u->email}");
        }
    }
}