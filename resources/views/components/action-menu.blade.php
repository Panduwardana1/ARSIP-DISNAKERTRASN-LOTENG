{{-- Action menu --}}
@props([
    'detail' => '#',
    'edit' => '#',
    'delete' => '#',
])
{{-- modal menggunakan alpine JS --}}
<div x-data="{ open: false }" class="relative inline-block text-left">
    {{-- button togle --}}
    <button @click="open = !open" @click.outside="open=false"
        class="flex items-center justify-center px-2 py-1 rounded-sm bg-zinc-100">
        <x-heroicon-o-ellipsis-horizontal-circle class="h-5 w-5" />
    </button>

    {{-- Modal section --}}
    <div x-show="open" x-transition class="absolute right-0 z-40 overflow-hidden rounded-md">
        <a href="{{ $detail }}">
            Detail
        </a>
        <a href="{{ $edit }}">
            Edit
        </a>

        <button
            @click="open = false; $dispatch(open-delete, {url : '{{ $delete }}'});"
            class="flex w-full items-center gap-2 px-2 py-2 text-sm text-zinc-50 bg-rose-600 hover:bg-rose-400">
            <x-heroicon-o-trash class="h-5 w-5" />
            Hapus
        </button>
    </div>
</div>
