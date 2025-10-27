@props([
    'showUrl' => '#',
    'editUrl' => '#',
])

<div x-data="{ open: false }" class="relative inline-flex text-left">
    <button type="button"
        class="inline-flex items-center bg-white p-1 text-zinc-500 transition hover:border-sky-200 hover:text-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-200"
        @click="open = !open" @click.away="open = false" aria-haspopup="true" x-bind:aria-expanded="open">
        <x-heroicon-s-ellipsis-horizontal class="h-5 w-5" />
    </button>

    <div x-cloak x-show="open" x-transition.opacity.scale.90
        class="absolute right-0 z-20 mt-2 w-44 origin-top-right rounded-lg border border-zinc-200 bg-white shadow-lg ring-1 ring-black/5">
        <div class="py-1 text-sm text-zinc-600">
            <a href="{{ $showUrl }}"
                class="flex items-center gap-2 px-3 py-2 transition hover:bg-sky-50 hover:text-sky-600">
                <x-heroicon-s-eye class="h-4 w-4" />
                Detail
            </a>
            <a href="{{ $editUrl }}"
                class="flex items-center gap-2 px-3 py-2 transition hover:bg-amber-50 hover:text-amber-600">
                <x-heroicon-s-pencil-square class="h-4 w-4" />
                Ubah
            </a>
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
