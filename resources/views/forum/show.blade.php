<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $forum->titre }} — Forum VeilleSci</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{--navy:#1a3a5c;--navy2:#0f2540;--green:#009A44;--green2:#007a35;--border:#dde3ed;--light:#f8f9fb;--muted:#64748b;--red:#ef4444;--gold:#c9a84c}
        body{font-family:'Inter',sans-serif;background:var(--light);min-height:100vh}

        .topbar{background:var(--navy2);padding:7px 32px;font-size:12px;color:rgba(255,255,255,.55);text-align:center}
        nav{background:#fff;border-bottom:1px solid var(--border);padding:0 32px;display:flex;align-items:center;justify-content:space-between;height:64px}
        .logo{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--navy)}
        .logo-icon{width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,var(--navy),var(--green));display:flex;align-items:center;justify-content:center;font-size:18px}
        .logo-title{font-family:'Merriweather',serif;font-size:17px;font-weight:700}
        .logo-title span{color:var(--green)}
        .logo-sub{font-size:10px;color:var(--muted)}
        .nav-links{display:flex;gap:8px}
        .btn{padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;cursor:pointer;font-family:inherit;border:none;transition:all .2s}
        .btn-outline{border:1.5px solid var(--border);color:var(--navy);background:transparent}
        .btn-outline:hover{border-color:var(--navy)}
        .btn-green{background:var(--green);color:#fff}
        .btn-green:hover{background:var(--green2)}

        main{max-width:860px;margin:28px auto 60px;padding:0 24px}

        /* Breadcrumb */
        .breadcrumb{font-size:13px;color:var(--muted);margin-bottom:20px;display:flex;align-items:center;gap:6px}
        .breadcrumb a{color:var(--green);text-decoration:none}

        /* Sujet principal */
        .topic-card{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden;margin-bottom:24px}
        .topic-head{padding:20px 24px;border-bottom:1px solid var(--border);background:linear-gradient(135deg,var(--navy2),var(--navy))}
        .topic-badges{display:flex;gap:8px;margin-bottom:10px;flex-wrap:wrap}
        .badge{padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700}
        .badge-cat{background:rgba(255,255,255,.15);color:#fff}
        .badge-resolu{background:rgba(0,154,68,.3);color:#6ee7a0}
        .topic-titre{font-family:'Merriweather',serif;font-size:22px;font-weight:700;color:#fff;line-height:1.3;margin-bottom:8px}
        .topic-stats{display:flex;gap:16px;font-size:12px;color:rgba(255,255,255,.55)}

        .topic-body{padding:24px}
        .topic-content{font-size:15px;color:#374151;line-height:1.85;white-space:pre-wrap}

        .topic-author{display:flex;align-items:center;gap:12px;padding:16px 24px;border-top:1px solid var(--border);background:var(--light)}
        .author-avatar{width:40px;height:40px;border-radius:50%;background:var(--navy);color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;flex-shrink:0}
        .author-name{font-size:14px;font-weight:700;color:var(--navy)}
        .author-sub{font-size:12px;color:var(--muted)}
        .topic-actions{display:flex;gap:8px;margin-left:auto;flex-wrap:wrap}

        /* Réponses */
        .replies-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
        .replies-head h2{font-family:'Merriweather',serif;font-size:18px;color:var(--navy)}

        .reply-card{background:#fff;border:1px solid var(--border);border-radius:12px;margin-bottom:14px;overflow:hidden;transition:box-shadow .2s}
        .reply-card.meilleure{border-color:var(--green);box-shadow:0 0 0 2px rgba(0,154,68,.12)}
        .reply-card.meilleure .reply-author{background:rgba(0,154,68,.06)}

        .reply-author{display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);background:var(--light)}
        .reply-avatar{width:36px;height:36px;border-radius:50%;background:var(--green);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;flex-shrink:0}
        .reply-content{padding:18px;font-size:14px;color:#374151;line-height:1.8;white-space:pre-wrap}
        .reply-footer{padding:10px 18px;border-top:1px solid var(--border);background:var(--light);display:flex;align-items:center;gap:8px}

        .btn-xs{padding:5px 12px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;border:none;transition:all .2s;text-decoration:none}
        .btn-xs-outline{border:1px solid var(--border);background:#fff;color:var(--muted)}
        .btn-xs-outline:hover{border-color:var(--navy);color:var(--navy)}
        .btn-xs-green{background:rgba(0,154,68,.1);color:var(--green);border:1px solid rgba(0,154,68,.2)}
        .btn-xs-green:hover{background:rgba(0,154,68,.2)}
        .btn-xs-red{background:#fff0f0;color:var(--red);border:1px solid #fecaca}

        /* Formulaire réponse */
        .reply-form{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden;margin-top:28px}
        .reply-form-head{padding:16px 20px;border-bottom:1px solid var(--border);font-size:15px;font-weight:700;color:var(--navy)}
        .reply-form-body{padding:20px}
        textarea{width:100%;padding:12px;border:1.5px solid var(--border);border-radius:8px;font-size:14px;font-family:'Inter',sans-serif;resize:vertical;min-height:120px;outline:none;transition:border-color .2s}
        textarea:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(0,154,68,.1)}

        .alert{border-radius:8px;padding:12px 16px;font-size:13px;margin-bottom:20px;display:flex;align-items:center;gap:8px}
        .alert-success{background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46}
        .alert-login{background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af;text-align:center;padding:20px}
        .alert-login a{color:var(--green);font-weight:600;text-decoration:none}

        .badge-best{background:rgba(0,154,68,.12);color:var(--green);border:1px solid rgba(0,154,68,.25);padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:4px}
    </style>
</head>
<body>

<div class="topbar">🇧🇫 Portail National de Veille Scientifique — Burkina Faso</div>
<nav>
    <a href="/" class="logo">
        <div class="logo-icon">🔬</div>
        <div><div class="logo-title">VeilleSci <span>BF</span></div><div class="logo-sub">Portail de Veille Scientifique</div></div>
    </a>
    <div class="nav-links">
        <a href="{{ route('forum.index') }}" class="btn btn-outline">← Forum</a>
        @auth
            <a href="{{ route('forum.create') }}" class="btn btn-green">✏️ Nouveau sujet</a>
        @endauth
    </div>
</nav>

<main>

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('forum.index') }}">Forum</a> ›
        <span>{{ $forum->categorie }}</span> ›
        <span style="color:var(--navy)">{{ Str::limit($forum->titre, 50) }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Sujet principal --}}
    <div class="topic-card">
        <div class="topic-head">
            <div class="topic-badges">
                <span class="badge badge-cat">{{ $forum->categorie }}</span>
                @if($forum->resolu) <span class="badge badge-resolu">✅ Résolu</span> @endif
                @if($forum->epingle) <span class="badge" style="background:rgba(201,168,76,.3);color:#fde68a;">📌 Épinglé</span> @endif
            </div>
            <div class="topic-titre">{{ $forum->titre }}</div>
            <div class="topic-stats">
                <span>💬 {{ $forum->replies->count() }} réponse(s)</span>
                <span>👁 {{ $forum->vues }} vue(s)</span>
                <span>🕐 {{ $forum->created_at->diffForHumans() }}</span>
            </div>
        </div>

        <div class="topic-body">
            <p class="topic-content">{{ $forum->contenu }}</p>
        </div>

        <div class="topic-author">
            <div class="author-avatar">{{ strtoupper(substr($forum->user->name,0,1)) }}</div>
            <div>
                <div class="author-name">{{ $forum->user->name }}</div>
                <div class="author-sub">{{ $forum->user->profile?->institution ?? 'Chercheur' }} · Publié {{ $forum->created_at->diffForHumans() }}</div>
            </div>
            @auth
                @if(Auth::id() === $forum->user_id)
                    <div class="topic-actions">
                        <form method="POST" action="{{ route('forum.resoudre', $forum) }}">
                            @csrf
                            <button type="submit" class="btn-xs {{ $forum->resolu ? 'btn-xs-outline' : 'btn-xs-green' }}">
                                {{ $forum->resolu ? '🔄 Réouvrir' : '✅ Marquer résolu' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('forum.destroy', $forum) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-xs btn-xs-red"
                                onclick="return confirm('Supprimer ce sujet ?')">🗑 Supprimer</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    {{-- Réponses --}}
    <div id="replies">
        <div class="replies-head">
            <h2>💬 {{ $forum->replies->count() }} réponse(s)</h2>
        </div>

        @forelse($forum->replies->sortByDesc('meilleure_reponse') as $reply)
            <div class="reply-card {{ $reply->meilleure_reponse ? 'meilleure' : '' }}">
                <div class="reply-author">
                    <div class="reply-avatar" style="background:{{ $reply->meilleure_reponse ? 'var(--green)' : 'var(--navy)' }}">
                        {{ strtoupper(substr($reply->user->name,0,1)) }}
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:var(--navy)">{{ $reply->user->name }}</div>
                        <div style="font-size:12px;color:var(--muted)">
                            {{ $reply->user->profile?->institution ?? 'Membre' }} · {{ $reply->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if($reply->meilleure_reponse)
                        <span class="badge-best" style="margin-left:auto">✅ Meilleure réponse</span>
                    @endif
                </div>

                <div class="reply-content">{{ $reply->contenu }}</div>

                <div class="reply-footer">
                    @auth
                        {{-- Auteur du topic peut choisir la meilleure réponse --}}
                        @if(Auth::id() === $forum->user_id && !$reply->meilleure_reponse)
                            <form method="POST" action="{{ route('forum.meilleure', $reply) }}">
                                @csrf
                                <button type="submit" class="btn-xs btn-xs-green">⭐ Meilleure réponse</button>
                            </form>
                        @endif
                        {{-- Auteur de la réponse peut supprimer --}}
                        @if(Auth::id() === $reply->user_id)
                            <form method="POST" action="{{ route('forum.reply.destroy', $reply) }}" style="margin-left:auto">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-xs btn-xs-red"
                                    onclick="return confirm('Supprimer cette réponse ?')">🗑</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div style="text-align:center;padding:36px;color:var(--muted);background:#fff;border:1px solid var(--border);border-radius:12px;">
                💬 Aucune réponse pour le moment. Soyez le premier à répondre !
            </div>
        @endforelse
    </div>

    {{-- Formulaire de réponse --}}
    @auth
        <div class="reply-form">
            <div class="reply-form-head">✍️ Votre réponse</div>
            <div class="reply-form-body">
                <form method="POST" action="{{ route('forum.reply', $forum) }}">
                    @csrf
                    <textarea name="contenu" rows="5"
                        placeholder="Rédigez votre réponse ici... (minimum 10 caractères)"
                        required>{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <p style="color:var(--red);font-size:12px;margin-top:4px;">{{ $message }}</p>
                    @enderror
                    <div style="display:flex;justify-content:flex-end;margin-top:14px;">
                        <button type="submit" class="btn btn-green">💬 Publier la réponse</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-login">
            <p>Vous devez être connecté pour répondre.<br>
            <a href="{{ route('login') }}">Se connecter</a> ou
            <a href="{{ route('register') }}">Créer un compte</a></p>
        </div>
    @endauth

</main>
</body>
</html>