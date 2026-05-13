<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VeilleSci Burkina — Portail de Veille Scientifique</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:    #1a3a5c;
            --navy2:   #0f2540;
            --green:   #009A44;
            --green2:  #007a35;
            --red:     #EF2B2D;
            --gold:    #c9a84c;
            --light:   #f8f9fb;
            --border:  #dde3ed;
            --text:    #1e293b;
            --muted:   #64748b;
            --white:   #ffffff;
        }

        body { font-family: 'Inter', sans-serif; color: var(--text); background: var(--white); }

        /* ── BARRE SUPÉRIEURE ─────────────────────────────── */
        .topbar {
            background: var(--navy2);
            padding: 7px 0;
            font-size: 12px;
            color: rgba(255,255,255,0.65);
        }
        .topbar-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 32px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .topbar a { color: rgba(255,255,255,0.65); text-decoration: none; }
        .topbar a:hover { color: #fff; }
        .topbar-links { display: flex; gap: 20px; }

        /* ── NAVBAR ───────────────────────────────────────── */
        nav {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,0.07);
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 32px;
            display: flex; align-items: center; justify-content: space-between;
            height: 68px;
        }
        .logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--navy);
        }
        .logo-emblem {
            width: 44px; height: 44px; border-radius: 8px;
            background: linear-gradient(135deg, var(--navy), var(--green));
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; flex-shrink: 0;
        }
        .logo-text { line-height: 1.2; }
        .logo-title { font-family: 'Merriweather', serif; font-size: 18px; font-weight: 700; }
        .logo-title span { color: var(--green); }
        .logo-sub { font-size: 10px; color: var(--muted); letter-spacing: 0.5px; }

        .nav-links { display: flex; align-items: center; gap: 6px; }
        .nav-link {
            padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500;
            color: var(--muted); text-decoration: none; transition: all .2s;
        }
        .nav-link:hover { color: var(--navy); background: var(--light); }

        .nav-divider { width: 1px; height: 28px; background: var(--border); margin: 0 6px; }

        .btn-login {
            padding: 8px 18px; border-radius: 6px; font-size: 14px; font-weight: 600;
            color: var(--navy); text-decoration: none; border: 1.5px solid var(--border);
            transition: all .2s;
        }
        .btn-login:hover { border-color: var(--navy); background: var(--light); }

        .btn-register {
            padding: 8px 18px; border-radius: 6px; font-size: 14px; font-weight: 600;
            background: var(--green); color: #fff; text-decoration: none; border: none;
            cursor: pointer; transition: background .2s;
        }
        .btn-register:hover { background: var(--green2); }

        .btn-logout {
            padding: 8px 18px; border-radius: 6px; font-size: 14px; font-weight: 600;
            background: transparent; color: var(--red); border: 1.5px solid #fecaca;
            cursor: pointer; transition: all .2s; font-family: 'Inter', sans-serif;
        }
        .btn-logout:hover { background: #fff5f5; border-color: var(--red); }

        .btn-platform {
            padding: 8px 18px; border-radius: 6px; font-size: 14px; font-weight: 600;
            background: var(--navy); color: #fff; text-decoration: none; transition: background .2s;
        }
        .btn-platform:hover { background: var(--navy2); }

        .user-chip {
            display: flex; align-items: center; gap: 8px;
            background: var(--light); border-radius: 20px;
            padding: 5px 14px 5px 8px; font-size: 13px; color: var(--navy); font-weight: 500;
        }
        .user-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--navy); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 13px;
        }

        /* ── HERO ─────────────────────────────────────────── */
        .hero {
            background: linear-gradient(160deg, var(--navy2) 0%, var(--navy) 60%, #1d5c3a 100%);
            padding: 80px 32px 90px; text-align: center; position: relative; overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-inner { max-width: 800px; margin: 0 auto; position: relative; z-index: 1; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.9); border-radius: 4px;
            padding: 5px 14px; font-size: 12px; font-weight: 600;
            letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 28px;
        }
        .hero h1 {
            font-family: 'Merriweather', serif;
            font-size: clamp(28px, 5vw, 52px);
            font-weight: 900; color: #fff; line-height: 1.2; margin-bottom: 20px;
        }
        .hero h1 span { color: #6ee7a0; }
        .hero p {
            font-size: clamp(15px, 2vw, 18px); color: rgba(255,255,255,0.75);
            line-height: 1.8; max-width: 600px; margin: 0 auto 36px;
        }
        .hero-cta { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .cta-primary {
            padding: 14px 32px; background: var(--green); color: #fff;
            border-radius: 6px; font-size: 15px; font-weight: 700;
            text-decoration: none; transition: background .2s;
        }
        .cta-primary:hover { background: var(--green2); }
        .cta-secondary {
            padding: 14px 32px; background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.3); color: #fff;
            border-radius: 6px; font-size: 15px; font-weight: 600;
            text-decoration: none; transition: all .2s;
        }
        .cta-secondary:hover { background: rgba(255,255,255,0.18); }

        /* ── STATS ────────────────────────────────────────── */
        .stats {
            background: #fff; border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .stats-inner {
            max-width: 900px; margin: 0 auto;
            display: flex; flex-wrap: wrap;
        }
        .stat {
            flex: 1; min-width: 150px; padding: 28px 20px; text-align: center;
            border-right: 1px solid var(--border);
        }
        .stat:last-child { border-right: none; }
        .stat-num {
            font-family: 'Merriweather', serif;
            font-size: 36px; font-weight: 900; color: var(--navy);
        }
        .stat-num span { color: var(--green); }
        .stat-label { font-size: 13px; color: var(--muted); margin-top: 4px; }

        /* ── SECTIONS ─────────────────────────────────────── */
        .section { padding: 72px 32px; }
        .section-inner { max-width: 1100px; margin: 0 auto; }
        .section-header { text-align: center; margin-bottom: 52px; }
        .section-tag {
            display: inline-block; background: #e8f5ef; color: var(--green);
            padding: 4px 14px; border-radius: 4px; font-size: 12px;
            font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 14px;
        }
        .section-title {
            font-family: 'Merriweather', serif;
            font-size: clamp(22px, 3.5vw, 34px); font-weight: 700;
            color: var(--navy); margin-bottom: 12px;
        }
        .section-sub { font-size: 16px; color: var(--muted); max-width: 560px; margin: 0 auto; line-height: 1.7; }

        /* ── GRILLE CATÉGORIES ────────────────────────────── */
        .cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 16px; }
        .cat-card {
            border: 1.5px solid var(--border); border-radius: 10px; padding: 28px 18px;
            text-align: center; text-decoration: none; color: var(--text);
            transition: all .2s; background: #fff;
        }
        .cat-card:hover { border-color: var(--green); box-shadow: 0 4px 20px rgba(0,154,68,0.1); transform: translateY(-3px); }
        .cat-icon { font-size: 36px; margin-bottom: 12px; }
        .cat-name { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
        .cat-desc { font-size: 12px; color: var(--muted); line-height: 1.5; }

        /* ── FEATURES ─────────────────────────────────────── */
        .features-bg { background: var(--light); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .feat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 20px; }
        .feat-card { background: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 28px; }
        .feat-icon {
            width: 44px; height: 44px; border-radius: 8px;
            background: #e8f5ef; display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 16px;
        }
        .feat-title { font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
        .feat-desc { font-size: 13px; color: var(--muted); line-height: 1.7; }

        /* ── CTA BAS ──────────────────────────────────────── */
        .cta-section {
            background: linear-gradient(135deg, var(--navy2), var(--navy));
            padding: 80px 32px; text-align: center;
        }
        .cta-section h2 {
            font-family: 'Merriweather', serif;
            font-size: clamp(22px, 4vw, 38px); font-weight: 700;
            color: #fff; margin-bottom: 14px;
        }
        .cta-section p { color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 32px; }

        /* ── FOOTER ───────────────────────────────────────── */
        footer { background: var(--navy2); color: rgba(255,255,255,0.55); }
        .footer-main { max-width: 1200px; margin: 0 auto; padding: 48px 32px 32px; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 40px; }
        .footer-brand .logo-title { color: #fff; font-size: 20px; }
        .footer-brand p { font-size: 13px; line-height: 1.8; margin-top: 12px; }
        .footer-col h4 { color: #fff; font-size: 13px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 14px; }
        .footer-col a { display: block; color: rgba(255,255,255,0.5); font-size: 13px; text-decoration: none; margin-bottom: 8px; }
        .footer-col a:hover { color: #fff; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            max-width: 1200px; margin: 0 auto; padding: 18px 32px;
            display: flex; justify-content: space-between; font-size: 12px; flex-wrap: wrap; gap: 8px;
        }

        @media (max-width: 768px) {
            .topbar-links { display: none; }
            .nav-link { display: none; }
            .footer-main { grid-template-columns: 1fr; }
            .stat { min-width: 120px; }
        }
    </style>
</head>
<body>

{{-- ── BARRE SUPÉRIEURE ────────────────────────────────── --}}
<div class="topbar">
    <div class="topbar-inner">
        <span>🇧🇫 Portail National de Veille Scientifique — Burkina Faso</span>
        <div class="topbar-links">
            <a href="#">Contact</a>
            <a href="#">À propos</a>
            <a href="#">Guide d'utilisation</a>
        </div>
    </div>
</div>

{{-- ── NAVBAR ───────────────────────────────────────────── --}}
<nav>
    <div class="nav-inner">
        <a href="/" class="logo">
            <div class="logo-emblem">🔬</div>
            <div class="logo-text">
                <div class="logo-title">VeilleSci <span>BF</span></div>
                <div class="logo-sub">Portail de Veille Scientifique</div>
            </div>
        </a>

        <div class="nav-links">
            <a href="#categories" class="nav-link">Catégories</a>
            <a href="#fonctionnalites" class="nav-link">Fonctionnalités</a>
            <a href="#" class="nav-link">À propos</a>

            <div class="nav-divider"></div>

            @auth
                {{-- Utilisateur connecté --}}
                <div class="user-chip">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    {{ auth()->user()->name }}
                </div>
                <a href="/app" class="btn-platform">Tableau de bord</a>
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Déconnexion</button>
                </form>
            @else
                {{-- Visiteur --}}
                <a href="/login"    class="btn-login">Se connecter</a>
                <a href="/register" class="btn-register">Créer un compte</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ── HERO ─────────────────────────────────────────────── --}}
<section class="hero">
    <div class="hero-inner">
        <div class="hero-badge">🎓 Plateforme académique — Accès gratuit</div>
        <h1>La veille scientifique<br/>au service des chercheurs<br/><span>burkinabè</span></h1>
        <p>
            Centralisez et suivez toutes vos opportunités de recherche —
            publications, conférences, bourses, formations et stages —
            en un seul portail fiable et actualisé.
        </p>
        <div class="hero-cta">
            @auth
                <a href="/app" class="cta-primary">📋 Accéder aux opportunités</a>
            @else
                <a href="/register" class="cta-primary">🚀 Créer un compte gratuit</a>
                <a href="/login"    class="cta-secondary">Se connecter</a>
            @endauth
        </div>
    </div>
</section>

{{-- ── STATS ────────────────────────────────────────────── --}}
<div class="stats">
    <div class="stats-inner">
        <div class="stat">
            <div class="stat-num"><span>50</span>+</div>
            <div class="stat-label">Opportunités actives</div>
        </div>
        <div class="stat">
            <div class="stat-num"><span>5</span></div>
            <div class="stat-label">Catégories couvertes</div>
        </div>
        <div class="stat">
            <div class="stat-num"><span>20</span>+</div>
            <div class="stat-label">Pays représentés</div>
        </div>
        <div class="stat">
            <div class="stat-num"><span>100</span>%</div>
            <div class="stat-label">Gratuit pour les chercheurs</div>
        </div>
    </div>
</div>

{{-- ── CATÉGORIES ───────────────────────────────────────── --}}
<section class="section" id="categories">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-tag">Domaines couverts</div>
            <h2 class="section-title">Toutes vos opportunités,<br/>au même endroit</h2>
            <p class="section-sub">5 catégories soigneusement sélectionnées pour répondre aux besoins des chercheurs africains.</p>
        </div>
        <div class="cat-grid">
            <a href="{{ auth()->check() ? '/app' : '/login' }}" class="cat-card">
                <div class="cat-icon">📄</div>
                <div class="cat-name">Publications</div>
                <div class="cat-desc">Appels à articles dans des revues scientifiques indexées</div>
            </a>
            <a href="{{ auth()->check() ? '/app' : '/login' }}" class="cat-card">
                <div class="cat-icon">🎤</div>
                <div class="cat-name">Conférences</div>
                <div class="cat-desc">Événements scientifiques nationaux et internationaux</div>
            </a>
            <a href="{{ auth()->check() ? '/app' : '/login' }}" class="cat-card">
                <div class="cat-icon">🎓</div>
                <div class="cat-name">Bourses</div>
                <div class="cat-desc">Bourses de recherche, de mobilité et de financement doctoral</div>
            </a>
            <a href="{{ auth()->check() ? '/app' : '/login' }}" class="cat-card">
                <div class="cat-icon">📚</div>
                <div class="cat-name">Formations</div>
                <div class="cat-desc">Renforcements de capacités, certifications et ateliers</div>
            </a>
            <a href="{{ auth()->check() ? '/app' : '/login' }}" class="cat-card">
                <div class="cat-icon">🏢</div>
                <div class="cat-name">Stages</div>
                <div class="cat-desc">Stages de recherche dans des institutions de renom</div>
            </a>
        </div>
    </div>
</section>

{{-- ── FONCTIONNALITÉS ──────────────────────────────────── --}}
<div class="features-bg" id="fonctionnalites">
    <section class="section">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-tag">Fonctionnalités</div>
                <h2 class="section-title">Conçu pour vous faire<br/>gagner du temps</h2>
                <p class="section-sub">Des outils simples et puissants pour ne rater aucune opportunité scientifique.</p>
            </div>
            <div class="feat-grid">
                <div class="feat-card">
                    <div class="feat-icon">🔍</div>
                    <div class="feat-title">Recherche avancée</div>
                    <div class="feat-desc">Filtrez par catégorie, domaine, pays ou date limite pour trouver exactement ce dont vous avez besoin.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon">⚠️</div>
                    <div class="feat-title">Alertes d'urgence</div>
                    <div class="feat-desc">Les opportunités dont la date limite approche à moins de 14 jours sont signalées automatiquement.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon">🤖</div>
                    <div class="feat-title">Assistant IA intégré</div>
                    <div class="feat-desc">Un assistant intelligent pour répondre à vos questions et vous aider à rédiger vos candidatures.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon">📱</div>
                    <div class="feat-title">Accessible partout</div>
                    <div class="feat-desc">Interface responsive consultable sur ordinateur, tablette et smartphone.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon">🌍</div>
                    <div class="feat-title">Couverture internationale</div>
                    <div class="feat-desc">Opportunités locales (Burkina Faso) et internationales pour maximiser vos chances de succès.</div>
                </div>
                <div class="feat-card">
                    <div class="feat-icon">🔄</div>
                    <div class="feat-title">Données actualisées</div>
                    <div class="feat-desc">Notre équipe met à jour régulièrement la base de données pour garantir l'exactitude des informations.</div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ── CTA FINAL ────────────────────────────────────────── --}}
<div class="cta-section">
    <h2>Prêt à booster<br/>votre carrière scientifique ?</h2>
    <p>Rejoignez les chercheurs burkinabè qui ne ratent plus aucune opportunité.</p>
    @auth
        <a href="/app" class="cta-primary">📋 Voir les opportunités</a>
    @else
        <a href="/register" class="cta-primary" style="font-size:16px; padding:16px 40px;">
            🚀 Créer un compte gratuitement
        </a>
    @endauth
</div>

{{-- ── FOOTER ───────────────────────────────────────────── --}}
<footer>
    <div class="footer-main">
        <div class="footer-brand">
            <div class="logo" style="text-decoration:none;">
                <div class="logo-emblem" style="width:38px;height:38px;font-size:18px;">🔬</div>
                <div class="logo-title" style="color:#fff; font-family:'Merriweather',serif; font-size:17px;">
                    VeilleSci <span style="color:#6ee7a0;">BF</span>
                </div>
            </div>
            <p>Portail national de veille scientifique dédié aux chercheurs et académiciens du Burkina Faso.</p>
        </div>
        <div class="footer-col">
            <h4>Navigation</h4>
            <a href="/">Accueil</a>
            <a href="#categories">Catégories</a>
            <a href="#fonctionnalites">Fonctionnalités</a>
            <a href="#">À propos</a>
        </div>
        <div class="footer-col">
            <h4>Compte</h4>
            @auth
                <a href="/app">Tableau de bord</a>
                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:rgba(255,255,255,0.5);font-size:13px;cursor:pointer;padding:0;margin-bottom:8px;display:block;">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="/login">Se connecter</a>
                <a href="/register">Créer un compte</a>
            @endauth
            <a href="#">Contact</a>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} VeilleSci Burkina — Tous droits réservés</span>
        <span>🇧🇫 Fait avec ❤️ au Burkina Faso</span>
    </div>
</footer>

</body>
</html>