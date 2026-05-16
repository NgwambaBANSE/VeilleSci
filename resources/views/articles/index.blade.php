@extends('layouts.app')

@section('title', 'Articles Scientifiques')

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <div class="mx-auto max-w-7xl px-4 pt-10">
        <section class="rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-700 text-white shadow-2xl overflow-hidden mb-10">
            <div class="px-8 py-12 md:px-16">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-emerald-200">
                    📚 Veille d'articles</span>
                <h1 class="mt-6 text-4xl md:text-5xl font-black leading-tight tracking-tight">
                    Articles scientifiques résumés automatiquement par IA
                </h1>
                <p class="mt-4 max-w-3xl text-base leading-8 text-slate-200">Explorez une veille scientifique harmonisée, parcourez les dernières publications et retrouvez des résumés intelligents pour gagner du temps.</p>
                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-400 px-6 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-300">
                        Découvrir les articles
                    </a>
                    <a href="/forum" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                        Visiter le forum
                    </a>
                </div>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-[1.6fr_0.95fr]">
            <div class="space-y-6">
                <div class="rounded-[2rem] bg-white border border-slate-200 shadow-lg p-6">
                    <form method="GET" action="{{ route('articles.index') }}" class="space-y-6">
                        <div class="grid gap-5 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Recherche</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre, auteur, mot-clé..."
                                    class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200" />
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Domaine</label>
                                <select name="domaine" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200">
                                    <option value="">Tous les domaines</option>
                                    @foreach($domaines as $dom)
                                        <option value="{{ $dom }}" {{ request('domaine') === $dom ? 'selected' : '' }}>{{ ucfirst($dom) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full rounded-3xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/10 transition hover:bg-slate-800">🔎 Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>

                @if(session('message'))
                <div class="rounded-[1.5rem] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
                    ✅ {{ session('message') }}
                </div>
                @endif

                <div class="space-y-6">
            @forelse($articles as $article)
            <div class="bg-white rounded-lg border border-slate-200 p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-xl">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-slate-900 mb-3">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-emerald-600 transition">
                            {{ $article->titre }}
                        </a>
                    </h2>
                    <p class="text-sm text-slate-500 mb-2">📝 {{ $article->auteurs ?: 'Auteurs inconnus' }}</p>
                    <p class="text-xs text-slate-400">📅 {{ $article->date_publication?->format('d/m/Y') ?? 'Date inconnue' }} · 📖 {{ $article->journal ?? 'Journal inconnu' }}</p>
                </div>

                @if(Auth::check())
                    <div class="mb-6">
                        @if($article->isFavoriBy(Auth::id()))
                            <form method="POST" action="{{ route('articles.favori.remove', $article) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-3xl transition">❤️</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('articles.favori.add', $article) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-slate-300 hover:text-red-500 text-3xl transition">🤍</button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="mb-6">
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-red-500 text-3xl transition">🤍</a>
                    </div>
                @endif

                <div class="flex flex-wrap justify-center gap-2 mb-6">
                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-xs font-semibold text-emerald-700">{{ $article->domaine ?? 'Domaine' }}</span>
                    @if($article->mots_cles)
                        @foreach(array_slice(explode(',', $article->mots_cles), 0, 3) as $mot)
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-2 text-xs text-slate-600">{{ trim($mot) }}</span>
                        @endforeach
                    @endif
                </div>

                @if($article->resume_ia)
                    <div class="rounded-3xl bg-emerald-50 border border-emerald-200 p-6 mb-6">
                        <p class="text-sm font-semibold text-emerald-900 mb-3">🤖 Résumé IA</p>
                        <p class="text-sm leading-7 text-slate-700">{{ $article->resume_ia }}</p>
                    </div>
                @elseif($article->resume)
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 mb-6">
                        <p class="text-sm font-semibold text-slate-900 mb-3">📄 Résumé</p>
                        <p class="text-sm leading-7 text-slate-700">{{ Str::limit($article->resume, 250) }}</p>
                    </div>
                @endif

                <div class="flex flex-wrap justify-center gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('articles.show', $article) }}" class="inline-block rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Lire l'article →</a>
                    @if($article->doi)
                        <a href="https://doi.org/{{ $article->doi }}" target="_blank" rel="noopener" class="inline-block rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-200">Voir sur Crossref</a>
                    @endif
                    @if($article->url)
                        <a href="{{ $article->url }}" target="_blank" rel="noopener" class="inline-block rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-200">Lien direct</a>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-slate-50 border-2 border-dashed border-slate-300 rounded-lg p-12 text-center">
                <p class="text-slate-600 text-lg">📭 Aucun article trouvé</p>
                <p class="text-slate-500 mt-2">Essayez de modifier vos filtres ou demandez à un admin de synchroniser les données.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10 rounded-[2rem] bg-white border border-slate-200 px-6 py-5 shadow-lg">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection
