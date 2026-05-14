<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Forum — VeilleSci Burkina</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --navy:#1a3a5c; --navy2:#0f2540; --green:#009A44; --green2:#007a35; --border:#dde3ed; --light:#f8f9fb; --muted:#64748b; --gold:#c9a84c; }
        body { font-family:'Inter',sans-serif; background:var(--light); min-height:100vh; color:#1e293b; }

        /* Nav */
        .topbar { background:var(--navy2); padding:7px 32px; font-size:12px; color:rgba(255,255,255,0.55); text-align:center; }
        nav { background:#fff; border-bottom:1px solid var(--border); padding:0 32px; display:flex; align-items:center; justify-content:space-between; height:64px; }
        .logo { display:flex; align-items:center; gap:10px; text-decoration:none; color:var(--navy); }
        .logo-icon { width:38px; height:38px; border-radius:8px; background:linear-gradient(135deg,var(--navy),var(--green)); display:flex; align-items:center; justify-content:center; font-size:18px; }
        .logo-title { font-family:'Merriweather',serif; font-size:17px; font-weight:700; }
        .logo-title span { color:var(--green); }
        .logo-sub { font-size:10px; color:var(--muted); }
        .nav-links { display:flex; align-items:center; gap:8px; }
        .btn { padding:8px 18px; border-radius:7px; font-size:13px; font-weight:600; text-decoration:none; transition:all .2s; cursor:pointer; font-family:inherit; border:none; }
        .btn-outline { border:1.5px solid var(--border); color:var(--navy); background:transparent; }
        .btn-outline:hover { border-color:var(--navy); }
        .btn-green { background:var(--green); color:#fff; }
        .btn-green:hover { background:var(--green2); }

        /* Hero forum */
        .hero { background:linear-gradient(135deg,var(--navy2),var(--navy)); padding:40px 32px; }
        .hero-inner { max-width:960px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px; }
        .hero h1 { font-family:'Merriweather',serif; font-size:26px; font-weight:700; color:#fff; margin-bottom:6px; }
        .hero p { font-size:14px; color:rgba(255,255,255,0.65); }

        /* Stats bar */
        .stats-bar { background:#fff; border-bottom:1px solid var(--border); }
        .stats-inner { max-width:960px; margin:0 auto; display:flex; flex-wrap:wrap; }
        .stat { flex:1; min-width:120px; padding:16px 20px; text-align:center; border-right:1px solid var(--border); }
        .stat:last-child { border-right:none; }
        .stat-num { font-family:'Merriweather',serif; font-size:24px; font-weight:700; color:var(--navy); }
        .stat-label { font-size:12px; color:var(--muted); margin-top:2px; }

        /* Layout */
        .layout { max-width:960px; margin:28px auto 60px; padding:0 24px; display:grid; grid-template-columns:1fr 260px; gap:24px; }

        /* Filtres */
        .filters { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; align-items:center; }
        .filters form { display:flex; gap:8px; flex:1; }
        .search-input { flex:1; padding:9px 14px; border:1.5px solid var(--border); border-radius:8px; font-size:13px; font-family:'Inter',sans-serif; outline:none; }
        .search-input:focus { border-color:var(--green); }
        .cat-filter { padding:8px 14px; border:1.5px solid var(--border); border-radius:8px; font-size:13px; font-family:'Inter',sans-serif; background:#fff; cursor:pointer; outline:none; }
        .cat-filter:focus { border-color:var(--green); }

        /* Sujet card */
        .sujet-card { background:#fff; border:1px solid var(--border); border-radius:12px; padding:20px; margin-bottom:12px; display:flex; gap:16px; transition:box-shadow .2s; }
        .sujet-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.08); }
        .sujet-card.epingle { border-left:4px solid var(--gold); }
        .sujet-avatar { width:44px; height:44px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:700; flex-shrink:0; overflow:hidden; }
        .sujet-avatar img { width:100%; height:100%; object-fit:cover; }
        .sujet-body { flex:1; min-width:0; }
        .sujet-meta { display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px; }
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-cat { background:rgba(26,58,92,0.1); color:var(--navy); }
        .badge-resolu { background:#ecfdf5; color:#065f46; }
        .badge-epingle { background:rgba(201,168,76,0.15); color:#92660a; }
        .sujet-titre { font-size:15px; font-weight:700; color:var(--navy); text-decoration:none; margin-bottom:6px; display:block; }
        .sujet-titre:hover { color:var(--green); }
        .sujet-extrait { font-size:13px; color:var(--muted); line-height:1.6; margin-bottom:10px; }
        .sujet-footer { display:flex; gap:16px; font-size:12px; color:var(--muted); flex-wrap:wrap; }
        .sujet-footer span { display:flex; align-items:center; gap:4px; }
        .sujet-stats { display:flex; flex-direction:column; align-items:center; gap:4px; min-width:60px; }
        .stat-count { font-size:20px; font-weight:800; color:var(--navy); }
        .stat-count.green { color:var(--green); }
        .stat-type { font-size:10px; color:var(--muted); }

        /* Sidebar */
        .sidebar .card { background:#fff; border:1px solid var(--border); border-radius:12px; overflow:hidden; margin-bottom:16px; }
        .sidebar .card-head { padding:14px 18px; border-bottom:1px solid var(--border); font-size:14px; font-weight:700; color:var(--navy); background:var(--light); }
        .sidebar .card-body { padding:16px 18px; }
        .cat-item { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid var(--border); font-size:13px; }
        .cat-item:last-child { border-bottom:none; }
        .cat-item a { color:var(--navy); text-decoration:none; }
        .cat-item a:hover { color:var(--green); }
        .cat-count { background:var(--light); border-radius:10px; padding:2px 8px; font-size:11px; font-weight:700; color:var(--muted); }

        /* Pagination */
        .pagination { display:flex; justify-content:center; gap:8px; margin-top:24px; flex-wrap:wrap; }
        .pagination a, .pagination span { padding:8px 14px; border-radius:8px; border:1px solid var(--border); font-size:13px; text-decoration:none; color:var(--navy); background:#fff; }
        .pagination .active { background:var(--navy); color:#fff; border-color:var(--navy); }

        /* Vide */
        .empty { text-align:center; padding:60px 20px; color:var(--muted); }
        .empty-icon { font-size:48px; margin-bottom:16px; }

        @media(max-width:700px) { .layout { grid-template-columns:1fr; } .sidebar { display:none; } }
    </style>
</head>
<body>

<div class="topbar">🇧🇫 Portail National de Veille Scientifique — Burkina Faso</div>

<nav>
    <a href="/" class="logo">
        <div class="logo-icon">🔬</div>
        <div>
            <div class="logo-title">VeilleSci <span>BF</span></div>
            <div class="logo-sub">Portail de Veille Scientifique</div>
        </div>
    </a>
    <div class="nav-links">
        <a href="/app" class="btn btn-outline">📋 Opportunités</a>
        @auth
            <a href="{{ route('profile.show') }}" class="btn btn-outline">👤 Mon profil</a>
            <a href="{{ route('forum.create') }}" class="btn btn-green">✏️ Nouveau sujet</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-green">S'inscrire</a>
        @endauth
    </div>
</nav>

{{-- Hero --}}
<div class="hero">
    <div class="hero-inner">
        <div>
            <h1>💬 Forum des chercheurs</h1>
            <p>Posez vos questions, partagez vos expériences, aidez la communauté scientifique burkinabè.</p>
        </div>
        @auth
            <a href="{{ route('forum.create') }}" class="btn btn-green" style="font-size:14px; padding:12px 24px;">
                ✏️ Poser une question
            </a>
        @endauth
    </div>
</div>

{{-- Stats --}}
<div class="stats-bar">
    <div class="stats-inner">
        <div class="stat">
            <div class="stat-num">{{ $stats['total'] }}</div>
            <div class="stat-label">Sujets</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ $stats['reponses'] }}</div>
            <div class="stat-label">Réponses</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ $stats['resolus'] }}</div>
            <div class="stat-label">Résolus</div>
        </div>
        <div class="stat">
            <div class="stat-num">{{ $stats['membres'] }}</div>
            <div class="stat-label">Membres</div>
        </div>
    </div>
</div>

{{-- Layout --}}
<div class="layout">

    {{-- Colonne principale --}}
    <div>
        {{-- Filtres --}}
        <form method="GET" action="{{ route('forum.index') }}" class="filters">
            <input type="text" name="q" class="search-input" placeholder="🔍 Rechercher un sujet..." value="{{ request('q') }}"/>
            <select name="categorie" class="cat-filter" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach(['Bourses','Publications','Conférences','Formations','Stages','Méthodologie','Carrière','Autre'] as $cat)
                    <option value="{{ $cat }}" {{ request('categorie') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline" style="padding:9px 16px;">Filtrer</button>
        </form>

        {{-- Liste des sujets --}}
        @forelse($sujets as $sujet)
            <div class="sujet-card {{ $sujet->epingle ? 'epingle' : '' }}">
                {{-- Avatar --}}
                <div class="sujet-avatar">
                    @if($sujet->user->profile?->photo)
                        <img src="{{ Storage::url($sujet->user->profile->photo) }}" alt=""/>
                    @else
                        {{ strtoupper(substr($sujet->user->name, 0, 1)) }}
                    @endif
                </div>

                {{-- Contenu --}}
                <div class="sujet-body">
                    <div class="sujet-meta">
                        @if($sujet->epingle)
                            <span class="badge badge-epingle">📌 Épinglé</span>
                        @endif
                        <span class="badge badge-cat">{{ $sujet->categorie }}</span>
                        @if($sujet->resolu)
                            <span class="badge badge-resolu">✅ Résolu</span>
                        @endif
                    </div>
                    <a href="{{ route('forum.show', $sujet) }}" class="sujet-titre">
                        {{ $sujet->titre }}
                    </a>
                    <p class="sujet-extrait">{{ Str::limit($sujet->contenu, 120) }}</p>
                    <div class="sujet-footer">
                        <span>👤 {{ $sujet->user->name }}</span>
                        <span>🕐 {{ $sujet->created_at->diffForHumans() }}</span>
                        <span>👁 {{ $sujet->vues }} vue(s)</span>
                        <span>💬 {{ $sujet->reponses->count() }} réponse(s)</span>
                    </div>
                </div>

                {{-- Stats réponses --}}
                <div class="sujet-stats">
                    <div class="stat-count {{ $sujet->reponses->count() > 0 ? 'green' : '' }}">
                        {{ $sujet->reponses->count() }}
                    </div>
                    <div class="stat-type">réponse(s)</div>
                </div>
            </div>
        @empty
            <div class="empty">
                <div class="empty-icon">💬</div>
                <p style="font-size:16px; font-weight:600; color:var(--navy); margin-bottom:8px;">Aucun sujet trouvé</div>
                <p>Soyez le premier à poser une question !</p>
                @auth
                    <a href="{{ route('forum.create') }}" class="btn btn-green" style="display:inline-block; margin-top:16px;">✏️ Créer un sujet</a>
                @endauth
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($sujets->hasPages())
            <div class="pagination">
                {{$sujets->links()}}
            </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- Catégories --}}
        <div class="card">
            <div class="card-head">📁 Catégories</div>
            <div class="card-body">
                @foreach(['Bourses','Publications','Conférences','Formations','Stages','Méthodologie','Carrière','Autre'] as $cat)
                    <div class="cat-item">
                        <a href="{{ route('forum.index', ['categorie' => $cat]) }}">{{ $cat }}</a>
                        <span class="cat-count">{{ \App\Models\ForumSujet::where('categorie',$cat)->count() }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Rejoindre --}}
        @guest
            <div class="card">
                <div class="card-head">🎓 Rejoindre le forum</div>
                <div class="card-body" style="text-align:center;">
                    <p style="font-size:13px; color:var(--muted); margin-bottom:14px;">Créez un compte pour poser des questions et répondre aux autres chercheurs.</p>
                    <a href="{{ route('register') }}" class="btn btn-green" style="display:block; text-align:center; margin-bottom:8px;">S'inscrire gratuitement</a>
                    <a href="{{ route('login') }}" class="btn btn-outline" style="display:block; text-align:center;">Se connecter</a>
                </div>
            </div>
        @endguest
    </div>
</div>

</body>
</html>