@extends('layouts.app')

@section('title', $article->titre)

@section('content')
<div class="article-show-wrapper">
    <div class="article-show-topbar">
        <a href="{{ route('articles.index') }}" class="article-show-back">← Retour à la liste</a>
        <div class="article-show-badge">Article détaillé</div>
    </div>

    <section class="article-show-hero">
        <div class="article-show-hero-main">
            <h1 class="article-show-title">{{ $article->titre }}</h1>
            <p class="article-show-description">Un article structuré avec métadonnées, résumé IA et accès direct aux sources.</p>

            <div class="article-show-meta">
                @if($article->domaine)
                    <span>📂 {{ $article->domaine }}</span>
                @endif
                <span>📅 {{ $article->date_publication?->format('d F Y') ?? 'Date inconnue' }}</span>
                @if($article->journal)
                    <span>📖 {{ $article->journal }}</span>
                @endif
            </div>
        </div>

        <div class="article-show-hero-panel">
            <div class="article-show-hero-card">
                <p class="article-show-label">Auteurs</p>
                <p>{{ $article->auteurs ?: 'Auteurs inconnus' }}</p>
            </div>
            <div class="article-show-hero-card">
                <p class="article-show-label">Source</p>
                <p>{{ ucfirst($article->source) }}</p>
            </div>
            @if($article->doi)
            <div class="article-show-hero-card">
                <p class="article-show-label">DOI</p>
                <p><a href="https://doi.org/{{ $article->doi }}" target="_blank" rel="noopener">{{ $article->doi }}</a></p>
            </div>
            @endif
        </div>
    </section>

    <div class="article-show-main">
        <div class="article-show-content">
            @if($article->resume_ia)
            <div class="article-show-panel article-show-summary article-show-summary-ia">
                <h2>🤖 Résumé IA</h2>
                <p>{{ $article->resume_ia }}</p>
            </div>
            @endif

            @if($article->resume)
            <div class="article-show-panel article-show-summary article-show-summary-original">
                <h2>📄 Résumé original</h2>
                <p>{{ $article->resume }}</p>
            </div>
            @endif

            @if($similaires->count() > 0)
            <div class="article-show-panel article-show-related">
                <h2>📚 Articles similaires</h2>
                <div class="article-related-list">
                    @foreach($similaires as $sim)
                    <a href="{{ route('articles.show', $sim) }}" class="article-related-item">
                        <h3>{{ Str::limit($sim->titre, 80) }}</h3>
                        <p class="article-related-meta">{{ $sim->auteurs ? Str::limit($sim->auteurs, 60) : 'Auteurs inconnus' }}</p>
                        <p>{{ Str::limit($sim->resume_ia ?? $sim->resume, 140) }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <aside class="article-show-aside">
            <div class="article-show-panel">
                <h2>Actions</h2>
                <div class="article-show-actions">
                    @if($article->url)
                    <a href="{{ $article->url }}" target="_blank" rel="noopener" class="primary">Accéder à l'article complet</a>
                    @endif
                    @if($article->doi)
                    <a href="https://doi.org/{{ $article->doi }}" target="_blank" rel="noopener" class="secondary">Voir sur CrossRef</a>
                    @endif
                </div>
            </div>

            <div class="article-show-panel">
                <h2>Mots-clés</h2>
                <div class="article-show-keywords">
                    @foreach(explode(',', $article->mots_cles ?? '') as $mot)
                        @if(trim($mot))
                            <span class="article-show-keyword">{{ trim($mot) }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="article-show-panel">
                @if(Auth::check())
                    @if($isFavori)
                        <form method="POST" action="{{ route('articles.favori.remove', $article) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="article-show-button danger">❤️ Retirer des favoris</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('articles.favori.add', $article) }}">
                            @csrf
                            <button type="submit" class="article-show-button">🤍 Ajouter aux favoris</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="article-show-button">Connectez-vous pour enregistrer</a>
                @endif
            </div>
        </aside>
    </div>
</div>
@endsection
