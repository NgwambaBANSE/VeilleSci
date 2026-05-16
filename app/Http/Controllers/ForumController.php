<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // ── Liste des sujets ──────────────────────────────────
    public function index(Request $request)
    {
        $query = ForumTopic::withCount('replies')
            ->with('user')
            ->orderBy('epingle', 'desc')
            ->latest();

        if ($request->filled('categorie') && $request->categorie !== 'Toutes') {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('titre',   'like', "%$s%")
                  ->orWhere('contenu','like', "%$s%")
            );
        }

        $topics = $query->paginate(15);

        $stats = [
            'total'   => ForumTopic::count(),
            'resolus' => ForumTopic::where('resolu', true)->count(),
            'replies' => ForumReply::count(),
            'membres' => \App\Models\User::count(),
        ];

        return view('forum.index', compact('topics', 'stats'));
    }

    // ── Formulaire nouveau sujet ──────────────────────────
    public function create()
    {
        return view('forum.create');
    }

    // ── Enregistrer le sujet ──────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'titre'     => 'required|string|min:10|max:255',
            'contenu'   => 'required|string|min:20',
            'categorie' => 'required|in:Bourses,Publications,Conférences,Formations,Stages,Général,Méthodologie',
        ]);

        $topic = ForumTopic::create([
            'user_id'   => Auth::id(),
            'titre'     => $request->titre,
            'contenu'   => $request->contenu,
            'categorie' => $request->categorie,
        ]);

        return redirect()->route('forum.show', $topic)
            ->with('success', 'Votre sujet a été publié !');
    }

    // ── Afficher un sujet + réponses ──────────────────────
    public function show(ForumTopic $forum)
    {
        $forum->incrementVues();
        $forum->load(['user.profile', 'replies.user.profile']);
        return view('forum.show', compact('forum'));
    }

    // ── Poster une réponse ────────────────────────────────
    public function reply(Request $request, ForumTopic $forum)
    {
        $request->validate([
            'contenu' => 'required|string|min:10',
        ]);

        ForumReply::create([
            'user_id'        => Auth::id(),
            'forum_topic_id' => $forum->id,
            'contenu'        => $request->contenu,
        ]);

        return redirect()->route('forum.show', $forum)
            ->with('success', 'Votre réponse a été publiée !');
    }

    // ── Marquer comme résolu ──────────────────────────────
    public function resoudre(ForumTopic $forum)
    {
        abort_if(Auth::id() !== $forum->user_id, 403);
        $forum->update(['resolu' => !$forum->resolu]);
        return back()->with('success', $forum->resolu ? 'Sujet marqué comme résolu.' : 'Sujet réouvert.');
    }

    // ── Marquer meilleure réponse ─────────────────────────
    public function meilleureReponse(ForumReply $reply)
    {
        abort_if(Auth::id() !== $reply->topic->user_id, 403);
        $reply->topic->replies()->update(['meilleure_reponse' => false]);
        $reply->update(['meilleure_reponse' => true]);
        $reply->topic->update(['resolu' => true]);
        return back()->with('success', 'Meilleure réponse sélectionnée !');
    }

    // ── Supprimer un sujet ────────────────────────────────
    public function destroy(ForumTopic $forum)
    {
        abort_if(Auth::id() !== $forum->user_id, 403);
        $forum->delete();
        return redirect()->route('forum.index')
            ->with('success', 'Sujet supprimé.');
    }

    // ── Supprimer une réponse ─────────────────────────────
    public function destroyReply(ForumReply $reply)
    {
        abort_if(Auth::id() !== $reply->user_id, 403);
        $topic = $reply->topic;
        $reply->delete();
        return redirect()->route('forum.show', $topic)
            ->with('success', 'Réponse supprimée.');
    }
}