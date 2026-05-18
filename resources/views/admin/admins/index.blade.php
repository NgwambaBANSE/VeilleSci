@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
            background: var(--bg);
            color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .page-header {
            background: linear-gradient(135deg, var(--navy2) 0%, var(--navy) 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .page-header p {
            color: rgba(255,255,255,0.8);
            font-size: 15px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green), #00d084);
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,154,68,0.3);
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,154,68,0.4);
        }
        .alert {
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
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
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            margin-bottom: 40px;
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
        .badge {
            display: inline-block;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #0284c7;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-info {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #0284c7;
        }
        .actions {
            display: flex;
            gap: 12px;
        }
        .btn-link {
            color: #0284c7;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }
        .btn-link:hover {
            color: #0369a1;
        }
        .btn-danger {
            color: #dc2626;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }
        .btn-danger:hover {
            color: #b91c1c;
        }
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
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: var(--muted);
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        .page-link {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            text-decoration: none;
            color: var(--text);
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .page-link:hover {
            background: var(--light);
        }
        .page-link.active {
            background: var(--green);
            color: white;
            border-color: var(--green);
        }
    </style>
</head>
<body>
<div class="container">
    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div class="page-header" style="flex: 1; margin-right: 20px;">
            <h1>🔐 Administrateurs</h1>
            <p>Gérez les accès administrateur de votre application</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="btn-primary">
            ➕ Ajouter
        </a>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert alert-success">
            <span style="font-size: 18px;">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <span style="font-size: 18px;">❌</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Liste des administrateurs -->
    @if($admins->count() > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Administrateur</th>
                        <th>Email</th>
                        <th>Inscrit le</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 16px;">👤</span>
                                    <span style="font-weight: 500;">{{ $admin->name }}</span>
                                    @if($admin->id === auth()->id())
                                        <span class="badge badge-info" style="margin-left: 8px;">C'est vous</span>
                                    @endif
                                </div>
                            </td>
                            <td style="color: var(--muted);">{{ $admin->email }}</td>
                            <td style="color: var(--muted); font-size: 13px;">
                                {{ $admin->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="text-align: center;">
                                <div class="actions">
                                    <a href="{{ route('admin.admins.show', $admin) }}" class="btn-link">
                                        Voir
                                    </a>
                                    
                                    @if($admin->id !== auth()->id())
                                        <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir retirer les droits d\'administrateur à {{ $admin->name }} ?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="confirm" value="on">
                                            <button type="submit" class="btn-danger">
                                                Retirer
                                            </button>
                                        </form>
                                    @else
                                        <span style="color: var(--muted); font-size: 13px;">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($admins->lastPage() > 1)
            <div class="pagination">
                @if($admins->onFirstPage())
                    <span class="page-link" style="opacity: 0.5;">← Précédent</span>
                @else
                    <a href="{{ $admins->previousPageUrl() }}" class="page-link">← Précédent</a>
                @endif

                @foreach($admins->getUrlRange(1, $admins->lastPage()) as $page => $url)
                    @if($page == $admins->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if($admins->hasMorePages())
                    <a href="{{ $admins->nextPageUrl() }}" class="page-link">Suivant →</a>
                @else
                    <span class="page-link" style="opacity: 0.5;">Suivant →</span>
                @endif
            </div>
        @endif
    @else
        <div class="empty-state">
            <p style="font-size: 16px; margin-bottom: 16px;">📋 Aucun administrateur trouvé</p>
            <a href="{{ route('admin.admins.create') }}" class="btn-primary">
                Ajouter le premier administrateur
            </a>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $admins->total() }}</div>
            <div class="stat-label">Administrateurs</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Utilisateurs totaux</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\User::where('is_admin', false)->count() }}</div>
            <div class="stat-label">Utilisateurs normaux</div>
        </div>
    </div>
</div>
</body>
</html>
@endsection
