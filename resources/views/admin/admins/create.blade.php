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
        .btn-secondary {
            background: #f3f4f6;
            color: var(--text);
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background: var(--light);
        }
        .alert {
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
        }
        .alert-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }
        .alert-error ul {
            margin-top: 8px;
            margin-left: 16px;
        }
        .alert-error li {
            margin-bottom: 4px;
        }
        .form-card {
            background: white;
            border-radius: 12px;
            padding: 36px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 24px;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(0,154,68,0.1);
        }
        .form-control:disabled {
            background: var(--light);
            color: var(--muted);
        }
        .info-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            border-left: 4px solid #0284c7;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .info-box h3 {
            color: #0c4a6e;
            font-weight: 600;
            margin: 0 0 8px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .info-box li {
            color: #075985;
            font-size: 13px;
            padding: 4px 0;
            padding-left: 20px;
            position: relative;
        }
        .info-box li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #0284c7;
            font-weight: bold;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
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
        .form-actions {
            display: flex;
            gap: 12px;
            padding-top: 12px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        .no-users {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fcd34d;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            color: #92400e;
        }
        .no-users p {
            margin: 0;
            font-size: 14px;
        }
        .no-users strong {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
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
        <h1>➕ Ajouter un Administrateur</h1>
        <p>Sélectionnez un utilisateur à promouvoir en administrateur</p>
    </div>

    <!-- Messages d'erreur -->
    @if($errors->any())
        <div class="alert alert-error">
            <span style="font-size: 18px; margin-top: 2px;">❌</span>
            <div>
                <strong>Erreur lors de l'enregistrement</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Formulaire -->
    <div class="form-card">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="user_id" class="form-label">Sélectionner un utilisateur</label>
                
                @if($users->count() > 0)
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Choisir un utilisateur --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                @else
                    <div class="no-users">
                        <strong>⚠️ Aucun utilisateur disponible</strong>
                        <p>Tous les utilisateurs sont déjà administrateurs!</p>
                    </div>
                @endif

                @error('user_id')
                    <p style="color: var(--red); font-size: 13px; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info box -->
            <div class="info-box">
                <h3>ℹ️ Avant de continuer</h3>
                <ul>
                    <li>L'utilisateur aura accès à l'ensemble du panneau d'administration</li>
                    <li>Il pourra modifier les opportunités et ajouter d'autres administrateurs</li>
                    <li>Cette action est enregistrée dans les logs</li>
                    <li>Vous pouvez retirer les droits d'administrateur à tout moment</li>
                </ul>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <button type="submit" class="btn-primary" @if($users->count() == 0) disabled @endif>
                    ✓ Promouvoir en administrateur
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ \App\Models\User::where('is_admin', true)->count() }}</div>
            <div class="stat-label">Administrateurs</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">{{ $users->count() }}</div>
            <div class="stat-label">Utilisateurs disponibles</div>
        </div>
    </div>
</div>
</body>
</html>
@endsection
