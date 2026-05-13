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
        .btn-danger {
            background: #fee2e2;
            color: var(--red);
        }
        .btn-danger:hover { background: #fecaca; }
        
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
        .badge-red { background: #fee2e2; color: var(--red); }
        .badge-blue { background: #eff6ff; color: #0284c7; }
        
        /* ── ACTIONS ─────────────────────────────────── */
        .actions {
            display: flex;
            gap: 8px;
        }
        .actions a, .actions form {
            display: inline;
        }
        .actions button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            background: var(--border);
            color: var(--text);
            transition: background 0.2s;
        }
        .actions button:hover { background: #cbd5e1; }
        .actions .btn-edit {
            background: #dbeafe;
            color: #0284c7;
        }
        .actions .btn-edit:hover { background: #bfdbfe; }
        .actions .btn-delete {
            background: #fee2e2;
            color: var(--red);
        }
        .actions .btn-delete:hover { background: #fecaca; }
        .actions .btn-toggle {
            background: #f3e8ff;
            color: #7c3aed;
        }
        .actions .btn-toggle:hover { background: #e9d5ff; }
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

        <!-- HEADER -->
        <div class="page-header">
            <h1 class="page-title">📊 Tableau de Bord Admin</h1>
            <a href="{{ route('admin.create') }}" class="btn btn-primary">➕ Ajouter une opportunité</a>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Opportunités totales</div>
            </div>
            <div class="stat-card" style="border-left-color: #10b981;">
                <div class="stat-number" style="color: #10b981;">{{ $stats['actives'] }}</div>
                <div class="stat-label">Actives</div>
            </div>
            <div class="stat-card" style="border-left-color: #6b7280;">
                <div class="stat-number" style="color: #6b7280;">{{ $stats['inactives'] }}</div>
                <div class="stat-label">Inactives</div>
            </div>
            <div class="stat-card" style="border-left-color: var(--red);">
                <div class="stat-number" style="color: var(--red);">{{ $stats['urgentes'] }}</div>
                <div class="stat-label">Urgentes (14 jours)</div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Domaine</th>
                        <th>Pays</th>
                        <th>Date limite</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($opportunites as $opp)
                        <tr>
                            <td><strong>{{ substr($opp->titre, 0, 40) }}...</strong></td>
                            <td>
                                <span class="badge badge-blue">
                                    {{ $opp->categorie }}
                                </span>
                            </td>
                            <td>{{ $opp->domaine }}</td>
                            <td>{{ $opp->pays }}</td>
                            <td>{{ $opp->date_limite->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $opp->active ? 'badge-green' : 'badge-red' }}">
                                    {{ $opp->active ? '✅ Active' : '❌ Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.edit', $opp) }}" class="btn-edit">✏️ Éditer</a>
                                    
                                    <form method="POST" action="{{ route('admin.toggle', $opp) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-toggle">
                                            {{ $opp->active ? '🔴 Désactiver' : '🟢 Activer' }}
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.destroy', $opp) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️ Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--muted); padding: 40px;">
                                Aucune opportunité. <a href="{{ route('admin.create') }}">Créer la première →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
