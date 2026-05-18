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
            border-radius: 12px 12px 0 0;
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
        .breadcrumb {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            margin-bottom: 12px;
        }
        .breadcrumb a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: color 0.2s;
        }
        .breadcrumb a:hover {
            color: white;
        }
        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
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
        .btn-danger {
            background: linear-gradient(135deg, var(--red), #c41e3a);
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(239,43,45,0.3);
            transition: all 0.3s;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239,43,45,0.4);
        }
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .card-header {
            padding: 28px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--green), #00d084);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 12px rgba(0,154,68,0.2);
            border: 3px solid white;
        }
        .user-info h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 4px 0;
        }
        .user-info p {
            color: var(--green);
            font-weight: 600;
            margin: 0;
            font-size: 14px;
        }
        .card-body {
            padding: 28px;
        }
        .info-section {
            margin-bottom: 32px;
        }
        .info-section:last-child {
            margin-bottom: 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }
        .info-item {
            background: var(--light);
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid var(--green);
        }
        .info-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }
        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #f9fafb 100%);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            text-align: center;
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
            font-size: 36px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--green), #00d084);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 13px;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .warning-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fcd34d;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 16px;
            color: #92400e;
        }
        .warning-box p {
            margin: 0;
            font-size: 14px;
        }
        .warning-box strong {
            display: block;
            margin-bottom: 4px;
            font-size: 15px;
        }
        .divider {
            border-bottom: 1px solid var(--border);
            margin: 24px 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
        }
        .nav-actions {
            display: flex;
            gap: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="breadcrumb">
            <a href="{{ route('admin.admins.index') }}">← Retour à la liste</a>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 16px;">
            <div>
                <h1>👤 Détails de l'Administrateur</h1>
            </div>
            <div class="nav-actions">
                <a href="{{ route('admin.admins.index') }}" class="btn-secondary">
                    📋 Liste
                </a>
                <a href="{{ route('admin.admins.create') }}" class="btn-secondary">
                    ➕ Ajouter
                </a>
            </div>
        </div>
    </div>

    <!-- Profil utilisateur -->
    <div class="card">
        <div class="card-header">
            <div class="user-avatar">
                @if($admin->avatar)
                    <img src="{{ $admin->avatar }}" alt="{{ $admin->name }}" style="width: 100%; height: 100%; border-radius: 12px; object-fit: cover;">
                @else
                    👤
                @endif
            </div>
            <div class="user-info">
                <h2>{{ $admin->name }}</h2>
                <p>🔐 Administrateur</p>
            </div>
        </div>

        <div class="card-body">
            <!-- Informations générales -->
            <div class="info-section">
                <div class="section-title">ℹ️ Informations générales</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $admin->email }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">ID Utilisateur</div>
                        <div class="info-value">#{{ $admin->id }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Inscrit le</div>
                        <div class="info-value">{{ $admin->created_at->format('d/m/Y') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Statut</div>
                        <div class="info-value" style="color: var(--green);">✓ Admin</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Statistiques -->
            <div class="info-section">
                <div class="section-title">📊 Statistiques</div>
                <div class="info-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $admin->favoris()->count() }}</div>
                        <div class="stat-label">Articles favoris</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">{{ $admin->forumTopics()->count() }}</div>
                        <div class="stat-label">Sujets de forum</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">{{ $admin->forumReplies()->count() }}</div>
                        <div class="stat-label">Réponses de forum</div>
                    </div>
                </div>
            </div>

            @if($admin->google_id)
                <div class="divider"></div>
                <div class="info-section">
                    <div class="section-title">🔗 Authentification</div>
                    <div class="info-item">
                        <div class="info-label">Connexion Google</div>
                        <div class="info-value" style="font-size: 14px;">{{ substr($admin->google_id, 0, 10) }}...</div>
                    </div>
                </div>
            @endif

            <div class="divider"></div>

            <!-- Actions -->
            <div class="info-section">
                <div class="section-title">⚙️ Actions</div>
                
                @if($admin->id !== auth()->id())
                    <p style="color: var(--muted); font-size: 14px; margin-bottom: 16px;">
                        Retirer les droits d'administrateur pour cet utilisateur. Cette action est irréversible.
                    </p>
                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir retirer les droits d\'administrateur à {{ $admin->name }} ?');">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="confirm" value="on">
                        <button type="submit" class="btn-danger">
                            🔓 Retirer les droits d'administrateur
                        </button>
                    </form>
                @else
                    <div class="warning-box">
                        <strong>ℹ️ C'est votre compte</strong>
                        <p>Vous ne pouvez pas retirer vos propres droits d'administrateur.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection
