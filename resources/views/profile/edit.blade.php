<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Modifier le profil — VeilleSci Burkina</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --navy: #1a3a5c; --navy2: #0f2540; --green: #009A44; --green2: #007a35; --border: #dde3ed; --light: #f8f9fb; --muted: #64748b; --red: #ef4444; }
        body { font-family: 'Inter', sans-serif; background: var(--light); min-height: 100vh; }

        .topbar { background: var(--navy2); padding: 7px 32px; font-size: 12px; color: rgba(255,255,255,0.55); text-align: center; }
        nav { background: #fff; border-bottom: 1px solid var(--border); padding: 0 32px; display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; color: var(--navy); }
        .logo-icon { width: 38px; height: 38px; border-radius: 8px; background: linear-gradient(135deg, var(--navy), var(--green)); display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .logo-title { font-family: 'Merriweather', serif; font-size: 17px; font-weight: 700; }
        .logo-title span { color: var(--green); }
        .logo-sub { font-size: 10px; color: var(--muted); }
        .nav-links { display: flex; gap: 10px; }
        .btn-sm { padding: 7px 16px; border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s; cursor: pointer; font-family: inherit; }
        .btn-outline { border: 1.5px solid var(--border); color: var(--navy); background: transparent; }
        .btn-outline:hover { border-color: var(--navy); }

        .nav-toggle { display: none; background: transparent; border: none; cursor: pointer; width: 42px; height: 42px; align-items: center; justify-content: center; }
        .nav-toggle span { display: block; width: 22px; height: 2px; background: var(--navy); border-radius: 999px; position: relative; transition: transform .2s ease, opacity .2s ease; }
        .nav-toggle span::before,
        .nav-toggle span::after { content: ''; display: block; width: 22px; height: 2px; background: var(--navy); border-radius: 999px; position: absolute; left: 0; transition: transform .2s ease, opacity .2s ease; }
        .nav-toggle span::before { top: -7px; }
        .nav-toggle span::after { top: 7px; }
        .nav-toggle.active span { transform: rotate(45deg); }
        .nav-toggle.active span::before { transform: rotate(90deg); top: 0; }
        .nav-toggle.active span::after { opacity: 0; }
        .mobile-menu { display: none; flex-direction: column; gap: 10px; padding: 16px 24px; background: #fff; border-bottom: 1px solid var(--border); }
        .mobile-menu a, .mobile-menu button { width: 100%; text-align: left; }
        @media (max-width: 760px) {
            nav { padding: 0 18px; min-height: auto; height: auto; flex-wrap: wrap; gap: 12px; }
            .nav-links { display: none; width: 100%; justify-content: stretch; flex-wrap: wrap; gap: 10px; }
            .nav-toggle { display: inline-flex; }
        }
        @media (max-width: 520px) {
            .topbar { padding: 7px 16px; font-size: 11px; }
            .logo-title { font-size: 15px; }
            .btn-sm { width: 100%; }
        }

        main { max-width: 860px; margin: 36px auto 60px; padding: 0 24px; }

        /* En-tête page */
        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-family: 'Merriweather', serif; font-size: 24px; color: var(--navy); margin-bottom: 4px; }
        .page-header p { font-size: 14px; color: var(--muted); }

        /* Sections */
        .section { background: #fff; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 20px; overflow: hidden; }
        .section-head { padding: 16px 24px; border-bottom: 1px solid var(--border); background: var(--light); display: flex; align-items: center; gap: 12px; }
        .section-head span { display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 12px; background: #f0fdf4; color: var(--green); font-size: 18px; }
        .section-head h2 { font-size: 16px; font-weight: 700; color: var(--navy); }
        .section-head small { color: var(--muted); }
        .section-body { padding: 24px; }

        /* Grilles de champs */
        .field-grid { display: grid; gap: 16px; }
        .field-grid.cols-2 { grid-template-columns: 1fr 1fr; }
        .field-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 13px; font-weight: 600; color: var(--navy); }
        .field small { font-size: 11px; color: var(--muted); }

        input[type="text"], input[type="email"], input[type="tel"],
        input[type="url"], select, textarea {
            width: 100%; padding: 10px 13px;
            border: 1.5px solid var(--border); border-radius: 8px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: #1e293b; background: var(--light);
            transition: border-color .2s, box-shadow .2s; outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--green); box-shadow: 0 0 0 3px rgba(0,154,68,0.1); background: #fff;
        }
        textarea { resize: vertical; min-height: 100px; }
        select { cursor: pointer; }

        /* Upload zones - Photo & CV */
        .upload-zone {
            border: 2px dashed var(--border); border-radius: 12px;
            padding: 32px 24px; text-align: center; cursor: pointer;
            transition: all .3s ease; position: relative;
            background: linear-gradient(135deg, rgba(0,154,68,0.02) 0%, rgba(0,154,68,0.01) 100%);
        }
        .upload-zone:hover {
            border-color: var(--green); border-width: 2px;
            background: linear-gradient(135deg, rgba(0,154,68,0.08) 0%, rgba(0,154,68,0.04) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,154,68,0.1);
        }
        .upload-zone.drag-over {
            border-color: var(--green); background: rgba(0,154,68,0.12);
            transform: scale(1.01);
        }
        .upload-icon { font-size: 48px; margin-bottom: 12px; display: block; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-8px); } }
        .upload-label { font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 6px; }
        .upload-hint { font-size: 13px; color: var(--muted); }
        .upload-zone input[type="file"] { display: none; }
        
        /* Current file display */
        .current-file { display: flex; align-items: center; gap: 12px; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1.5px solid #86efac; border-radius: 10px; padding: 14px 16px; margin-top: 16px; font-size: 13px; color: var(--navy); position: relative; }
        .current-file::before { content: '✓'; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; background: var(--green); color: white; border-radius: 50%; font-size: 12px; font-weight: bold; }
        .current-file .file-name { flex: 1; }
        .current-file .file-size { font-size: 12px; color: var(--muted); }
        
        /* Photo preview */
        .photo-preview-container { margin-top: 20px; display: grid; gap: 16px; }
        .photo-preview { position: relative; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .photo-preview.has-preview { border: 3px solid var(--green); }
        .photo-preview img {
            width: 100%; height: 280px; object-fit: cover; display: block;
        }
        .photo-preview-remove {
            position: absolute; top: 10px; right: 10px;
            background: rgba(239,68,68,0.9); color: white;
            border: none; border-radius: 50%; width: 36px; height: 36px;
            cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center;
            transition: all .2s; z-index: 10;
        }
        .photo-preview-remove:hover { background: var(--red); transform: scale(1.1); }
        .photo-preview-name { padding: 12px; background: var(--light); border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); }
        
        /* CV preview */
        .cv-preview-container { margin-top: 20px; }
        .cv-preview {
            display: flex; align-items: center; gap: 14px;
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            border: 2px solid #e9d5ff; border-radius: 14px;
            padding: 18px 20px; position: relative;
            box-shadow: 0 10px 20px rgba(99,102,241,0.06);
        }
        .cv-icon { font-size: 34px; min-width: 46px; display: flex; align-items: center; justify-content: center; }
        .cv-info { flex: 1; min-width: 0; }
        .cv-name { font-weight: 700; color: var(--navy); font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cv-meta { font-size: 13px; color: var(--muted); margin-top: 4px; }
        .cv-remove {
            background: transparent; border: 1.5px solid var(--red);
            color: var(--red); border-radius: 8px; padding: 8px 14px;
            cursor: pointer; font-size: 13px; font-weight: 700; transition: all .2s; font-family: inherit;
        }
        .cv-remove:hover { background: var(--red); color: white; }
        
        .file-input-wrapper { position: relative; }

        /* Erreurs */
        .error-msg { font-size: 12px; color: var(--red); }

        /* Publications */
        .pub-entry { border: 1px solid var(--border); border-radius: 10px; padding: 16px; margin-bottom: 12px; position: relative; }
        .pub-remove { position: absolute; top: 12px; right: 12px; background: #fff0f0; border: 1px solid #fecaca; color: var(--red); border-radius: 6px; padding: 3px 10px; font-size: 12px; cursor: pointer; font-family: inherit; }
        .btn-add-pub { display: inline-flex; align-items: center; gap: 6px; background: var(--light); border: 1.5px dashed var(--border); color: var(--navy); border-radius: 8px; padding: 10px 18px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; font-family: inherit; margin-top: 4px; }
        .btn-add-pub:hover { border-color: var(--green); color: var(--green); }

        /* Boutons de soumission */
        .form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; }
        .btn-submit { padding: 12px 28px; background: var(--green); color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: inherit; transition: background .2s; }
        .btn-submit:hover { background: var(--green2); }
        .btn-cancel { padding: 12px 28px; border: 1.5px solid var(--border); background: #fff; color: var(--muted); border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none; transition: all .2s; }
        .btn-cancel:hover { border-color: var(--navy); color: var(--navy); }

        /* Alerte erreurs */
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); border-radius: 8px; padding: 12px 16px; font-size: 13px; margin-bottom: 20px; }

        @media (max-width: 640px) {
            .field-grid.cols-2, .field-grid.cols-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="topbar">🇧🇫 Portail National de Veille Scientifique — Burkina Faso</div>

<nav>
    <a href="/" class="logo">
        <div class="logo-icon">🔬</div>
        <div>
            <div class="logo-title">VeilleSci <span>BF</span></div>
            <div class="logo-sub">Portail de Veille Scientifique</div>
        </div>
    </a>
    <div class="nav-links">
        <a href="{{ route('profile.show') }}" class="btn-sm btn-outline">← Mon profil</a>
    </div>
    <button class="nav-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
        <span aria-hidden="true"></span>
    </button>
</nav>
<div class="mobile-menu" aria-hidden="true">
    <a href="{{ route('profile.show') }}" class="btn-sm btn-outline">← Mon profil</a>
</div>

<main>

    <div class="page-header">
        <h1>✏️ Modifier mon profil</h1>
        <p>Complétez votre profil pour mieux vous faire connaître de la communauté scientifique.</p>
    </div>

    @if($errors->any())
        <div class="alert-error">
            ❌ Veuillez corriger les erreurs suivantes :
            <ul style="margin-top:8px; padding-left:16px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ── Identité ── --}}
        <div class="section">
            <div class="section-head">
                <span>👤</span>
                <h2>Identité</h2>
            </div>
            <div class="section-body">
                <div class="field-grid cols-3" style="margin-bottom:16px;">
                    <div class="field">
                        <label for="titre">Titre</label>
                        <select id="titre" name="titre">
                            <option value="">—</option>
                            @foreach(['M.','Mme','Dr.','Pr.','Dr Pr.'] as $t)
                                <option value="{{ $t }}" {{ old('titre', $profile->titre) === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field" style="grid-column: span 2;">
                        <label for="name">Nom complet *</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required/>
                        @error('name')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="field-grid cols-2">
                    <div class="field">
                        <label>Email</label>
                        <input type="email" value="{{ $user->email }}" disabled style="opacity:.6; cursor:not-allowed;"/>
                    </div>
                    <div class="field">
                        <label for="telephone">Téléphone</label>
                        <input id="telephone" type="tel" name="telephone" value="{{ old('telephone', $profile->telephone) }}" placeholder="+226 XX XX XX XX"/>
                    </div>
                    <div class="field">
                        <label for="ville">Ville</label>
                        <input id="ville" type="text" name="ville" value="{{ old('ville', $profile->ville) }}" placeholder="Ouagadougou"/>
                    </div>
                    <div class="field">
                        <label for="pays">Pays</label>
                        <input id="pays" type="text" name="pays" value="{{ old('pays', $profile->pays ?? 'Burkina Faso') }}"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Académique ── --}}
        <div class="section">
            <div class="section-head"><span>🎓</span><h2>Informations académiques</h2></div>
            <div class="section-body">
                <div class="field-grid cols-2">
                    <div class="field">
                        <label for="institution">Institution / Université</label>
                        <input id="institution" type="text" name="institution" value="{{ old('institution', $profile->institution) }}" placeholder="Université Joseph Ki-Zerbo"/>
                    </div>
                    <div class="field">
                        <label for="departement">Département / Laboratoire</label>
                        <input id="departement" type="text" name="departement" value="{{ old('departement', $profile->departement) }}" placeholder="Département de Physique"/>
                    </div>
                    <div class="field" style="grid-column: span 2;">
                        <label for="specialite">Spécialité / Domaine de recherche</label>
                        <input id="specialite" type="text" name="specialite" value="{{ old('specialite', $profile->specialite) }}" placeholder="Ex : Épidémiologie, Intelligence Artificielle..."/>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Biographie ── --}}
        <div class="section">
            <div class="section-head"><span>📝</span><h2>Biographie</h2></div>
            <div class="section-body">
                <div class="field">
                    <label for="biographie">Présentez-vous en quelques lignes</label>
                    <textarea id="biographie" name="biographie" rows="5" placeholder="Décrivez votre parcours, vos intérêts de recherche, vos projets en cours...">{{ old('biographie', $profile->biographie) }}</textarea>
                    <small>Maximum 2000 caractères</small>
                </div>
            </div>
        </div>

        {{-- ── Photo ── --}}
        <div class="section">
            <div class="section-head"><span>🖼️</span><h2>Photo de profil</h2></div>
            <div class="section-body">
                <div class="file-input-wrapper">
                    <label for="photo_input" class="upload-zone" id="photo_zone">
                        <div class="upload-icon">📷</div>
                        <div class="upload-label">Glissez votre photo ici</div>
                        <div class="upload-hint">ou cliquez pour sélectionner · JPG, PNG · Max 2 Mo</div>
                        <input type="file" id="photo_input" name="photo" accept="image/*"/>
                    </label>
                </div>
                
                <div id="photo_preview_wrapper" class="photo-preview-container" style="display: none;">
                    <div class="photo-preview has-preview">
                        <img id="photo_preview" src="" alt="Aperçu de la photo"/>
                        <button type="button" class="photo-preview-remove" onclick="clearPhoto(event)">✕</button>
                        <div class="photo-preview-name" id="photo_file_name"></div>
                    </div>
                </div>
                
                @if($profile->photo)
                    <div class="photo-preview-container">
                        <div class="photo-preview has-preview">
                            <img src="{{ asset('storage/' . $profile->photo) }}" alt="Photo actuelle"/>
                            <button type="button" class="photo-preview-remove" onclick="removeCurrentPhoto(event)">✕</button>
                            <div class="photo-preview-name">{{ basename($profile->photo) }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── CV ── --}}
        <div class="section">
            <div class="section-head"><span>📎</span><h2>Curriculum Vitae (CV)</h2></div>
            <div class="section-body">
                <div class="file-input-wrapper">
                    <label for="cv_input" class="upload-zone" id="cv_zone">
                        <div class="upload-icon">📄</div>
                        <div class="upload-label">Déposez votre CV ici</div>
                        <div class="upload-hint">ou cliquez pour sélectionner · PDF uniquement · Max 5 Mo</div>
                        <input type="file" id="cv_input" name="cv" accept=".pdf"/>
                    </label>
                </div>
                
                <div id="cv_preview_wrapper" style="display: none; margin-top: 20px;">
                    <div class="cv-preview">
                        <div class="cv-icon">📑</div>
                        <div class="cv-info">
                            <div class="cv-name" id="cv_file_name"></div>
                            <div class="cv-meta" id="cv_file_size"></div>
                        </div>
                        <button type="button" class="cv-remove" onclick="clearCV(event)">Supprimer</button>
                    </div>
                </div>
                
                @if($profile->cv)
                    <div style="margin-top: 20px;">
                        <div class="cv-preview">
                            <div class="cv-icon">📑</div>
                            <div class="cv-info">
                                <div class="cv-name">{{ basename($profile->cv) }}</div>
                                <div class="cv-meta">CV actuel · <a href="{{ asset('storage/' . $profile->cv) }}" target="_blank" style="color: var(--green); text-decoration: none; font-weight: 600;">Télécharger</a></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Publications ── --}}
        <div class="section">
            <div class="section-head"><span>📄</span><h2>Publications scientifiques</h2></div>
            <div class="section-body">
                <div id="publications-list">
                    @forelse($profile->publications ?? [] as $i => $pub)
                        <div class="pub-entry" id="pub-{{ $i }}">
                            <button type="button" class="pub-remove" onclick="removePub(this.parentElement)">✕ Supprimer</button>
                            <div class="field-grid cols-2" style="margin-bottom:10px;">
                                <div class="field" style="grid-column:span 2;">
                                    <label>Titre de la publication *</label>
                                    <input type="text" name="pub_titres[]" value="{{ $pub['titre'] }}" placeholder="Titre de l'article ou ouvrage" required/>
                                </div>
                                <div class="field">
                                    <label>Revue / Éditeur</label>
                                    <input type="text" name="pub_revues[]" value="{{ $pub['revue'] ?? '' }}" placeholder="Nom de la revue"/>
                                </div>
                                <div class="field">
                                    <label>Année</label>
                                    <input type="text" name="pub_annees[]" value="{{ $pub['annee'] ?? '' }}" placeholder="2024"/>
                                </div>
                                <div class="field">
                                    <label>Type</label>
                                    <select name="pub_types[]">
                                        @foreach(['Article','Chapitre','Thèse','Communication','Rapport','Livre'] as $type)
                                            <option value="{{ $type }}" {{ ($pub['type'] ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Lien DOI / URL</label>
                                    <input type="text" name="pub_liens[]" value="{{ $pub['lien'] ?? '' }}" placeholder="https://doi.org/..."/>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Entrée vide par défaut --}}
                    @endforelse
                </div>
                <button type="button" class="btn-add-pub" onclick="addPub()">+ Ajouter une publication</button>
            </div>
        </div>

        {{-- ── Liens académiques ── --}}
        <div class="section">
            <div class="section-head"><span>🔗</span><h2>Liens & réseaux académiques</h2></div>
            <div class="section-body">
                <div class="field-grid cols-2">
                    <div class="field">
                        <label for="orcid">ORCID</label>
                        <input id="orcid" type="url" name="orcid" value="{{ old('orcid', $profile->orcid) }}" placeholder="https://orcid.org/0000-..."/>
                    </div>
                    <div class="field">
                        <label for="researchgate">ResearchGate</label>
                        <input id="researchgate" type="url" name="researchgate" value="{{ old('researchgate', $profile->researchgate) }}" placeholder="https://researchgate.net/profile/..."/>
                    </div>
                    <div class="field">
                        <label for="linkedin">LinkedIn</label>
                        <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin', $profile->linkedin) }}" placeholder="https://linkedin.com/in/..."/>
                    </div>
                    <div class="field">
                        <label for="site_web">Site web personnel</label>
                        <input id="site_web" type="url" name="site_web" value="{{ old('site_web', $profile->site_web) }}" placeholder="https://monsite.com"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <a href="{{ route('profile.show') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">💾 Enregistrer le profil</button>
        </div>

    </form>
</main>

<script>
// ────────── Gestion Photo ──────────
const photoInput = document.getElementById('photo_input');
const photoZone = document.getElementById('photo_zone');
const photoPreviewWrapper = document.getElementById('photo_preview_wrapper');
const photoPreview = document.getElementById('photo_preview');
const photoFileName = document.getElementById('photo_file_name');

// Afficher aperçu au changement
photoInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = (event) => {
            photoPreview.src = event.target.result;
            photoFileName.textContent = this.files[0].name + ' (' + (this.files[0].size / 1024 / 1024).toFixed(2) + ' Mo)';
            photoPreviewWrapper.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    }
});

