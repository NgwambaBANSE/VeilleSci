@props(['domaines', 'search' => '', 'domaine' => ''])

<div class="art-filters">
    <form method="GET" action="{{ route('articles.index') }}">
        <div class="art-field">
            <label>🔍 Recherche</label>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Titre, auteur, mot-clé..." />
        </div>
        <div class="art-field">
            <label>📚 Domaine</label>
            <select name="domaine">
                <option value="">Tous les domaines</option>
                @foreach($domaines as $dom)
                    <option value="{{ $dom }}" {{ $domaine === $dom ? 'selected' : '' }}>
                        {{ ucfirst($dom) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; align-items:flex-end;">
            <button type="submit" class="art-btn art-btn-green" style="padding:9px 20px; font-size:13px;">
                Filtrer
            </button>
        </div>
    </form>
</div>
