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
        $query = Article::where('active', true);

        // Filtre par domaine
        if ($request->filled('domaine')) {
            $query->where('domaine', $request->domaine);
        }

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%$search%")
                  ->orWhere('resume_ia', 'like', "%$search%")
                  ->orWhere('auteurs', 'like', "%$search%");
            });
        }

        $articles = $query
            ->latest('date_publication')
            ->paginate(15);

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
