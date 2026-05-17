@props(['article', 'userId' => null])

<div class="art-card">
    {{-- En-tête --}}
    <div class="art-card-top">
        <div class="art-card-meta">
            @if($article->domaine)
                <x-article-badge :label="$article->domaine" type="domain" />
            @endif
            @if($article->mots_cles)
                @foreach(array_slice(explode(',', $article->mots_cles), 0, 3) as $mot)
                    <x-article-badge :label="trim($mot)" type="keyword" />
                @endforeach
            @endif
        </div>

        <a href="{{ route('articles.show', $article) }}" class="art-card-title">
            {{ $article->titre }}
        </a>

        <p class="art-card-authors">
            ✍️ {{ $article->auteurs ?: 'Auteurs inconnus' }}
        </p>
        <p class="art-card-info">
            📅 {{ $article->date_publication?->format('d/m/Y') ?? 'Date inconnue' }}
            @if($article->journal) · 📖 {{ $article->journal }} @endif
        </p>
    </div>

    {{-- Résumé --}}
    @if($article->resume_ia)
        <div class="art-resume art-resume-ia">
            <div class="art-resume-label">🤖 Résumé IA</div>
            {{ $article->resume_ia }}
        </div>
    @elseif($article->resume)
        <div class="art-resume art-resume-std">
            <div class="art-resume-label">📄 Résumé</div>
            {{ Str::limit($article->resume, 250) }}
        </div>
    @endif

    {{-- Footer --}}
    <div class="art-card-footer">
        <a href="{{ route('articles.show', $article) }}" class="art-footer-primary">
            Lire l'article →
        </a>
        @if($article->doi)
            <a href="https://doi.org/{{ $article->doi }}" target="_blank" rel="noopener"
               class="art-footer-secondary">DOI</a>
        @endif
        @if($article->url)
            <a href="{{ $article->url }}" target="_blank" rel="noopener"
               class="art-footer-secondary">Lien direct</a>
        @endif

        {{-- Favori --}}
        @auth
            @if($article->isFavoriBy(Auth::id()))
                <form method="POST" action="{{ route('articles.favori.remove', $article) }}"
                      style="margin:0; margin-left:auto;">
                    @csrf @method('DELETE')
                    <button type="submit" class="art-favori" title="Retirer des favoris">❤️</button>
                </form>
            @else
                <form method="POST" action="{{ route('articles.favori.add', $article) }}"
                      style="margin:0; margin-left:auto;">
                    @csrf
                    <button type="submit" class="art-favori" title="Ajouter aux favoris">🤍</button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="art-favori" style="margin-left:auto; text-decoration:none;"
               title="Connectez-vous pour ajouter aux favoris">🤍</a>
        @endauth
    </div>
</div>
