<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\CrossrefService;
use App\Services\ClaudeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $crossrefService;
    protected $claudeService;

    public function __construct(CrossrefService $crossrefService, ClaudeService $claudeService)
    {
        $this->crossrefService = $crossrefService;
        $this->claudeService = $claudeService;
    }

    /**
     * Afficher la liste des articles
     */
    public function index(Request $request)
    {
        // ✅ SECURITY FIX #16: Valider et nettoyer les paramètres d'entrée
        $validated = $request->validate([
            'search' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\s\-éèêëàâäùûüôöçñ]+$/',
            'domaine' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\s\-éèêëàâäùûüôöçñ]+$/',
            'categorie' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9\s\-éèêëàâäùûüôöçñ]+$/',
            'page' => 'nullable|integer|min:1|max:1000',
        ], [
            'search.regex' => 'Le paramètre de recherche contient des caractères non autorisés.',
            'domaine.regex' => 'Le domaine contient des caractères non autorisés.',
            'categorie.regex' => 'La catégorie contient des caractères non autorisés.',
            'page.max' => 'Le numéro de page est trop élevé.',
        ]);

        $query = Article::where('active', true);

        // Filtre par domaine
        if (!empty($validated['domaine'])) {
            $query->where('domaine', $validated['domaine']);
        }

        // Filtre par catégorie
        if (!empty($validated['categorie'])) {
            $query->where('categorie', $validated['categorie']);
        }

        // Recherche
        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%$search%")
                  ->orWhere('resume_ia', 'like', "%$search%")
                  ->orWhere('auteurs', 'like', "%$search%");
            });
        }

        $perPage = 4;
        $articles = $query
            ->latest('date_publication')
            ->paginate($perPage, ['*'], 'page', $validated['page'] ?? 1);

        $domaines = Article::where('active', true)
            ->distinct('domaine')
            ->pluck('domaine');

        $stats = Article::where('active', true)
            ->selectRaw('domaine, COUNT(*) as count')
            ->groupBy('domaine')
            ->pluck('count', 'domaine');

        $resumeIaCount = Article::where('active', true)
            ->whereNotNull('resume_ia')
            ->count();

        return view('articles.index', compact('articles', 'domaines', 'stats', 'resumeIaCount'));
    }

    /**
     * Afficher un article détaillé
     */
    public function show(Article $article)
    {
        // Articles similaires (même domaine)
        $similaires = Article::where('domaine', $article->domaine)
            ->where('id', '!=', $article->id)
            ->limit(5)
            ->get();

        $isFavori = false;
        if (Auth::check()) {
            $isFavori = $article->isFavoriBy(Auth::id());
        }

        return view('articles.show', compact('article', 'similaires', 'isFavori'));
    }

    /**
     * Ajouter aux favoris
     */
    public function addFavori(Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $article->favoris()->firstOrCreate([
            'user_id' => Auth::id(),
            'type' => 'article',
        ]);

        return back()->with('success', 'Article ajouté aux favoris!');
    }

    /**
     * Retirer des favoris
     */
    public function removeFavori(Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $article->favoris()
            ->where('user_id', Auth::id())
            ->where('type', 'article')
            ->delete();

        return back()->with('success', 'Article retiré des favoris!');
    }

    /**
     * Rechercher et synchroniser les articles (ADMIN)
     */
    public function sync(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        $domaine = $request->input('domaine', 'machine learning');
        $limit = $request->input('limit', 10);

        // Récupérer les articles de Crossref
        $articlesData = $this->crossrefService->searchArticles($domaine, $limit);

        $created = 0;
        $skipped = 0;

        foreach ($articlesData as $data) {
            // Vérifier si l'article existe déjà
            if ($data['doi'] && Article::where('doi', $data['doi'])->exists()) {
                $skipped++;
                continue;
            }

            // Résumer avec Claude
            $resumeIa = null;
            if ($data['resume']) {
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

            $created++;
        }

        return back()->with('message', "$created articles créés, $skipped ignorés (doublons)");
    }
}
