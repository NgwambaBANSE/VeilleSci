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

        main { max-width: 860px; margin: 36px auto 60px; padding: 0 24px; }

        /* En-tête page */
        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-family: 'Merriweather', serif; font-size: 24px; color: var(--navy); margin-bottom: 4px; }
        .page-header p { font-size: 14px; color: var(--muted); }

        /* Sections */
        .section { background: #fff; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 20px; overflow: hidden; }
        .section-head { padding: 16px 24px; border-bottom: 1px solid var(--border); background: var(--light); display: flex; align-items: center; gap: 10px; }
        .section-head h2 { font-size: 15px; font-weight: 700; color: var(--navy); }
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

        /* Upload */
        .upload-zone {
            border: 2px dashed var(--border); border-radius: 10px;
            padding: 24px; text-align: center; cursor: pointer;
            transition: border-color .2s, background .2s;
        }
        .upload-zone:hover { border-color: var(--green); background: rgba(0,154,68,0.03); }
        .upload-icon { font-size: 32px; margin-bottom: 8px; }
        .upload-label { font-size: 14px; font-weight: 600; color: var(--navy); margin-bottom: 4px; }
        .upload-hint { font-size: 12px; color: var(--muted); }
        .upload-zone input[type="file"] { display: none; }
        .current-file { display: flex; align-items: center; gap: 8px; background: var(--light); border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; margin-top: 10px; font-size: 13px; color: var(--navy); }

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
</nav>

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
                <label for="photo_input" class="upload-zone">
                    <div class="upload-icon">📷</div>
                    <div class="upload-label">Cliquez pour choisir une photo</div>
                    <div class="upload-hint">JPG, PNG · Max 2 Mo</div>
                    <input type="file" id="photo_input" name="photo" accept="image/*"
                           onchange="document.getElementById('photo_name').textContent = this.files[0]?.name || ''"/>
                </label>
                @if($profile->photo)
                    <div class="current-file">📎 Photo actuelle : {{ basename($profile->photo) }}</div>
                @endif
                <div id="photo_name" style="margin-top:8px; font-size:13px; color:var(--green);"></div>
            </div>
        </div>

        {{-- ── CV ── --}}
        <div class="section">
            <div class="section-head"><span>📎</span><h2>Curriculum Vitae (CV)</h2></div>
            <div class="section-body">
                <label for="cv_input" class="upload-zone">
                    <div class="upload-icon">📄</div>
                    <div class="upload-label">Cliquez pour téléverser votre CV</div>
                    <div class="upload-hint">PDF uniquement · Max 5 Mo</div>
                    <input type="file" id="cv_input" name="cv" accept=".pdf"
                           onchange="document.getElementById('cv_name').textContent = this.files[0]?.name || ''"/>
                </label>
                @if($profile->cv)
                    <div class="current-file">📎 CV actuel : {{ basename($profile->cv) }}</div>
                @endif
                <div id="cv_name" style="margin-top:8px; font-size:13px; color:var(--green);"></div>
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
</script>

</body>
</html>