@extends('layouts.app')

@section('content')

{{-- ── Topbar ── --}}
<div class="topbar"> Portail National de Veille Scientifique — Burkina Faso</div>

{{-- ── Navbar ── --}}
<nav class="art-nav">
    <a href="/" class="art-logo">
        <div class="art-logo-icon">🔬</div>
        <div>
            <div class="art-logo-title">VeilleSci <span>BF</span></div>
            <div class="art-logo-sub">Portail de Veille Scientifique</div>
        </div>
    </a>
    <div class="art-nav-links">
        <a href="/app"    class="art-btn art-btn-outline">📋 Opportunités</a>
        <a href="/forum"  class="art-btn art-btn-outline">💬 Forum</a>
        @auth
            <a href="{{ route('profile.show') }}" class="art-btn art-btn-outline">👤 Profil</a>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button type="submit" class="art-btn art-btn-outline">🚪 Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="art-btn art-btn-outline">Se connecter</a>
            <a href="{{ route('register') }}" class="art-btn art-btn-green">Créer un compte</a>
        @endauth
    </div>
</nav>

{{-- ── Banner ── --}}
<div class="art-banner">
    <div class="art-banner-inner">
        <div>
            <div class="art-banner-badge">📚 Veille scientifique automatisée</div>
            <h1>Articles scientifiques<br/>résumés par <span>Intelligence Artificielle</span></h1>
            <p>Explorez les dernières publications, consultez des résumés intelligents et restez à la pointe de la recherche africaine.</p>
            <div class="art-banner-btns">
                <a href="{{ route('articles.index') }}" class="art-cta-primary">Découvrir les articles →</a>
                <a href="/forum" class="art-cta-secondary">💬 Visiter le forum</a>
            </div>
        </div>
        <div class="art-banner-stats">
            <div>
                <div class="art-bstat-num">{{ $articles->total() }}</div>
                <div class="art-bstat-label">Articles indexés</div>
            </div>
            <div>
                <div class="art-bstat-num">{{ count($domaines) }}</div>
                <div class="art-bstat-label">Domaines couverts</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Contenu ── --}}
<div class="art-main">

    <div>
        {{-- Filtres --}}
        <x-article-filters
            :domaines="$domaines"
            :search="request('search')"
            :domaine="request('domaine')" />

        {{-- Alerte --}}
        @if(session('message'))
            <div class="art-alert">✅ {{ session('message') }}</div>
        @endif

        {{-- Nombre de résultats --}}
        <div style="font-size:13px; color:var(--muted); margin-bottom:14px;">
            {{ $articles->total() }} article(s) trouvé(s) — affichage de 6 articles par page.
        </div>

        {{-- Liste --}}
        @forelse($articles as $article)
            <x-article-card :article="$article" />
        @empty
            <div class="art-empty">
                <div class="art-empty-icon">📭</div>
                <p style="font-size:15px; font-weight:600; color:#1e293b;">Aucun article trouvé</p>
                <p style="font-size:13px; margin-top:6px;">Essayez de modifier vos filtres de recherche.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        {{ $articles->withQueryString()->links('components.pagination') }}
    </div>

    {{-- ── Sidebar ── --}}
    <x-article-sidebar
        :articles="$articles"
        :stats="$stats"
        :domaines="$domaines"
        :resumeIaCount="$resumeIaCount" />

</div>
@endsection
