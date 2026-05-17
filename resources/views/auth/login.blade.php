<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Connexion — VeilleSci Burkina</title>
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
            display: flex;
            align-items: center;
            justify-content: space-between;
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
        .logo-title {
            font-family: 'Merriweather', serif;
            font-size: 17px; font-weight: 700;
        }
        .logo-title span { color: var(--green); }
        .logo-sub { font-size: 10px; color: var(--muted); }
        .nav-back {
            font-size: 13px; color: var(--muted);
            text-decoration: none; display: flex; align-items: center; gap: 6px;
            transition: color .2s;
        }
        .nav-back:hover { color: var(--navy); }

        /* ── MAIN ── */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 16px;
        }

        .card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }

        /* En-tête de la carte */
        .card-header {
            background: linear-gradient(135deg, var(--navy2), var(--navy));
            padding: 32px 36px 28px;
            text-align: center;
        }
        .card-header .icon {
            width: 56px; height: 56px; border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 26px; margin: 0 auto 14px;
        }
        .card-header h1 {
            font-family: 'Merriweather', serif;
            font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 6px;
        }
        .card-header p { font-size: 13px; color: rgba(255,255,255,0.6); }

        /* Corps de la carte */
        .card-body { padding: 32px 36px; }

        /* Alerte session */
        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0;
            color: #065f46; border-radius: 8px;
            padding: 10px 14px; font-size: 13px; margin-bottom: 20px;
        }

        /* Labels */
        label {
            display: block; font-size: 13px; font-weight: 600;
            color: var(--navy); margin-bottom: 6px;
        }

        /* Inputs */
        input[type="email"],
        input[type="password"] {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid var(--border); border-radius: 8px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: var(--light);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(0,154,68,0.12);
            background: #fff;
        }

        /* Erreurs */
        .error-msg {
            font-size: 12px; color: var(--red); margin-top: 5px;
        }

        /* Champ */
        .field { margin-bottom: 18px; }

        /* Remember me */
        .remember {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--muted); cursor: pointer;
        }
        .remember input[type="checkbox"] {
            width: 16px; height: 16px; cursor: pointer;
            accent-color: var(--green);
        }

        /* Bouton principal */
        .btn-primary {
            width: 100%; padding: 12px;
            background: var(--green); color: #fff;
            border: none; border-radius: 8px;
            font-size: 15px; font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: background .2s;
            margin-top: 24px;
        }
        .btn-primary:hover { background: var(--green2); }

        /* Liens bas */
        .card-footer {
            padding: 20px 36px 28px;
            border-top: 1px solid var(--border);
            display: flex; justify-content: space-between;
            align-items: center; flex-wrap: wrap; gap: 10px;
        }
        .card-footer a {
            font-size: 13px; color: var(--muted);
            text-decoration: none; transition: color .2s;
        }
        .card-footer a:hover { color: var(--navy); }
        .card-footer .register-link {
            font-size: 13px; color: var(--green); font-weight: 600;
            text-decoration: none;
        }
        .card-footer .register-link:hover { color: var(--green2); }

        /* Divider footer */
        .card-footer .divider { color: var(--border); }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 24px 0; color: var(--border);
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        /* Bouton Google */
        .btn-google {
            width: 100%; padding: 12px;
            background: #fff; color: #1f2937;
            border: 1.5px solid var(--border); border-radius: 8px;
            font-size: 15px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-google:hover {
            border-color: var(--green);
            background: var(--light);
        }
    </style>
</head>
<body>

    {{-- Barre supérieure --}}
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

    {{-- Contenu principal --}}
    <main>
        <div class="card">

            {{-- En-tête --}}
            <div class="card-header">
                <div class="icon">🔑</div>
                <h1>Connexion</h1>
                <p>Accédez à votre espace de veille scientifique</p>
            </div>

            {{-- Formulaire --}}
            <div class="card-body">

                {{-- Message de statut session --}}
                @if (session('status'))
                    <div class="alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="field">
                        <label for="email">Adresse e-mail</label>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="exemple@email.com" />
                        @error('email')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               placeholder="••••••••" />
                        @error('password')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Se souvenir de moi --}}
                    <label class="remember">
                        <input type="checkbox" name="remember" id="remember_me">
                        Se souvenir de moi
                    </label>

                    {{-- Bouton connexion --}}
                    <button type="submit" class="btn-primary">
                        Se connecter →
                    </button>
                </form>

                {{-- Divider --}}
                <div class="divider">Ou</div>

                {{-- Bouton Google --}}
                <a href="{{ route('auth.google') }}" class="btn-google">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Connexion avec Google
                </a>
            </div>

            {{-- Pied de carte --}}
            <div class="card-footer">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                @endif
                <span>
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="register-link">Créer un compte</a>
                </span>
            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer>
        © {{ date('Y') }} VeilleSci Burkina — Tous droits réservés
    </footer>

</body>
</html>