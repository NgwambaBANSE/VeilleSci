<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Créer un compte — VeilleSci Burkina</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:   #1a3a5c;
            --navy2:  #0f2540;
            --green:  #009A44;
            --green2: #007a35;
            --border: #dde3ed;
            --light:  #f8f9fb;
            --muted:  #64748b;
            --red:    #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            background: var(--navy2);
            padding: 7px 32px;
            font-size: 12px;
            color: rgba(255,255,255,0.55);
            text-align: center;
        }

        /* ── NAVBAR ── */
        nav {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            display: flex; align-items: center; justify-content: space-between;
            height: 64px;
        }
        .logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; color: var(--navy);
        }
        .logo-icon {
            width: 38px; height: 38px; border-radius: 8px;
            background: linear-gradient(135deg, var(--navy), var(--green));
            display: flex; align-items: center; justify-content: center; font-size: 18px;
        }
        .logo-title { font-family: 'Merriweather', serif; font-size: 17px; font-weight: 700; }
        .logo-title span { color: var(--green); }
        .logo-sub { font-size: 10px; color: var(--muted); }
        .nav-back {
            font-size: 13px; color: var(--muted);
            text-decoration: none; transition: color .2s;
        }
        .nav-back:hover { color: var(--navy); }

        /* ── MAIN ── */
        main {
            flex: 1; display: flex; align-items: center;
            justify-content: center; padding: 40px 16px;
        }

        .card {
            background: #fff; border: 1px solid var(--border);
            border-radius: 16px; width: 100%; max-width: 480px;
            overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }

        /* En-tête */
        .card-header {
            background: linear-gradient(135deg, var(--navy2), var(--navy));
            padding: 28px 36px 24px; text-align: center;
        }
        .card-header .icon {
            width: 52px; height: 52px; border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin: 0 auto 12px;
        }
        .card-header h1 {
            font-family: 'Merriweather', serif;
            font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 5px;
        }
        .card-header p { font-size: 13px; color: rgba(255,255,255,0.6); }

        /* Avantages */
        .benefits {
            display: flex; justify-content: center; gap: 20px;
            margin-top: 16px; flex-wrap: wrap;
        }
        .benefit {
            display: flex; align-items: center; gap: 5px;
            font-size: 11px; color: rgba(255,255,255,0.7);
        }

        /* Corps */
        .card-body { padding: 28px 36px; }

        /* Fields */
        .field { margin-bottom: 16px; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; }

        label {
            display: block; font-size: 13px; font-weight: 600;
            color: var(--navy); margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--border); border-radius: 8px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: var(--light);
            transition: border-color .2s, box-shadow .2s; outline: none;
        }
        input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(0,154,68,0.12);
            background: #fff;
        }

        .error-msg { font-size: 12px; color: var(--red); margin-top: 5px; }

        /* Indicateur force mot de passe */
        .password-hint {
            font-size: 11px; color: var(--muted); margin-top: 5px;
        }

        /* Bouton */
        .btn-primary {
            width: 100%; padding: 12px;
            background: var(--green); color: #fff;
            border: none; border-radius: 8px;
            font-size: 15px; font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: background .2s;
            margin-top: 20px;
        }
        .btn-primary:hover { background: var(--green2); }

        /* Pied de carte */
        .card-footer {
            padding: 18px 36px 26px;
            border-top: 1px solid var(--border);
            text-align: center; font-size: 13px; color: var(--muted);
        }
        .card-footer a {
            color: var(--green); font-weight: 600;
            text-decoration: none;
        }
        .card-footer a:hover { color: var(--green2); }

        /* Conditions */
        .terms {
            font-size: 11px; color: var(--muted);
            text-align: center; margin-top: 14px; line-height: 1.6;
        }

        /* Footer page */
        footer {
            text-align: center; padding: 20px;
            font-size: 12px; color: var(--muted);
            border-top: 1px solid var(--border);
        }
    </style>
</head>
<body>

    {{-- Topbar --}}
    <div class="topbar">🇧🇫 Portail National de Veille Scientifique — Burkina Faso</div>

    {{-- Navbar --}}
    <nav>
        <a href="/" class="logo">
            <div class="logo-icon">🔬</div>
            <div>
                <div class="logo-title">VeilleSci <span>BF</span></div>
                <div class="logo-sub">Portail de Veille Scientifique</div>
            </div>
        </a>
        <a href="/" class="nav-back">← Retour à l'accueil</a>
    </nav>

    {{-- Contenu --}}
    <main>
        <div class="card">

            {{-- En-tête --}}
            <div class="card-header">
                <div class="icon">✏️</div>
                <h1>Créer un compte</h1>
                <p>Rejoignez la communauté des chercheurs burkinabè</p>
                <div class="benefits">
                    <div class="benefit">✅ Accès gratuit</div>
                    <div class="benefit">✅ Favoris & alertes</div>
                    <div class="benefit">✅ Assistant IA</div>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nom --}}
                    <div class="field">
                        <label for="name">Nom complet</label>
                        <input id="name" type="text" name="name"
                               value="{{ old('name') }}"
                               required autofocus autocomplete="name"
                               placeholder="Ex : Amadou Ouédraogo" />
                        @error('name')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="field">
                        <label for="email">Adresse e-mail</label>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               required autocomplete="username"
                               placeholder="exemple@email.com" />
                        @error('email')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Mots de passe (côte à côte sur grand écran) --}}
                    <div class="field-row">
                        <div>
                            <label for="password">Mot de passe</label>
                            <input id="password" type="password" name="password"
                                   required autocomplete="new-password"
                                   placeholder="••••••••" />
                            <p class="password-hint">8 caractères minimum</p>
                            @error('password')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation">Confirmer</label>
                            <input id="password_confirmation" type="password"
                                   name="password_confirmation"
                                   required autocomplete="new-password"
                                   placeholder="••••••••" />
                            @error('password_confirmation')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Bouton --}}
                    <button type="submit" class="btn-primary">
                        Créer mon compte →
                    </button>

                    {{-- Conditions --}}
                    <p class="terms">
                        En vous inscrivant, vous acceptez les conditions d'utilisation de la plateforme.
                    </p>
                </form>
            </div>

            {{-- Pied --}}
            <div class="card-footer">
                Déjà inscrit ?
                <a href="{{ route('login') }}">Se connecter</a>
            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer>
        © {{ date('Y') }} VeilleSci Burkina — Tous droits réservés
    </footer>

</body>
</html>