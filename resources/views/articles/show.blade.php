@extends('layouts.app')

@section('title', $article->titre)

@section('content')
<div class="min-h-screen bg-slate-50 pb-16">
    <div class="mx-auto max-w-6xl px-4 pt-10">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="space-y-3">
                <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                    ← Retour aux articles
                </a>
                <div class="rounded-[2rem] bg-slate-950 p-10 shadow-2xl">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center rounded-full bg-emerald-400/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100">Article détaillé</span>
                        <h1 class="mt-6 text-4xl font-black leading-tight text-white">{{ $article->titre }}</h1>
                        <p class="mt-4 text-slate-300">Un article structuré, enrichi des métadonnées et d’un résumé IA pour une lecture rapide.</p>
                    </div>
                </div>
            </div>
            <div class="grid gap-4 sm:w-72">
                <div class="rounded-[2rem] bg-white border border-slate-200 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Domaine</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ $article->domaine ?? 'Non spécifié' }}</p>
                </div>
                <div class="rounded-[2rem] bg-white border border-slate-200 p-6 shadow-lg">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Publié le</p>
                    <p class="mt-3 text-lg font-semibold text-slate-900">{{ $article->date_publication?->format('d F Y') ?? 'Date inconnue' }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[2fr_1fr]">
            <div class="space-y-8">
                <div class="rounded-[2rem] bg-white border border-slate-200 p-8 shadow-lg">
                    <div class="space-y-4">
                        @if($article->auteurs)
                            <p class="text-slate-700"><span class="font-semibold text-slate-900">✍️ Auteurs :</span> {{ $article->auteurs }}</p>
                        @endif
                        @if($article->journal)
                            <p class="text-slate-700"><span class="font-semibold text-slate-900">📖 Journal :</span> {{ $article->journal }}</p>
                        @endif
                        @if($article->doi)
                            <p class="text-slate-700"><span class="font-semibold text-slate-900">🔗 DOI :</span> <a href="https://doi.org/{{ $article->doi }}" target="_blank" rel="noopener" class="text-emerald-600 hover:underline">{{ $article->doi }}</a></p>
                        @endif
                        <p class="text-slate-700"><span class="font-semibold text-slate-900">Source :</span> {{ ucfirst($article->source) }}</p>
                    </div>
                </div>

                @if(Auth::check())
                    <div class="rounded-[2rem] bg-white border border-slate-200 p-6 shadow-lg">
                        @if($isFavori)
                            <form method="POST" action="{{ route('articles.favori.remove', $article) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-full bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700">❤️ Retirer des favoris</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('articles.favori.add', $article) }}">
                                @csrf
                                <button type="submit" class="w-full rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">🤍 Ajouter aux favoris</button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="rounded-[2rem] bg-white border border-slate-200 p-6 shadow-lg">
                        <a href="{{ route('login') }}" class="block w-full rounded-full bg-slate-950 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-800">Connectez-vous pour enregistrer</a>
                    </div>
                @endif

                @if($article->mots_cles)
                    <div class="rounded-[2rem] bg-white border border-slate-200 p-6 shadow-lg">
                        <h2 class="text-base font-semibold text-slate-900 mb-4">🏷️ Mots-clés</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $article->mots_cles) as $mot)
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-800">{{ trim($mot) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                @if($article->resume_ia)
                    <section class="rounded-[2rem] bg-slate-950 p-8 text-white shadow-2xl">
                        <h2 class="text-xl font-bold mb-4">🤖 Résumé IA</h2>
                        <p class="leading-7 text-slate-100">{{ $article->resume_ia }}</p>
                    </section>
                @endif

                @if($article->resume)
                    <section class="rounded-[2rem] bg-white border border-slate-200 p-8 shadow-lg">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">📄 Résumé original</h2>
                        <p class="leading-7 text-slate-700">{{ $article->resume }}</p>
                    </section>
                @endif

                <div class="rounded-[2rem] bg-white border border-slate-200 p-8 shadow-lg">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Actions</h2>
                    <div class="grid gap-4">
                        @if($article->url)
                            <a href="{{ $article->url }}" target="_blank" rel="noopener" class="rounded-full bg-emerald-400 px-5 py-3 text-center text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Accéder à l'article complet</a>
                        @endif
                        @if($article->doi)
                            <a href="https://doi.org/{{ $article->doi }}" target="_blank" rel="noopener" class="rounded-full border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Voir sur CrossRef</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($similaires->count() > 0)
        <section class="mt-12 rounded-[2rem] bg-white border border-slate-200 p-8 shadow-lg">
            <h2 class="text-3xl font-bold text-slate-900 mb-6">📚 Articles similaires</h2>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach($similaires as $sim)
                <a href="{{ route('articles.show', $sim) }}" class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6 transition hover:-translate-y-1 hover:shadow-xl">
                    <h3 class="text-lg font-semibold text-slate-900 mb-3">{{ Str::limit($sim->titre, 80) }}</h3>
                    <p class="text-sm text-slate-600 mb-4">{{ $sim->auteurs ? Str::limit($sim->auteurs, 60) : 'Auteurs inconnus' }}</p>
                    <p class="text-sm text-slate-700">{{ Str::limit($sim->resume_ia ?? $sim->resume, 150) }}</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection
