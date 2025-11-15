<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow">
    {{-- Header Title Optional --}}
    @if ($title ?? false)
        <div class="border-b bg-slate-50 p-4">
            <h2 class="text-lg font-semibold text-slate-700">{{ $title }}</h2>
        </div>
    @endif

    {{-- Search, Filter, Actions --}}
    @if (isset($actions))
        <div class="flex items-center justify-between p-4 border-b bg-slate-50">
            {{ $actions }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-slate-700">
            <thead class="bg-slate-800 text-white text-xs uppercase">
                {{ $head }}
            </thead>

            <tbody class="divide-y divide-slate-200">
                {{ $body }}
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if (isset($paginate))
        <div class="p-4 border-t">
            {{ $paginate }}
        </div>
    @endif
</div>
