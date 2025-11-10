@extends('layouts.app')

@section('pageTitle', 'Daftar Negara')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900">Daftar Negara</h1>
                <p class="text-sm text-zinc-600">Kelola data negara, perbarui informasi, atau tambahkan entri baru.</p>
            </div>
            <a
                href="{{ route('sirekap.negara.create') }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
            >
                + Tambah Negara
            </a>
        </div>

        <form method="GET" action="{{ route('sirekap.negara.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[240px]">
                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Cari berdasarkan nama atau kode ISO..."
                    class="w-full rounded-md border border-zinc-300 px-4 py-2 pr-10 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                @if ($search !== '')
                    <a
                        href="{{ route('sirekap.negara.index') }}"
                        class="absolute inset-y-0 right-3 flex items-center text-xs text-zinc-500 hover:text-zinc-700"
                    >
                        Reset
                    </a>
                @endif
            </div>
            <button
                type="submit"
                class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50"
            >
                Cari
            </button>
        </form>

        <div class="overflow-x-auto rounded-lg border border-zinc-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead class="bg-zinc-50 text-left text-xs font-semibold uppercase tracking-wide text-zinc-600">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Negara</th>
                        <th class="px-4 py-3">Kode ISO</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 text-zinc-800">
                    @forelse ($negara as $index => $item)
                        <tr class="hover:bg-zinc-50/60">
                            <td class="px-4 py-4 text-sm text-zinc-500">
                                {{ $negara->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="p-1 border rounded-md text-xs text-zinc-500"><x-heroicon-o-map-pin class="h-6 w-6" /></span>
                                    <p class="font-medium text-lg text-zinc-900">{{ $item->nama }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-semibold tracking-wide">{{ $item->kode_iso }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $isActive = $item->is_active === 'Aktif';
                                    $badgeClasses = $isActive
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-rose-100 text-rose-700';
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                    {{ $item->is_active ?? 'Tidak diketahui' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a
                                    href="{{ route('sirekap.negara.edit', $item) }}"
                                    class="inline-flex items-center rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 hover:bg-zinc-50"
                                >
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-zinc-500">
                                Data negara belum tersedia. Tambahkan entri baru untuk mulai mengisi daftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($negara->hasPages())
            <div class="pt-2">
                {{ $negara->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
@endsection
