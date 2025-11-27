@props([
    'action',
    'title' => 'Konfirmasi Hapus',
    'message' => 'Tindakan ini takan menghapus data. Yakin ingin menghapus data ini?',
    'confirmText' => 'Hapus',
    'cancelText' => 'Batal',
    'confirmField' => null,
    'confirmValue' => '1',
])

<style>
    [x-cloak] {
        display: none !important
    }
</style>

<div x-data="{ open: false, loading: false }" x-on:keydown.escape.window="open = false" class="inline-block">
    @if (trim($slot))
        <div x-on:click="open = true" role="button">
            {{ $slot }}
        </div>
    @else
        <button type="button" x-on:click="open = true"
            class="inline-flex items-center justify-center h-7 px-2 rounded-md bg-rose-600 text-white hover:bg-rose-700 transition">
            <x-heroicon-o-trash class="h-4 w-4" />
        </button>
    @endif

    {{-- Overlay --}}
    <div x-cloak x-show="open" x-transition.opacity.duration.200ms x-on:click.self="open = false" role="dialog"
        aria-modal="true" class="fixed inset-0 z-50 p-4 bg-black/40 flex items-center justify-center">
        {{-- Dialog --}}
        <div x-show="open" x-transition.scale.duration.200ms
            class="relative w-full max-w-md rounded-xl bg-white shadow-lg ring-1 ring-black/5">
            <div class="flex items-center gap-2 px-5 py-4">
                <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-rose-500" />
                <h2 class="text-lg font-semibold text-gray-900">{{ $title }}</h2>
            </div>

            <div class="px-5 items-start py-4">
                <p class="text-md font-medium text-gray-700">{{ $message }}</p>
            </div>

            <div class="px-5 py-4 flex items-center justify-end gap-3">
                <button type="button" x-on:click="open = false"
                    class="rounded-md px-3 py-2 text-sm font-medium text-zinc-700 bg-zinc-100 hover:bg-gray-100">
                    {{ $cancelText }}
                </button>

                <form action="{{ $action }}" method="POST" class="m-0" x-on:submit="loading = true">
                    @csrf
                    @method('DELETE')
                    @if ($confirmField)
                        <input type="hidden" name="{{ $confirmField }}" value="{{ $confirmValue }}">
                    @endif
                    <button type="submit" :disabled="loading"
                        class="rounded-md bg-rose-600 px-3 py-2 text-sm font-medium text-white hover:bg-rose-700 disabled:opacity-60">
                        <span x-show="!loading">{{ $confirmText }}</span>
                        <span x-show="loading">Memproses…</span>
                    </button>
                </form>
            </div>

            <button type="button" x-on:click="open = false"
                class="absolute right-3 top-3 inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100"
                aria-label="Tutup">
                <x-heroicon-o-x-mark class="h-4 w-4" />
            </button>
        </div>
    </div>
</div>
