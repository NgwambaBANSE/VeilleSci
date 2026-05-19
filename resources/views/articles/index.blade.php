@extends('layouts.app')

@section('content')

<style>
    .art-nav { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .art-nav-toggle { display: none; width: 42px; height: 42px; border: none; background: transparent; cursor: pointer; align-items: center; justify-content: center; }
    .art-nav-toggle span { display: block; width: 22px; height: 2px; background: #1a3a5c; border-radius: 999px; position: relative; transition: transform .2s ease, opacity .2s ease; }
    .art-nav-toggle span::before,
    .art-nav-toggle span::after { content: ''; display: block; width: 22px; height: 2px; background: #1a3a5c; border-radius: 999px; position: absolute; left: 0; transition: transform .2s ease, opacity .2s ease; }
    .art-nav-toggle span::before { top: -7px; }
    .art-nav-toggle span::after { top: 7px; }
    .art-mobile-menu { display: none; flex-direction: column; gap: 10px; padding: 16px 24px; background: #fff; border-bottom: 1px solid #e2e8f0; }
    .art-mobile-menu a, .art-mobile-menu button { width: 100%; text-align: left; }
    @media (max-width: 760px) {
        .art-nav-links { display: none; width: 100%; }
        .art-nav-toggle { display: inline-flex; }
    }
</style>

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
    <button class="art-nav-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <span aria-hidden="true"></span>
    </button>
</nav>
<div class="art-mobile-menu" aria-hidden="true">
    <a href="/app" class="art-btn art-btn-outline">📋 Opportunités</a>
    <a href="/forum" class="art-btn art-btn-outline">💬 Forum</a>
    @auth
        <a href="{{ route('profile.show') }}" class="art-btn art-btn-outline">👤 Profil</a>
        <form method="POST" action="/logout" style="margin:0;">
            @csrf
            <button type="submit" class="art-btn art-btn-outline" style="width:100%; text-align:left;">🚪 Déconnexion</button>
        </form>
    @else
        <a href="{{ route('login') }}"    class="art-btn art-btn-outline">Se connecter</a>
        <a href="{{ route('register') }}" class="art-btn art-btn-green">Créer un compte</a>
    @endauth
</div>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.art-nav-toggle');
        const menu = document.querySelector('.art-mobile-menu');
        if (!toggle || !menu) return;

        toggle.addEventListener('click', function () {
            const isOpen = menu.style.display === 'flex';
            menu.style.display = isOpen ? 'none' : 'flex';
            toggle.classList.toggle('active', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
            menu.setAttribute('aria-hidden', String(isOpen));
        });
    });
</script>
@endsection
