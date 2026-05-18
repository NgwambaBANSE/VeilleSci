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
    <title>Admin - VeilleSci Burkina</title>
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

        /* ── MESSAGES ────────────────────────────────── */
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

        /* ── NAVIGATION ──────────────────────────────── */
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

        /* ── HEADER ──────────────────────────────────── */
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

        /* ── STATS GRID ──────────────────────────────── */
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

        /* ── BUTTON ──────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green), #00d084);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,154,68,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,154,68,0.4);
        }

        /* ── CATEGORY SECTION ────────────────────────── */
        .category-section {
            margin-bottom: 40px;
        }
        .category-header {
            background: linear-gradient(135deg, var(--light), #f0f9ff);
            padding: 20px 28px;
            border-radius: 12px 12px 0 0;
            border-left: 4px solid var(--green);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .category-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
        }
        .category-count {
            background: var(--green);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        /* ── TABLE ───────────────────────────────────– */
        .table-container {
            background: #fff;
            border-radius: 0 0 12px 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            border: 1px solid var(--border);
            border-top: none;
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
        .badge-green {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }
        .badge-red {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        /* ── ACTIONS ─────────────────────────────────– */
        .actions {
            display: flex;
            gap: 8px;
        }
        .actions button, .actions a {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-edit {
            background: #dbeafe;
            color: #0284c7;
        }
        .btn-edit:hover {
            background: #bfdbfe;
            transform: translateY(-1px);
        }
        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }
        .btn-delete:hover {
            background: #fecaca;
            transform: translateY(-1px);
        }
        .btn-toggle {
            background: #f3e8ff;
            color: #7c3aed;
        }
        .btn-toggle:hover {
            background: #e9d5ff;
            transform: translateY(-1px);
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
            <a href="{{ route('admin.dashboard') }}" class="active">📊 Opportunités</a>
            <a href="{{ route('admin.users') }}">👥 Utilisateurs</a>
            <a href="{{ route('admin.admins.index') }}">🔐 Administrateurs</a>
        </div>

        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">Gestion des Opportunités</h1>
            <a href="{{ route('admin.create') }}" class="btn btn-primary">➕ Ajouter une opportunité</a>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Opportunités</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: linear-gradient(135deg, #10b981, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $stats['actives'] }}</div>
                <div class="stat-label">Actives</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: linear-gradient(135deg, #6b7280, #9ca3af); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $stats['inactives'] }}</div>
                <div class="stat-label">Inactives</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="background: linear-gradient(135deg, #ef4444, #f87171); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $stats['urgentes'] }}</div>
                <div class="stat-label">Urgentes (14j)</div>
            </div>
        </div>

        <!-- CATEGORIES -->
        @foreach ($opportunites as $categorie => $opps)
            @if ($opps->count() > 0)
                <div class="category-section">
                    <div class="category-header">
                        <span class="category-title">
                            @if($categorie === 'Publications') 📄
                            @elseif($categorie === 'Conférences') 🎤
                            @elseif($categorie === 'Formations') 📚
                            @elseif($categorie === 'Stages') 🏢
                            @elseif($categorie === 'Bourses') 🎓
                            @endif
                            {{ $categorie }}
                        </span>
                        <span class="category-count">{{ $opps->count() }}</span>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Domaine</th>
                                    <th>Pays</th>
                                    <th>Date limite</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opps as $opp)
                                    <tr>
                                        <td><strong>{{ substr($opp->titre, 0, 40) }}...</strong></td>
                                        <td>{{ $opp->domaine }}</td>
                                        <td>{{ $opp->pays }}</td>
                                        <td><span style="font-weight: 600;">{{ $opp->date_limite->format('d/m/Y') }}</span></td>
                                        <td>
                                            <span class="badge {{ $opp->active ? 'badge-green' : 'badge-red' }}">
                                                {{ $opp->active ? '✅ Active' : '❌ Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="{{ route('admin.edit', $opp) }}" class="btn-edit" title="Éditer">✏️</a>

                                                <form method="POST" action="{{ route('admin.toggle', $opp) }}" style="display: inline;" onsubmit="return confirm('{{ $opp->active ? 'Désactiver' : 'Activer' }} cette opportunité ?')">
                                                    @csrf
                                                    <button type="submit" class="btn-toggle" title="{{ $opp->active ? 'Désactiver' : 'Activer' }}">
                                                        {{ $opp->active ? '🔴' : '🟢' }}
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.destroy', $opp) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete" title="Supprimer">🗑️</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>
@endif
