@if(!Auth::check() || !Auth::user()->is_admin)
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #f8f9fb;">
        <div style="text-align: center; padding: 40px;">
            <h1 style="color: #ef2b2d; margin-bottom: 20px;">🚫 Accès Refusé</h1>
            <p style="color: #64748b; font-size: 16px; margin-bottom: 20px;">Seuls les administrateurs ont accès à cette zone.</p>
            <a href="/app" style="display: inline-block; background: #1a3a5c; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none;">← Retourner à l'application</a>
        </div>
    </div>
@else
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Utilisateurs - VeilleSci Burkina</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --navy: #1a3a5c;
            --navy2: #0f2540;
            --green: #009A44;
            --red: #EF2B2D;
            --border: #dde3ed;
            --text: #1e293b;
            --muted: #64748b;
            --bg: #f8f9fb;
        }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* ── NAVBAR ──────────────────────────────────── */
        .navbar {
            background: var(--navy2);
            color: #fff;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-size: 18px; font-weight: 700; }
        .navbar-right { display: flex; gap: 20px; align-items: center; }
        .navbar-right a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.2s;
        }
        .navbar-right a:hover { color: #fff; }
        .btn-logout {
            background: rgba(239,43,45,0.18);
            border: 1px solid rgba(239,43,45,0.45);
            color: #fca5a5;
            border-radius: 6px;
            padding: 8px 14px;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: rgba(239,43,45,0.32); }

        /* ── CONTAINER ───────────────────────────────── */
        .container { max-width: 1200px; margin: 0 auto; padding: 32px; }

        /* ── MESSAGES ────────────────────────────────── */
        .alert {
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 24px;
            border: 1px solid;
        }
        .alert-success {
            background: #e8f5ef;
            color: #059669;
            border-color: #86efac;
        }
        .alert-error {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* ── HEADER ──────────────────────────────────── */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--navy);
        }

        /* ── STATS ───────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            border-left: 4px solid var(--green);
        }
        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--green);
        }
        .stat-label { font-size: 12px; color: var(--muted); margin-top: 4px; }

        /* ── BUTTON ──────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background: var(--green);
            color: #fff;
        }
        .btn-primary:hover { background: #007a35; }
        .btn-secondary {
            background: var(--border);
            color: var(--text);
        }
        .btn-secondary:hover { background: #cbd5e1; }

        /* ── TABLE ───────────────────────────────────── */
        .table-container {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: var(--bg);
            padding: 14px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 14px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        tr:hover { background: var(--bg); }

        /* ── BADGE ───────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-green { background: #e8f5ef; color: #059669; }
        .badge-blue { background: #eff6ff; color: #0284c7; }

        /* ── LINKS ───────────────────────────────────── */
        .nav-links {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 16px;
        }
        .nav-links a {
            padding: 8px 16px;
            text-decoration: none;
            color: var(--muted);
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        .nav-links a.active {
            color: var(--green);
            border-bottom-color: var(--green);
        }
        .nav-links a:hover {
            color: var(--navy);
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <div class="navbar-brand">🔬 VeilleSci Admin</div>
        <div class="navbar-right">
            <a href="/">← Retour au site</a>
            <form method="POST" action="/logout" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">🚪 Déconnexion</button>
            </form>
        </div>
    </div>

    <!-- CONTAINER -->
    <div class="container">
        <!-- MESSAGES -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success">✅ {{ $message }}</div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-error">❌ {{ $message }}</div>
        @endif

        <!-- NAVIGATION -->
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">📊 Opportunités</a>
            <a href="{{ route('admin.users') }}" class="active">👥 Utilisateurs</a>
        </div>

        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">👥 Utilisateurs de la Plateforme</h1>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ count($users) }}</div>
                <div class="stat-label">Utilisateurs totaux</div>
            </div>
            <div class="stat-card" style="border-left-color: #3b82f6;">
                <div class="stat-number" style="color: #3b82f6;">{{ count($users->where('is_admin', true)) }}</div>
                <div class="stat-label">Administrateurs</div>
            </div>
            <div class="stat-card" style="border-left-color: #10b981;">
                <div class="stat-number" style="color: #10b981;">{{ count($users->where('is_admin', false)) }}</div>
                <div class="stat-label">Utilisateurs normaux</div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Inscrit le</th>
                        <th>Dernière connexion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->is_admin ? 'badge-blue' : 'badge-green' }}">
                                    {{ $user->is_admin ? '👑 Admin' : '👤 Utilisateur' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                            <td>
                                @if ($user->last_login_at)
                                    {{ $user->last_login_at->format('d/m/Y à H:i') }}
                                @else
                                    <span style="color: var(--muted);">Jamais</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--muted); padding: 40px;">
                                Aucun utilisateur inscrit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
@endif
