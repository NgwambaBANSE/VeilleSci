<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>VeilleSci Burkina — Portail de Veille Scientifique</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green:  #009A44;
            --red:    #EF2B2D;
            --dark:   #0f172a;
            --darker: #1e293b;
            --white:  #ffffff;
            --gray:   #94a3b8;
            --light:  #f1f5f9;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--dark);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 40px;
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .logo { display: flex; align-items: center; gap: 10px; font-size: 20px; font-weight: 800; }
        .logo-icon { background: var(--green); border-radius: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .nav-links { display: flex; gap: 32px; }
        .nav-links a { color: var(--gray); text-decoration: none; font-size: 14px; transition: color .2s; }
        .nav-links a:hover { color: var(--white); }
        .btn-nav {
            background: var(--green); color: #fff; border: none; border-radius: 8px;
            padding: 10px 22px; font-size: 14px; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: opacity .2s;
        }
        .btn-nav:hover { opacity: 0.85; }

        /* ─── HERO ─── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            text-align: center;
            padding: 120px 24px 80px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(0,154,68,0.18) 0%, transparent 70%),
                        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(239,43,45,0.10) 0%, transparent 70%);
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(0,154,68,0.15); border: 1px solid rgba(0,154,68,0.4);
            color: #4ade80; border-radius: 999px; padding: 6px 16px; font-size: 13px;
            font-weight: 600; margin-bottom: 28px;
        }
        .hero h1 {
            font-size: clamp(32px, 6vw, 64px);
            font-weight: 900; line-height: 1.1;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #fff 40%, #4ade80);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p {
            font-size: clamp(15px, 2vw, 19px);
            color: var(--gray); line-height: 1.7; max-width: 580px; margin: 0 auto 40px;
        }
        .hero-cta { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .btn-primary {
            background: var(--green); color: #fff; border: none; border-radius: 10px;
            padding: 14px 30px; font-size: 15px; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: transform .2s, box-shadow .2s;
            box-shadow: 0 0 24px rgba(0,154,68,0.4);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 36px rgba(0,154,68,0.55); }
        .btn-outline {
            background: transparent; color: #fff;
            border: 1.5px solid rgba(255,255,255,0.25);
            border-radius: 10px; padding: 14px 30px; font-size: 15px; font-weight: 600;
            cursor: pointer; text-decoration: none; transition: border-color .2s, background .2s;
        }
        .btn-outline:hover { border-color: rgba(255,255,255,0.6); background: rgba(255,255,255,0.05); }

        /* ─── STATS ─── */
        .stats-bar {
            display: flex; justify-content: center; flex-wrap: wrap; gap: 0;
            background: rgba(255,255,255,0.04); border-top: 1px solid rgba(255,255,255,0.08);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .stat-item {
            flex: 1; min-width: 160px; text-align: center;
            padding: 32px 16px;
            border-right: 1px solid rgba(255,255,255,0.08);
        }
        .stat-item:last-child { border-right: none; }
        .stat-num { font-size: 36px; font-weight: 900; color: var(--green); }
        .stat-label { font-size: 13px; color: var(--gray); margin-top: 4px; }

        /* ─── CATÉGORIES ─── */
        .section { padding: 80px 24px; max-width: 1100px; margin: 0 auto; }
        .section-label { color: var(--green); font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 12px; }
        .section-title { font-size: clamp(24px, 4vw, 40px); font-weight: 800; margin-bottom: 16px; }
        .section-sub { color: var(--gray); font-size: 16px; line-height: 1.7; max-width: 560px; }

        .categories-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-top: 48px;
        }
        .cat-card {
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; padding: 28px 20px; text-align: center;
            transition: transform .2s, border-color .2s, background .2s; cursor: pointer;
            text-decoration: none; color: var(--white);
        }
        .cat-card:hover { transform: translateY(-4px); border-color: rgba(0,154,68,0.5); background: rgba(0,154,68,0.08); }
        .cat-icon { font-size: 36px; margin-bottom: 12px; }
        .cat-name { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .cat-desc { font-size: 13px; color: var(--gray); line-height: 1.5; }

        /* ─── FEATURES ─── */
        .features-bg { background: rgba(255,255,255,0.02); border-top: 1px solid rgba(255,255,255,0.06); border-bottom: 1px solid rgba(255,255,255,0.06); }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-top: 48px; }
        .feature-card {
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; padding: 28px;
        }
        .feature-icon { font-size: 28px; margin-bottom: 16px; }
        .feature-title { font-size: 17px; font-weight: 700; margin-bottom: 8px; }
        .feature-desc { font-size: 14px; color: var(--gray); line-height: 1.6; }

        /* ─── CTA FINAL ─── */
        .cta-section {
            text-align: center; padding: 100px 24px;
            background: radial-gradient(ellipse 70% 60% at 50% 50%, rgba(0,154,68,0.15) 0%, transparent 70%);
        }
        .cta-section h2 { font-size: clamp(26px, 4vw, 44px); font-weight: 900; margin-bottom: 16px; }
        .cta-section p { color: var(--gray); font-size: 16px; margin-bottom: 36px; }

        /* ─── FOOTER ─── */
        footer {
            background: rgba(0,0,0,0.4); border-top: 1px solid rgba(255,255,255,0.08);
            padding: 32px 40px; display: flex; justify-content: space-between;
            align-items: center; flex-wrap: wrap; gap: 12px;
        }
        footer .logo { font-size: 16px; }
        footer p { color: var(--gray); font-size: 13px; }

        /* Drapeau BF */
        .flag { display: inline-flex; gap: 2px; margin-left: 6px; }
        .flag span { width: 10px; height: 14px; border-radius: 2px; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">
        <div class="logo-icon">🔬</div>
        VeilleSci<span style="color:var(--green)">BF</span>
    </div>
    <div class="nav-links">
        <a href="#categories">Catégories</a>
        <a href="#fonctionnalites">Fonctionnalités</a>
        <a href="#contact">Contact</a>
    </div>
    <a href="/app" class="btn-nav">Accéder à la plateforme →</a>
</nav>

<!-- HERO -->
<section class="hero">
    <div style="position:relative; z-index:1;">
        <div class="hero-badge">
            🇧🇫 Fait pour les chercheurs du Burkina Faso
        </div>
        <h1>Votre portail de<br/>veille scientifique</h1>
        <p>
            Centralisez toutes vos opportunités de recherche — publications, conférences,
            bourses, formations et stages — en un seul endroit. Avec un assistant IA pour vous guider.
        </p>
        <div class="hero-cta">
            <a href="/app" class="btn-primary">🚀 Explorer les opportunités</a>
            <a href="#fonctionnalites" class="btn-outline">En savoir plus</a>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-num">50+</div>
        <div class="stat-label">Opportunités actives</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">5</div>
        <div class="stat-label">Catégories couvertes</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">20+</div>
        <div class="stat-label">Pays représentés</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">100%</div>
        <div class="stat-label">Gratuit pour les chercheurs</div>
    </div>
</div>

<!-- CATÉGORIES -->
<section class="section" id="categories">
    <div class="section-label">Ce que vous trouverez</div>
    <h2 class="section-title">Toutes vos opportunités,<br/>au même endroit</h2>
    <p class="section-sub">Explorez les 5 grandes catégories de la veille scientifique sélectionnées pour les chercheurs africains.</p>

    <div class="categories-grid">
        <a href="/app" class="cat-card">
            <div class="cat-icon">📄</div>
            <div class="cat-name">Publications</div>
            <div class="cat-desc">Appels à articles dans des revues scientifiques indexées</div>
        </a>
        <a href="/app" class="cat-card">
            <div class="cat-icon">🎤</div>
            <div class="cat-name">Conférences</div>
            <div class="cat-desc">Conférences internationales et nationales ouvertes aux chercheurs</div>
        </a>
        <a href="/app" class="cat-card">
            <div class="cat-icon">🎓</div>
            <div class="cat-name">Bourses</div>
            <div class="cat-desc">Bourses de recherche, de mobilité et de financement de thèse</div>
        </a>
        <a href="/app" class="cat-card">
            <div class="cat-icon">📚</div>
            <div class="cat-name">Formations</div>
            <div class="cat-desc">Formations courtes, certifications et renforcements de capacités</div>
        </a>
        <a href="/app" class="cat-card">
            <div class="cat-icon">🏢</div>
            <div class="cat-name">Stages</div>
            <div class="cat-desc">Stages de recherche dans des institutions nationales et internationales</div>
        </a>
    </div>
</section>

<!-- FONCTIONNALITÉS -->
<div class="features-bg" id="fonctionnalites">
    <section class="section">
        <div class="section-label">Fonctionnalités</div>
        <h2 class="section-title">Conçu pour vous<br/>faire gagner du temps</h2>
        <p class="section-sub">Des outils simples et puissants pour ne rater aucune opportunité.</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <div class="feature-title">Recherche avancée</div>
                <div class="feature-desc">Filtrez par catégorie, domaine, pays ou date limite pour trouver exactement ce que vous cherchez.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚠️</div>
                <div class="feature-title">Alertes d'urgence</div>
                <div class="feature-desc">Les opportunités dont la date limite approche (moins de 14 jours) sont signalées automatiquement.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🤖</div>
                <div class="feature-title">Assistant IA intégré</div>
                <div class="feature-desc">Posez vos questions, obtenez de l'aide pour rédiger votre candidature ou lettre de motivation.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <div class="feature-title">Interface responsive</div>
                <div class="feature-desc">Accessible sur ordinateur, tablette et smartphone. Consultez partout, à tout moment.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌍</div>
                <div class="feature-title">Couverture internationale</div>
                <div class="feature-desc">Opportunités locales (Burkina Faso) et internationales pour maximiser vos chances.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <div class="feature-title">Mise à jour régulière</div>
                <div class="feature-desc">Les données sont actualisées régulièrement par notre équipe pour garantir leur fraîcheur.</div>
            </div>
        </div>
    </section>
</div>

<!-- CTA FINAL -->
<div class="cta-section" id="contact">
    <h2>Prêt à ne plus<br/>rater une opportunité ?</h2>
    <p>Rejoignez des centaines de chercheurs burkinabè qui utilisent VeilleSci BF.</p>
    <a href="/app" class="btn-primary" style="font-size:16px; padding: 16px 36px;">
        🚀 Accéder à la plateforme gratuitement
    </a>
</div>

<!-- FOOTER -->
<footer>
    <div class="logo">
        <div class="logo-icon" style="width:28px;height:28px;font-size:14px;">🔬</div>
        VeilleSci<span style="color:var(--green)">BF</span>
    </div>
    <p>© {{ date('Y') }} VeilleSci Burkina — Tous droits réservés</p>
    <p style="color:#4ade80;">🇧🇫 Fait avec ❤️ au Burkina Faso</p>
</footer>

</body>
</html>