@if ($paginator->hasPages())
    @php
        $linkClasses = 'inline-flex min-w-[36px] items-center justify-center rounded-lg border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-600 transition hover:border-amber-400 hover:text-amber-600';
        $activeClasses = 'inline-flex min-w-[36px] items-center justify-center rounded-lg bg-amber-500 px-3 py-2 text-sm font-semibold text-white shadow';
        $disabledClasses = 'inline-flex min-w-[36px] items-center justify-center rounded-lg border border-zinc-200 px-3 py-2 text-sm text-zinc-400';
    @endphp

    <nav role="navigation" aria-label="Pagination" class="flex items-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="{{ $disabledClasses }}" aria-hidden="true">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $linkClasses }}" aria-label="Sebelumnya">
                &lsaquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="{{ $disabledClasses }}">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="{{ $activeClasses }}" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="{{ $linkClasses }}" aria-label="Pergi ke halaman {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $linkClasses }}" aria-label="Berikutnya">
                &rsaquo;
            </a>
        @else
            <span class="{{ $disabledClasses }}" aria-hidden="true">&rsaquo;</span>
        @endif
    </nav>
@endif
