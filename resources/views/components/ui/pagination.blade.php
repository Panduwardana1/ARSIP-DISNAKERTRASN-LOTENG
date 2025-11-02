@if ($paginator->hasPages())
    @php
        $window = 6;
        $totalPages = $paginator->lastPage();
        $currentPage = $paginator->currentPage();
        $groupIndex = intdiv(max(1, $currentPage) - 1, $window);
        $start = $groupIndex * $window + 1;
        $end = min($totalPages, $start + $window - 1);
    @endphp

    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center gap-2">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-zinc-200 bg-white text-sm font-medium text-zinc-300 select-none">
                &lt;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-zinc-200 bg-white text-sm font-medium text-zinc-600 hover:border-zinc-300 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-orange-200">
                &lt;
            </a>
        @endif

        {{-- Page window --}}
        @for ($page = $start; $page <= $end; $page++)
            @if ($page === $currentPage)
                <span aria-current="page"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-orange-500 bg-orange-500 text-sm font-semibold text-white select-none">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $paginator->url($page) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-zinc-200 bg-white text-sm font-medium text-zinc-600 hover:border-zinc-300 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-orange-200">
                    {{ $page }}
                </a>
            @endif
        @endfor

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-zinc-200 bg-white text-sm font-medium text-zinc-600 hover:border-zinc-300 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-orange-200">
                &gt;
            </a>
        @else
            <span
                class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-zinc-200 bg-white text-sm font-medium text-zinc-300 select-none">
                &gt;
            </span>
        @endif
    </nav>
@endif
