@if(!Auth::check() || !Auth::user()->is_admin)
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="text-align: center; padding: 60px 40px; background: white; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            <h1 style="color: #ef2b2d; margin-bottom: 16px; font-size: 48px;">🚫</h1>
            <h2 style="color: #1a3a5c; margin-bottom: 12px;">Accès Refusé</h2>
            <p style="color: #64748b; font-size: 15px; margin-bottom: 24px; line-height: 1.6;">Seuls les administrateurs ont accès à cette zone.</p>
            <a href="/app" style="display: inline-block; background: linear-gradient(135deg, #009A44 0%, #007a35 100%); color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(0,154,68,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,154,68,0.2)'">← Retourner à l'application</a>
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
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --bg: #f9fafb;
            --light: #f3f4f6;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        /* ── NAVBAR ──────────────────────────────────── */
        .navbar {
            background: linear-gradient(135deg, var(--navy2) 0%, #1a3a5c 100%);
            color: #fff;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            font-size: 20px;
            font-weight: 800;
            background: linear-gradient(135deg, #00d084 0%, var(--green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .navbar-right { display: flex; gap: 24px; align-items: center; }
        .navbar-right a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s;
        }
        .navbar-right a:hover { color: #fff; }
        .btn-logout {
            background: rgba(239,43,45,0.15);
            border: 1.5px solid rgba(239,43,45,0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: rgba(239,43,45,0.25);
            box-shadow: 0 4px 12px rgba(239,43,45,0.2);
        }

        /* ── CONTAINER ───────────────────────────────── */
        .container { max-width: 1400px; margin: 0 auto; padding: 40px; }

        /* ── MESSAGES ────────────────────────────────– */
        .alert {
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            border: none;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
            border-left: 4px solid #10b981;
        }
        .alert-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }

        /* ── NAVIGATION ──────────────────────────────– */
        .nav-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 0;
        }
        .nav-tabs a {
            padding: 14px 20px;
            text-decoration: none;
            color: var(--muted);
            font-weight: 600;
            font-size: 15px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            position: relative;
            bottom: -2px;
        }
        .nav-tabs a:hover {
            color: var(--text);
        }
        .nav-tabs a.active {
            color: var(--green);
            border-bottom-color: var(--green);
        }

        /* ── HEADER ──────────────────────────────────– */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        .page-title {
            font-size: 32px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.5px;
        }

        /* ── STATS GRID ──────────────────────────────– */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #f9fafb 100%);
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--green), #00d084);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 40px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--green), #00d084);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 14px;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── TABLE ───────────────────────────────────– */
        .table-container {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: var(--light);
            padding: 16px 20px;
            text-align: left;
            font-weight: 700;
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        tr:hover { background: var(--light); }
        tr:last-child td { border-bottom: none; }

        /* ── BADGE ───────────────────────────────────– */
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-admin {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #0284c7;
        }
        .badge-user {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }

        /* ── EMPTY STATE ─────────────────────────────– */
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: var(--muted);
        }
        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
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
            <div class="alert alert-success">
                <span style="font-size: 20px;">✅</span>
                <span>{{ $message }}</span>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-error">
                <span style="font-size: 20px;">❌</span>
                <span>{{ $message }}</span>
            </div>
        @endif

        <!-- NAVIGATION -->
        <div class="nav-tabs">
            <a href="{{ route('admin.dashboard') }}">📊 Opportunités</a>
            <a href="{{ route('admin.users') }}" class="active">👥 Utilisateurs</a>
        </div>

        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">Gestion des Utilisateurs</h1>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ count($users) }}</div>
                <div class="stat-label">Utilisateurs totaux</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: linear-gradient(135deg, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ count($users->where('is_admin', true)) }}</div>
                <div class="stat-label">Administrateurs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: linear-gradient(135deg, #10b981, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ count($users->where('is_admin', false)) }}</div>
                <div class="stat-label">Utilisateurs normaux</div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>👤 Utilisateur</th>
                        <th>📧 Email</th>
                        <th>Rôle</th>
                        <th>📅 Inscrit le</th>
                        <th>🔗 Dernière connexion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--green), #00d084); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong style="font-size: 15px;">{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td style="font-family: 'Monaco', 'Courier New', monospace; font-size: 13px; color: var(--muted);">{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->is_admin ? 'badge-admin' : 'badge-user' }}">
                                    {{ $user->is_admin ? '👑 Admin' : '👤 Utilisateur' }}
                                </span>
                            </td>
                            <td style="font-weight: 600;">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($user->last_login_at)
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                                        {{ $user->last_login_at->format('d/m/Y à H:i') }}
                                    </span>
                                @else
                                    <span style="color: var(--muted); font-style: italic;">Jamais connecté</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon">👥</div>
                                    <p style="font-weight: 600;">Aucun utilisateur inscrit</p>
                                </div>
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