// Drag-and-drop pour photo
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    photoZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    photoZone.addEventListener(eventName, () => photoZone.classList.add('drag-over'), false);
});

['dragleave', 'drop'].forEach(eventName => {
    photoZone.addEventListener(eventName, () => photoZone.classList.remove('drag-over'), false);
});

photoZone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    photoInput.files = files;
    const event = new Event('change', { bubbles: true });
    photoInput.dispatchEvent(event);
}, false);

function clearPhoto(e) {
    e.preventDefault();
    photoInput.value = '';
    photoPreviewWrapper.style.display = 'none';
}

function removeCurrentPhoto(e) {
    e.preventDefault();
    if (confirm('Êtes-vous sûr de vouloir supprimer la photo actuelle ?')) {
        document.querySelector('input[name="photo_remove"]')?.remove();
        const removeField = document.createElement('input');
        removeField.type = 'hidden';
        removeField.name = 'photo_remove';
        removeField.value = '1';
        document.querySelector('form').appendChild(removeField);
        e.target.closest('.photo-preview').parentElement.remove();
    }
}

// ────────── Gestion CV ──────────
const cvInput = document.getElementById('cv_input');
const cvZone = document.getElementById('cv_zone');
const cvPreviewWrapper = document.getElementById('cv_preview_wrapper');
const cvFileName = document.getElementById('cv_file_name');
const cvFileSize = document.getElementById('cv_file_size');

