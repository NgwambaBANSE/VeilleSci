@props(['articles', 'stats' => [], 'domaines' => [], 'resumeIaCount' => 0])

<div>
    {{-- Stats --}}
    <div class="art-sidebar-card">
        <div class="art-sidebar-head">📊 Statistiques</div>
        <div class="art-sidebar-body" style="padding:0 18px;">
            <div class="art-stat-row">
                <span>Total articles</span>
                <span class="art-stat-val">{{ $articles->total() }}</span>
            </div>
            <div class="art-stat-row">
                <span>Avec résumé IA</span>
                <span class="art-stat-val" style="color:var(--green);">
                    {{ $resumeIaCount }}
                </span>
            </div>
            <div class="art-stat-row">
                <span>Domaines</span>
                <span class="art-stat-val">{{ count($domaines) }}</span>
            </div>
        </div>
    </div>

    {{-- Domaines --}}
    <div class="art-sidebar-card">
        <div class="art-sidebar-head">📂 Domaines</div>
        <div class="art-sidebar-body" style="padding:0 18px;">
            @foreach($domaines as $dom)
                <a href="{{ route('articles.index', ['domaine' => $dom]) }}" class="art-domain-item">
                    <span>{{ ucfirst($dom) }}</span>
                    <span class="art-domain-count">
                        {{ $stats[$dom] ?? 0 }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Liens rapides --}}
    <div class="art-sidebar-card">
        <div class="art-sidebar-head">🔗 Navigation rapide</div>
        <div class="art-sidebar-body" style="padding:0 18px;">
            <a href="/app"   class="art-domain-item">📋 Opportunités</a>
            <a href="/forum" class="art-domain-item">💬 Forum</a>
            @auth
                <a href="{{ route('profile.show') }}" class="art-domain-item">👤 Mon profil</a>
            @else
                <a href="{{ route('register') }}" class="art-domain-item">🚀 Créer un compte</a>
            @endauth
        </div>
    </div>

    {{-- Conseil --}}
    <div class="art-sidebar-card" style="overflow:visible;">
        <div class="art-sidebar-head">💡 Le saviez-vous ?</div>
        <div class="art-sidebar-body" style="font-size:13px; color:var(--muted); line-height:1.7;">
            Les résumés <strong style="color:var(--green);">🤖 IA</strong> sont générés automatiquement par Claude pour vous faire gagner du temps dans votre veille scientifique.
        </div>
    </div>
</div>
