<?php

namespace App\Http\Controllers;

use App\Models\ForumSujet;
use App\Models\ForumReponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // ── Liste des sujets ──────────────────────────────────
    public function index(Request $request)
    {
        $query = ForumSujet::with(['user', 'reponses'])
            ->orderBy('epingle', 'desc')
            ->latest();

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre',   'like', '%'.$request->q.'%')
                  ->orWhere('contenu','like', '%'.$request->q.'%');
            });
        }

        $sujets = $query->paginate(15)->withQueryString();
        $stats  = [
            'total'    => ForumSujet::count(),
            'resolus'  => ForumSujet::where('resolu', true)->count(),
            'reponses' => ForumReponse::count(),
            'membres'  => \App\Models\User::count(),
        ];

        return view('forum.index', compact('sujets', 'stats'));
    }

    // ── Formulaire nouveau sujet ──────────────────────────
    public function create()
    {
        return view('forum.create');
    }

    // ── Enregistrer un sujet ──────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'titre'     => 'required|string|min:10|max:255',
            'contenu'   => 'required|string|min:20',
            'categorie' => 'required|string',
        ]);

        $sujet = ForumSujet::create([
            'user_id'   => Auth::id(),
            'titre'     => $request->titre,
            'contenu'   => $request->contenu,
            'categorie' => $request->categorie,
        ]);

        return redirect()->route('forum.show', $sujet)
            ->with('success', 'Sujet publié avec succès !');
    }

    // ── Détail d'un sujet ─────────────────────────────────
    public function show(ForumSujet $sujet)
    {
        $sujet->incrementerVues();
        $sujet->load(['user.profile', 'reponses.user.profile']);
        return view('forum.show', compact('sujet'));
    }

    // ── Poster une réponse ────────────────────────────────
    public function repondre(Request $request, ForumSujet $sujet)
    {
        $request->validate([
            'contenu' => 'required|string|min:5',
        ]);

        ForumReponse::create([
            'sujet_id' => $sujet->id,
            'user_id'  => Auth::id(),
            'contenu'  => $request->contenu,
        ]);

        return redirect()->route('forum.show', $sujet)
            ->with('success', 'Réponse publiée !');
    }

    // ── Marquer comme meilleure réponse ──────────────────
    public function meilleureReponse(ForumSujet $sujet, ForumReponse $reponse)
    {
        abort_unless(Auth::id() === $sujet->user_id, 403);

        // Désactiver l'ancienne meilleure réponse
        ForumReponse::where('sujet_id', $sujet->id)
            ->update(['meilleure_reponse' => false]);

        $reponse->update(['meilleure_reponse' => true]);
        $sujet->update(['resolu' => true]);

        return back()->with('success', 'Meilleure réponse sélectionnée !');
    }

    // ── Supprimer un sujet (auteur ou admin) ──────────────
    public function destroy(ForumSujet $sujet)
    {
        abort_unless(Auth::id() === $sujet->user_id, 403);
        $sujet->delete();
        return redirect()->route('forum.index')
            ->with('success', 'Sujet supprimé.');
    }

    // ── Supprimer une réponse ─────────────────────────────
    public function supprimerReponse(ForumSujet $sujet, ForumReponse $reponse)
    {
        abort_unless(Auth::id() === $reponse->user_id, 403);
        $reponse->delete();
        return back()->with('success', 'Réponse supprimée.');
    }
}