// Afficher aperçu au changement
cvInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        cvFileName.textContent = file.name;
        cvFileSize.textContent = 'Fichier PDF · ' + (file.size / 1024 / 1024).toFixed(2) + ' Mo';
        cvPreviewWrapper.style.display = 'block';
    }
});

// Drag-and-drop pour CV
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    cvZone.addEventListener(eventName, preventDefaults, false);
});

['dragenter', 'dragover'].forEach(eventName => {
    cvZone.addEventListener(eventName, () => cvZone.classList.add('drag-over'), false);
});

['dragleave', 'drop'].forEach(eventName => {
    cvZone.addEventListener(eventName, () => cvZone.classList.remove('drag-over'), false);
});

cvZone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    cvInput.files = files;
    const event = new Event('change', { bubbles: true });
    cvInput.dispatchEvent(event);
}, false);

function clearCV(e) {
    e.preventDefault();
    cvInput.value = '';
    cvPreviewWrapper.style.display = 'none';
}

// ────────── Publications ──────────
let pubCount = {{ count($profile->publications ?? []) }};

function addPub() {
    const i = pubCount++;
    const types = ['Article','Chapitre','Thèse','Communication','Rapport','Livre'];
    const options = types.map(t => `<option value="${t}">${t}</option>`).join('');
    document.getElementById('publications-list').insertAdjacentHTML('beforeend', `
        <div class="pub-entry" id="pub-${i}">
            <button type="button" class="pub-remove" onclick="removePub(this.parentElement)">✕ Supprimer</button>
            <div class="field-grid cols-2" style="margin-bottom:10px;">
                <div class="field" style="grid-column:span 2;">
                    <label>Titre de la publication *</label>
                    <input type="text" name="pub_titres[]" placeholder="Titre de l'article ou ouvrage" required/>
                </div>
                <div class="field">
                    <label>Revue / Éditeur</label>
                    <input type="text" name="pub_revues[]" placeholder="Nom de la revue"/>
                </div>
                <div class="field">
                    <label>Année</label>
                    <input type="text" name="pub_annees[]" placeholder="2024"/>
                </div>
                <div class="field">
                    <label>Type</label>
                    <select name="pub_types[]">${options}</select>
                </div>
                <div class="field">
                    <label>Lien DOI / URL</label>
                    <input type="text" name="pub_liens[]" placeholder="https://doi.org/..."/>
                </div>
            </div>
        </div>
    `);
}

function removePub(el) { el.remove(); }

(function () {
    const toggle = document.querySelector('.nav-toggle');
    const menu = document.querySelector('.mobile-menu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
        const isOpen = menu.style.display === 'flex';
        menu.style.display = isOpen ? 'none' : 'flex';
        toggle.classList.toggle('active', !isOpen);
        toggle.setAttribute('aria-expanded', String(!isOpen));
        menu.setAttribute('aria-hidden', String(isOpen));
    });
})();
</script>

</body>
</html>