<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Créer une opportunité - VeilleSci Admin</title>
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
        .navbar-right a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            margin-right: 20px;
        }
        
        .container { max-width: 800px; margin: 0 auto; padding: 32px; }
        
        .form-card {
            background: #fff;
            border-radius: 8px;
            padding: 32px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        }
        
        h1 { font-size: 24px; margin-bottom: 28px; color: var(--navy); }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text);
        }
        
        input, textarea, select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(0, 154, 68, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        .error {
            color: var(--red);
            font-size: 12px;
            margin-top: 4px;
        }
        
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
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
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }
        .checkbox-group input { width: auto; }
        .checkbox-group label { margin: 0; }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">🔬 VeilleSci Admin</div>
        <div>
            <a href="{{ route('admin.dashboard') }}">← Retour</a>
        </div>
    </div>

    <div class="container">
        <div class="form-card">
            <h1>➕ Ajouter une opportunité</h1>

            @if ($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 14px; margin-bottom: 20px; color: var(--red); font-size: 14px;">
                    <strong>Erreurs :</strong>
                    <ul style="margin: 8px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.store') }}">
                @csrf

                <!-- Titre -->
                <div class="form-group">
                    <label for="titre">Titre *</label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required>
                    @error('titre')<div class="error">{{ $message }}</div>@enderror
                </div>

                <!-- Catégorie et Domaine -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="categorie">Catégorie *</label>
                        <select id="categorie" name="categorie" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="Publications" {{ old('categorie') === 'Publications' ? 'selected' : '' }}>Publications</option>
                            <option value="Conférences" {{ old('categorie') === 'Conférences' ? 'selected' : '' }}>Conférences</option>
                            <option value="Formations" {{ old('categorie') === 'Formations' ? 'selected' : '' }}>Formations</option>
                            <option value="Stages" {{ old('categorie') === 'Stages' ? 'selected' : '' }}>Stages</option>
                            <option value="Bourses" {{ old('categorie') === 'Bourses' ? 'selected' : '' }}>Bourses</option>
                        </select>
                        @error('categorie')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="domaine">Domaine *</label>
                        <input type="text" id="domaine" name="domaine" value="{{ old('domaine') }}" placeholder="ex: Informatique, Biologie..." required>
                        @error('domaine')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Pays et Date limite -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="pays">Pays *</label>
                        <input type="text" id="pays" name="pays" value="{{ old('pays') }}" placeholder="ex: Burkina Faso" required>
                        @error('pays')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="date_limite">Date limite *</label>
                        <input type="date" id="date_limite" name="date_limite" value="{{ old('date_limite') }}" required>
                        @error('date_limite')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea id="description" name="description" required>{{ old('description') }}</textarea>
                    @error('description')<div class="error">{{ $message }}</div>@enderror
                </div>

                <!-- Lien et Statut -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="lien">Lien (optionnel)</label>
                        <input type="url" id="lien" name="lien" value="{{ old('lien') }}" placeholder="https://exemple.com">
                        @error('lien')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Statut</label>
                        <div class="checkbox-group">
                            <input type="checkbox" id="active" name="active" value="1" {{ old('active') ? 'checked' : '' }}>
                            <label for="active" style="margin: 0;">Actif (visible immédiatement)</label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✅ Créer l'opportunité</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
