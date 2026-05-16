<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Forum — VeilleSci Burkina</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{--navy:#1a3a5c;--navy2:#0f2540;--green:#009A44;--green2:#007a35;--border:#dde3ed;--light:#f8f9fb;--muted:#64748b;--red:#ef4444;--gold:#c9a84c}
        body{font-family:'Inter',sans-serif;background:var(--light);min-height:100vh}

        /* Topbar */
        .topbar{background:var(--navy2);padding:7px 32px;font-size:12px;color:rgba(255,255,255,.55);text-align:center}

        /* Nav */
        nav{background:#fff;border-bottom:1px solid var(--border);padding:0 32px;display:flex;align-items:center;justify-content:space-between;height:64px}
        .logo{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--navy)}
        .logo-icon{width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,var(--navy),var(--green));display:flex;align-items:center;justify-content:center;font-size:18px}
        .logo-title{font-family:'Merriweather',serif;font-size:17px;font-weight:700}
        .logo-title span{color:var(--green)}
        .logo-sub{font-size:10px;color:var(--muted)}
        .nav-links{display:flex;align-items:center;gap:8px}
        .btn{padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;transition:all .2s;cursor:pointer;font-family:inherit;border:none}
        .btn-outline{border:1.5px solid var(--border);color:var(--navy);background:transparent}
        .btn-outline:hover{border-color:var(--navy);background:var(--light)}
        .btn-green{background:var(--green);color:#fff}
        .btn-green:hover{background:var(--green2)}

        /* Banner */
        .banner{background:linear-gradient(135deg,var(--navy2),var(--navy));padding:40px 32px}
        .banner-inner{max-width:1000px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap}
        .banner h1{font-family:'Merriweather',serif;font-size:28px;font-weight:700;color:#fff;margin-bottom:6px}
        .banner p{font-size:14px;color:rgba(255,255,255,.65)}
        .banner-stats{display:flex;gap:24px;flex-wrap:wrap}
        .bstat{text-align:center}
        .bstat-num{font-size:22px;font-weight:800;color:#6ee7a0}
        .bstat-label{font-size:11px;color:rgba(255,255,255,.55);margin-top:2px}

        /* Contenu */
        main{max-width:1000px;margin:28px auto 60px;padding:0 24px;display:grid;grid-template-columns:1fr 280px;gap:24px}

        /* Filtres */
        .filters{background:#fff;border:1px solid var(--border);border-radius:12px;padding:20px;margin-bottom:20px}
        .filters form{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
        .filters input[type=text]{flex:1;min-width:180px;padding:9px 13px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s}
        .filters input:focus{border-color:var(--green)}
        .filters select{padding:9px 13px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;font-family:'Inter',sans-serif;outline:none;cursor:pointer}

        /* Topic card */
        .topic-card{background:#fff;border:1px solid var(--border);border-radius:12px;padding:18px 20px;margin-bottom:12px;display:flex;gap:16px;transition:box-shadow .2s,border-color .2s;text-decoration:none;color:inherit}
        .topic-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);border-color:#c7d7e8}
        .topic-card.epingle{border-left:4px solid var(--gold)}
        .topic-card.resolu{border-left:4px solid var(--green)}

        .topic-avatar{width:44px;height:44px;border-radius:50%;background:var(--navy);color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;flex-shrink:0}
        .topic-body{flex:1;min-width:0}
        .topic-meta{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:6px}
        .topic-titre{font-size:15px;font-weight:700;color:var(--navy);margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .topic-excerpt{font-size:13px;color:var(--muted);line-height:1.5;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .topic-footer{display:flex;align-items:center;gap:16px;margin-top:8px;font-size:12px;color:var(--muted)}

        /* Badges */
        .badge{display:inline-flex;align-items:center;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700}
        .badge-cat{background:rgba(26,58,92,.08);color:var(--navy)}
        .badge-resolu{background:rgba(0,154,68,.1);color:var(--green)}
        .badge-epingle{background:rgba(201,168,76,.15);color:var(--gold)}
        .badge-new{background:#fef3c7;color:#92400e}

        /* Stats droite */
        .sidebar-card{background:#fff;border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:16px}
        .sidebar-head{padding:14px 18px;border-bottom:1px solid var(--border);font-size:14px;font-weight:700;color:var(--navy)}
        .sidebar-body{padding:16px 18px}
        .cat-item{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);font-size:13px;text-decoration:none;color:var(--muted);transition:color .2s}
        .cat-item:last-child{border-bottom:none}
        .cat-item:hover{color:var(--navy)}
        .cat-count{background:var(--light);border-radius:10px;padding:2px 8px;font-size:11px;font-weight:700;color:var(--navy)}
        .top-user{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)}
        .top-user:last-child{border-bottom:none}
        .top-avatar{width:34px;height:34px;border-radius:50%;background:var(--green);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700}
        .top-name{font-size:13px;font-weight:600;color:var(--navy)}
        .top-count{font-size:11px;color:var(--muted)}

        .empty{text-align:center;padding:48px;color:var(--muted)}
        .empty-icon{font-size:40px;margin-bottom:12px}

        @media(max-width:768px){main{grid-template-columns:1fr}}
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
            <a href="{{ route('register') }}" class="btn btn-green">Créer un compte</a>
        @endauth
    </div>
</nav>

{{-- Banner --}}
<div class="banner">
    <div class="banner-inner">
        <div>
            <h1>💬 Forum des chercheurs</h1>
            <p>Posez vos questions, partagez vos expériences, entraidez-vous.</p>
        </div>
        <div class="banner-stats">
            <div class="bstat"><div class="bstat-num">{{ $stats['total'] }}</div><div class="bstat-label">Sujets</div></div>
            <div class="bstat"><div class="bstat-num">{{ $stats['replies'] }}</div><div class="bstat-label">Réponses</div></div>
            <div class="bstat"><div class="bstat-num">{{ $stats['resolus'] }}</div><div class="bstat-label">Résolus</div></div>
            <div class="bstat"><div class="bstat-num">{{ $stats['membres'] }}</div><div class="bstat-label">Membres</div></div>
        </div>
    </div>
</div>

<main>
    <div>
        {{-- Filtres --}}
        <div class="filters">
            <form method="GET" action="{{ route('forum.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Rechercher un sujet..."/>
                <select name="categorie">
                    <option value="Toutes">Toutes les catégories</option>
                    @foreach(['Bourses','Publications','Conférences','Formations','Stages','Méthodologie','Général'] as $cat)
                        <option value="{{ $cat }}" {{ request('categorie') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline">Filtrer</button>
                @auth
                    <a href="{{ route('forum.create') }}" class="btn btn-green">+ Nouveau sujet</a>
                @endauth
            </form>
        </div>

        {{-- Liste --}}
        @forelse($topics as $topic)
            <a href="{{ route('forum.show', $topic) }}"
               class="topic-card {{ $topic->epingle ? 'epingle' : '' }} {{ $topic->resolu ? 'resolu' : '' }}">

                <div class="topic-avatar">
                    {{ strtoupper(substr($topic->user->name, 0, 1)) }}
                </div>

                <div class="topic-body">
                    <div class="topic-meta">
                        <span class="badge badge-cat">{{ $topic->categorie }}</span>
                        @if($topic->epingle) <span class="badge badge-epingle">📌 Épinglé</span> @endif
                        @if($topic->resolu)  <span class="badge badge-resolu">✅ Résolu</span> @endif
                        @if($topic->created_at->diffInHours() < 24) <span class="badge badge-new">Nouveau</span> @endif
                    </div>
                    <div class="topic-titre">{{ $topic->titre }}</div>
                    <div class="topic-excerpt">{{ Str::limit($topic->contenu, 100) }}</div>
                    <div class="topic-footer">
                        <span>👤 {{ $topic->user->name }}</span>
                        <span>💬 {{ $topic->replies_count ?? $topic->replies->count() }} réponse(s)</span>
                        <span>👁 {{ $topic->vues }} vue(s)</span>
                        <span>🕐 {{ $topic->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="empty">
                <div class="empty-icon">💬</div>
                <p>Aucun sujet pour le moment.<br/>Soyez le premier à poster !</p>
                @auth
                    <a href="{{ route('forum.create') }}" class="btn btn-green" style="display:inline-block;margin-top:16px;">✏️ Créer un sujet</a>
                @endauth
            </div>
        @endforelse

        {{-- Pagination --}}
        <div style="margin-top:20px">{{ $topics->withQueryString()->links() }}</div>
    </div>

    {{-- Sidebar --}}
    <div>
        {{-- Catégories --}}
        <div class="sidebar-card">
            <div class="sidebar-head">📂 Catégories</div>
            <div class="sidebar-body" style="padding:0 18px;">
                @foreach(['Bourses','Publications','Conférences','Formations','Stages','Méthodologie','Général'] as $cat)
                    <a href="{{ route('forum.index', ['categorie' => $cat]) }}" class="cat-item">
                        <span>{{ $cat }}</span>
                        <span class="cat-count">{{ \App\Models\ForumTopic::where('categorie', $cat)->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Top contributeurs --}}
        <div class="sidebar-card">
            <div class="sidebar-head">🏆 Top contributeurs</div>
            <div class="sidebar-body" style="padding:8px 18px;">
                @foreach(\App\Models\User::withCount('forumReplies')->orderByDesc('forum_replies_count')->take(5)->get() as $u)
                    <div class="top-user">
                        <div class="top-avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                        <div>
                            <div class="top-name">{{ $u->name }}</div>
                            <div class="top-count">{{ $u->forum_replies_count }} réponse(s)</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Règles --}}
        <div class="sidebar-card">
            <div class="sidebar-head">📜 Règles du forum</div>
            <div class="sidebar-body" style="font-size:13px;color:var(--muted);line-height:1.7;">
                <p>✅ Soyez respectueux</p>
                <p>✅ Restez dans le sujet</p>
                <p>✅ Partagez des sources fiables</p>
                <p>✅ Marquez vos sujets comme résolus</p>
                <p>❌ Pas de spam ni de publicité</p>
            </div>
        </div>
    </div>
</main>

</body>
</html>