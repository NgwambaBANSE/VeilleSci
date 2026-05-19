<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Nouveau sujet — Forum VeilleSci</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
        :root{--navy:#1a3a5c;--navy2:#0f2540;--green:#009A44;--green2:#007a35;--border:#dde3ed;--light:#f8f9fb;--muted:#64748b;--red:#ef4444}
        body{font-family:'Inter',sans-serif;background:var(--light);min-height:100vh}
        .topbar{background:var(--navy2);padding:7px 32px;font-size:12px;color:rgba(255,255,255,.55);text-align:center}
        nav{background:#fff;border-bottom:1px solid var(--border);padding:0 32px;display:flex;align-items:center;justify-content:space-between;height:64px}
        .logo{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--navy)}
        .logo-icon{width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,var(--navy),var(--green));display:flex;align-items:center;justify-content:center;font-size:18px}
        .logo-title{font-family:'Merriweather',serif;font-size:17px;font-weight:700}
        .logo-title span{color:var(--green)}
        .logo-sub{font-size:10px;color:var(--muted)}
        .btn{padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;cursor:pointer;font-family:inherit;border:none;transition:all .2s}
        .btn-outline{border:1.5px solid var(--border);color:var(--navy);background:transparent}
        .nav-toggle{display:none;width:42px;height:42px;border:none;background:transparent;cursor:pointer;align-items:center;justify-content:center}
        .nav-toggle span{display:block;width:22px;height:2px;background:var(--navy);border-radius:999px;position:relative;transition:transform .2s ease,opacity .2s ease}
        .nav-toggle span::before,.nav-toggle span::after{content:'';display:block;width:22px;height:2px;background:var(--navy);border-radius:999px;position:absolute;left:0;transition:transform .2s ease,opacity .2s ease}
        .nav-toggle span::before{top:-7px}
        .nav-toggle span::after{top:7px}
        .nav-mobile-menu{display:none;flex-direction:column;gap:10px;padding:16px 24px;background:#fff;border-bottom:1px solid var(--border)}
        .nav-mobile-menu a{width:100%;text-align:left}
        @media(max-width:760px){
            .nav-links{display:none;width:100%}
            .nav-toggle{display:inline-flex}
        }

        main{max-width:720px;margin:36px auto 60px;padding:0 24px}
        .page-header{margin-bottom:24px}
        .page-header h1{font-family:'Merriweather',serif;font-size:24px;color:var(--navy);margin-bottom:4px}
        .page-header p{font-size:14px;color:var(--muted)}

        .card{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden}
        .card-head{padding:18px 24px;border-bottom:1px solid var(--border);background:var(--light);font-size:15px;font-weight:700;color:var(--navy)}
        .card-body{padding:24px}

        .field{margin-bottom:18px}
        label{display:block;font-size:13px;font-weight:600;color:var(--navy);margin-bottom:6px}
        input[type=text],select,textarea{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:14px;font-family:'Inter',sans-serif;color:#1e293b;background:var(--light);outline:none;transition:border-color .2s,box-shadow .2s}
        input:focus,select:focus,textarea:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(0,154,68,.1);background:#fff}
        textarea{resize:vertical;min-height:180px;line-height:1.7}
        .error-msg{font-size:12px;color:var(--red);margin-top:4px}

        .tips{background:rgba(0,154,68,.06);border:1px solid rgba(0,154,68,.15);border-radius:10px;padding:16px;margin-bottom:24px;font-size:13px;color:#065f46;line-height:1.8}
        .tips strong{display:block;margin-bottom:6px;font-size:14px}

        .form-actions{display:flex;gap:12px;justify-content:flex-end;margin-top:24px}
        .btn-submit{padding:12px 28px;background:var(--green);color:#fff;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit}
        .btn-submit:hover{background:var(--green2)}
        .btn-cancel{padding:12px 28px;border:1.5px solid var(--border);background:#fff;color:var(--muted);border-radius:8px;font-size:15px;font-weight:600;text-decoration:none}

        .char-count{font-size:11px;color:var(--muted);text-align:right;margin-top:4px}
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
        <a href="{{ route('forum.index') }}" class="btn btn-outline">← Retour au forum</a>
    </div>
    <button class="nav-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <span aria-hidden="true"></span>
    </button>
</nav>
<div class="nav-mobile-menu" aria-hidden="true">
    <a href="{{ route('forum.index') }}" class="btn btn-outline">← Retour au forum</a>
</div>

<main>
    <div class="page-header">
        <h1>✏️ Nouveau sujet</h1>
        <p>Posez votre question ou partagez une information avec la communauté.</p>
    </div>

    <div class="tips">
        <strong>💡 Conseils pour un bon sujet :</strong>
        ✅ Soyez précis dans votre titre · ✅ Donnez suffisamment de contexte ·
        ✅ Mentionnez votre domaine de recherche · ✅ Choisissez la bonne catégorie
    </div>

    <div class="card">
        <div class="card-head">📝 Détails du sujet</div>
        <div class="card-body">

            @if($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:var(--red);border-radius:8px;padding:12px 16px;font-size:13px;margin-bottom:18px;">
                    ❌ @foreach($errors->all() as $e) {{ $e }} @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('forum.store') }}">
                @csrf

                {{-- Catégorie --}}
                <div class="field">
                    <label for="categorie">Catégorie *</label>
                    <select id="categorie" name="categorie" required>
                        <option value="">— Choisir une catégorie —</option>
                        @foreach(['Bourses','Publications','Conférences','Formations','Stages','Méthodologie','Général'] as $cat)
                            <option value="{{ $cat }}" {{ old('categorie') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('categorie')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                {{-- Titre --}}
                <div class="field">
                    <label for="titre">Titre du sujet * <small style="font-weight:400;color:var(--muted)">(min. 10 caractères)</small></label>
                    <input id="titre" type="text" name="titre"
                           value="{{ old('titre') }}"
                           placeholder="Ex : Comment postuler à la bourse CODESRIA 2026 ?"
                           maxlength="255" required
                           oninput="document.getElementById('titre-count').textContent = this.value.length + '/255'"/>
                    <div class="char-count" id="titre-count">0/255</div>
                    @error('titre')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                {{-- Contenu --}}
                <div class="field">
                    <label for="contenu">Décrivez votre question ou préoccupation * <small style="font-weight:400;color:var(--muted)">(min. 20 caractères)</small></label>
                    <textarea id="contenu" name="contenu" rows="8"
                        placeholder="Expliquez votre situation en détail. Plus vous êtes précis, plus vous obtiendrez des réponses utiles..."
                        required oninput="document.getElementById('contenu-count').textContent = this.value.length + ' caractères'">{{ old('contenu') }}</textarea>
                    <div class="char-count" id="contenu-count">0 caractères</div>
                    @error('contenu')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('forum.index') }}" class="btn-cancel">Annuler</a>
                    <button type="submit" class="btn-submit">🚀 Publier le sujet</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.nav-toggle');
        const menu = document.querySelector('.nav-mobile-menu');
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

</body>
</html>