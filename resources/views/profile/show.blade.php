<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mon Profil — VeilleSci Burkina</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --navy: #1a3a5c; --navy2: #0f2540; --green: #009A44; --green2: #007a35;
            --border: #dde3ed; --light: #f8f9fb; --muted: #64748b; --red: #ef4444;
        }
        body { font-family: 'Inter', sans-serif; background: var(--light); min-height: 100vh; }

        /* Topbar */
        .topbar { background: var(--navy2); padding: 7px 32px; font-size: 12px; color: rgba(255,255,255,0.55); text-align: center; }

        /* Navbar */
        nav { background: #fff; border-bottom: 1px solid var(--border); padding: 0 32px; display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--navy); }
        .logo-icon { width: 38px; height: 38px; border-radius: 8px; background: linear-gradient(135deg, var(--navy), var(--green)); display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .logo-title { font-family: 'Merriweather', serif; font-size: 17px; font-weight: 700; }
        .logo-title span { color: var(--green); }
        .logo-sub { font-size: 10px; color: var(--muted); }
        .nav-links { display: flex; align-items: center; gap: 10px; }
        .btn-sm { padding: 7px 16px; border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s; }
        .btn-outline { border: 1.5px solid var(--border); color: var(--navy); }
        .btn-outline:hover { border-color: var(--navy); background: var(--light); }
        .btn-green { background: var(--green); color: #fff; border: none; cursor: pointer; font-family: inherit; }
        .btn-green:hover { background: var(--green2); }

        /* Banner profil */
        .banner {
            background: linear-gradient(135deg, var(--navy2), var(--navy));
            padding: 40px 0 80px;
        }
        .banner-inner { max-width: 900px; margin: 0 auto; padding: 0 24px; display: flex; align-items: flex-end; gap: 24px; }
        .avatar-wrap { position: relative; }
        .avatar {
            width: 100px; height: 100px; border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3);
            background: var(--green); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 38px; font-weight: 800; overflow: hidden;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .banner-info { flex: 1; }
        .banner-tag { font-size: 11px; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .banner-name { font-family: 'Merriweather', serif; font-size: 26px; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .banner-sub { font-size: 14px; color: rgba(255,255,255,0.65); }
        .banner-links { display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap; }
        .badge-link {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8); border-radius: 20px;
            padding: 4px 12px; font-size: 12px; text-decoration: none;
            transition: background .2s;
        }
        .badge-link:hover { background: rgba(255,255,255,0.2); }

        /* Contenu */
        .content { max-width: 900px; margin: -40px auto 60px; padding: 0 24px; }
        .grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; }

        /* Cards */
        .card { background: #fff; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-bottom: 20px; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .card-head h2 { font-size: 15px; font-weight: 700; color: var(--navy); }
        .card-body { padding: 20px; }

        /* Section tag */
        .section-icon { font-size: 18px; margin-right: 8px; }

        /* Bio */
        .bio-text { font-size: 14px; color: #374151; line-height: 1.8; }
        .empty-state { font-size: 14px; color: var(--muted); font-style: italic; }

        /* Infos */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .info-item label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 3px; }
        .info-item p { font-size: 14px; color: var(--navy); }

        /* Publications */
        .pub-item {
            padding: 14px 0; border-bottom: 1px solid var(--border);
            display: flex; gap: 14px; align-items: flex-start;
        }
        .pub-item:last-child { border-bottom: none; padding-bottom: 0; }
        .pub-year { background: var(--light); border: 1px solid var(--border); border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 700; color: var(--navy); white-space: nowrap; }
        .pub-titre { font-size: 14px; font-weight: 600; color: var(--navy); margin-bottom: 3px; }
        .pub-revue { font-size: 12px; color: var(--muted); }
        .pub-type { display: inline-block; background: rgba(0,154,68,0.1); color: var(--green); border-radius: 10px; padding: 1px 8px; font-size: 11px; font-weight: 600; margin-left: 6px; }

        /* CV */
        .cv-box {
            display: flex; align-items: center; gap: 14px;
            background: var(--light); border: 1px solid var(--border);
            border-radius: 10px; padding: 16px;
        }
        .cv-icon { font-size: 32px; }
        .cv-name { font-size: 14px; font-weight: 600; color: var(--navy); }
        .cv-sub { font-size: 12px; color: var(--muted); }
        .btn-download { margin-top: 8px; display: inline-flex; align-items: center; gap: 6px; background: var(--green); color: #fff; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; }

        /* Stats sidebar */
        .stat-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border); font-size: 14px; }
        .stat-row:last-child { border-bottom: none; }
        .stat-val { font-weight: 700; color: var(--navy); }

        /* Alerte succès */
        .alert { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 8px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
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
        <a href="/app" class="btn-sm btn-outline">📋 Opportunités</a>
        <a href="/forum" class="btn-sm btn-outline">💬 Forum</a>
        <a href="{{ route('profile.edit') }}" class="btn-sm btn-green">✏️ Modifier le profil</a>
        <form method="POST" action="/logout" style="margin:0;">
            @csrf
            <button type="submit" class="btn-sm btn-outline" style="cursor:pointer;">🚪 Déconnexion</button>
        </form>
    </div>
</nav>

{{-- Banner --}}
<div class="banner">
    <div class="banner-inner">
        <div class="avatar-wrap">
            <div class="avatar">
                @if($profile->photo)
                    <img src="{{ Storage::url($profile->photo) }}" alt="Photo de profil"/>
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
        </div>
        <div class="banner-info">
            <div class="banner-tag">Profil chercheur</div>
            <div class="banner-name">
                {{ $profile->titre ? $profile->titre.' ' : '' }}{{ $user->name }}
            </div>
            <div class="banner-sub">
                {{ $profile->specialite ?? 'Spécialité non renseignée' }}
                @if($profile->institution) · {{ $profile->institution }} @endif
                @if($profile->pays) · 🌍 {{ $profile->pays }} @endif
            </div>
            <div class="banner-links">
                @if($profile->orcid)
                    <a href="{{ $profile->orcid }}" target="_blank" class="badge-link">🔗 ORCID</a>
                @endif
                @if($profile->researchgate)
                    <a href="{{ $profile->researchgate }}" target="_blank" class="badge-link">🔬 ResearchGate</a>
                @endif
                @if($profile->linkedin)
                    <a href="{{ $profile->linkedin }}" target="_blank" class="badge-link">💼 LinkedIn</a>
                @endif
                @if($profile->site_web)
                    <a href="{{ $profile->site_web }}" target="_blank" class="badge-link">🌐 Site web</a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Contenu --}}
<div class="content">

    @if(session('success'))
        <div class="alert">✅ {{ session('success') }}</div>
    @endif

    <div class="grid">

        {{-- Colonne gauche --}}
        <div>
            {{-- Biographie --}}
            <div class="card">
                <div class="card-head">
                    <h2><span class="section-icon">👤</span>Biographie</h2>
                    <a href="{{ route('profile.edit') }}" style="font-size:12px; color:var(--green); text-decoration:none;">Modifier</a>
                </div>
                <div class="card-body">
                    @if($profile->biographie)
                        <p class="bio-text">{{ $profile->biographie }}</p>
                    @else
                        <p class="empty-state">Aucune biographie renseignée. <a href="{{ route('profile.edit') }}" style="color:var(--green);">Ajouter une biographie →</a></p>
                    @endif
                </div>
            </div>

            {{-- Publications --}}
            <div class="card">
                <div class="card-head">
                    <h2><span class="section-icon">📄</span>Publications scientifiques</h2>
                    <a href="{{ route('profile.edit') }}" style="font-size:12px; color:var(--green); text-decoration:none;">Ajouter</a>
                </div>
                <div class="card-body">
                    @forelse($profile->publications ?? [] as $pub)
                        <div class="pub-item">
                            <div class="pub-year">{{ $pub['annee'] ?? '—' }}</div>
                            <div>
                                <div class="pub-titre">
                                    {{ $pub['titre'] }}
                                    <span class="pub-type">{{ $pub['type'] ?? 'Article' }}</span>
                                </div>
                                <div class="pub-revue">{{ $pub['revue'] ?? '' }}</div>
                                @if(!empty($pub['lien']))
                                    <a href="{{ $pub['lien'] }}" target="_blank" style="font-size:12px; color:var(--green); text-decoration:none;">Voir la publication →</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="empty-state">Aucune publication renseignée. <a href="{{ route('profile.edit') }}" style="color:var(--green);">Ajouter des publications →</a></p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Colonne droite --}}
        <div>
            {{-- Infos --}}
            <div class="card">
                <div class="card-head"><h2><span class="section-icon">📋</span>Informations</h2></div>
                <div class="card-body">
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <div class="info-item">
                            <label>Email</label>
                            <p>{{ $user->email }}</p>
                        </div>
                        @if($profile->telephone)
                        <div class="info-item">
                            <label>Téléphone</label>
                            <p>{{ $profile->telephone }}</p>
                        </div>
                        @endif
                        @if($profile->institution)
                        <div class="info-item">
                            <label>Institution</label>
                            <p>{{ $profile->institution }}</p>
                        </div>
                        @endif
                        @if($profile->departement)
                        <div class="info-item">
                            <label>Département</label>
                            <p>{{ $profile->departement }}</p>
                        </div>
                        @endif
                        @if($profile->ville)
                        <div class="info-item">
                            <label>Ville</label>
                            <p>{{ $profile->ville }}, {{ $profile->pays }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CV --}}
            <div class="card">
                <div class="card-head">
                    <h2><span class="section-icon">📎</span>Curriculum Vitae</h2>
                </div>
                <div class="card-body">
                    @if($profile->cv)
                        <div class="cv-box">
                            <div class="cv-icon">📄</div>
                            <div>
                                <div class="cv-name">CV de {{ $user->name }}</div>
                                <div class="cv-sub">Fichier PDF</div>
                                <a href="{{ Storage::url($profile->cv) }}" target="_blank" class="btn-download">⬇ Télécharger le CV</a>
                            </div>
                        </div>
                    @else
                        <p class="empty-state">Aucun CV téléversé. <a href="{{ route('profile.edit') }}" style="color:var(--green);">Ajouter mon CV →</a></p>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="card">
                <div class="card-head"><h2><span class="section-icon">📊</span>Statistiques</h2></div>
                <div class="card-body">
                    <div class="stat-row">
                        <span>Publications</span>
                        <span class="stat-val">{{ count($profile->publications ?? []) }}</span>
                    </div>
                    <div class="stat-row">
                        <span>Membre depuis</span>
                        <span class="stat-val">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                    <div class="stat-row">
                        <span>Profil complété</span>
                        <span class="stat-val" style="color:var(--green);">
                            @php
                                $champs = ['biographie','institution','specialite','cv','telephone'];
                                $remplis = collect($champs)->filter(fn($c) => !empty($profile->$c))->count();
                                echo round($remplis / count($champs) * 100) . '%';
                            @endphp
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>