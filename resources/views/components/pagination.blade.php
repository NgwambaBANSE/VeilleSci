@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="art-pagination">
        <div class="flex gap-2 items-center justify-between">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="art-btn art-btn-outline" style="opacity: 0.5; cursor: not-allowed;">
                    ← Précédent
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="art-btn art-btn-outline">
                    ← Précédent
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="art-btn art-btn-outline" style="opacity: 0.5;">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="art-btn" style="background: var(--green); color: #fff;">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="art-btn art-btn-outline">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="art-btn art-btn-outline">
                    Suivant →
                </a>
            @else
                <span class="art-btn art-btn-outline" style="opacity: 0.5; cursor: not-allowed;">
                    Suivant →
                </span>
            @endif
        </div>
    </nav>
@endif
