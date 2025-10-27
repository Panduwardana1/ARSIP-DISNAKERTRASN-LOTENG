@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agensi Penempatan')
@section('titleContent', 'Agensi Penempatan')

@section('content')
    {{-- Title Halaman --}}
@section('titlePage', 'Agensi Penempatan')

{{-- Button action --}}
@section('buttonAction')
    <a href="{{ route('sirekap.agensi.create') }}"
        class="flex items-center gap-2 rounded-md bg-green-600 px-4 py-1.5 text-sm font-semibold text-white shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        <x-heroicon-s-plus class="h-5 w-5" />
        Agensi
    </a>
@endsection

<div class="flex h-full flex-col font-inter">
    {{-- Body --}}
    <main class="flex-1 px-4 py-6">
        <div class="items-start pb-4 w-full">
            <form method="GET" action="{{ route('sirekap.agensi.index') }}" class="relative w-full max-w-md"
                role="search">
                @foreach (request()->except('keyword', 'page') as $queryName => $queryValue)
                    @if (is_scalar($queryValue))
                        <input type="hidden" name="{{ $queryName }}" value="{{ $queryValue }}">
                    @endif
                @endforeach

                <span class="pointer-events-none absolute inset-y-0 left-3 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.9 14.32a7 7 0 111.414-1.414l3.39 3.39a1 1 0 01-1.414 1.415l-3.39-3.39zM14 9a5 5 0 11-10 0 5 5 0 0110 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>

                <input id="search" name="keyword" type="search" placeholder="Cari nama agensi"
                    value="{{ old('keyword', $keyword ?? '') }}"
                    class="peer w-full rounded-md border border-zinc-300 bg-zinc-100 py-2 pl-9 pr-9 text-sm text-zinc-700 placeholder:text-zinc-400 hover:border-zinc-400 active:outline-none focus:outline-none" />

                @if (!empty($keyword))
                    <a href="{{ route('sirekap.agensi.index', request()->except('keyword', 'page')) }}"
                        class="absolute inset-y-0 right-2 my-auto inline-flex items-center rounded-full px-2 text-xs text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white"
                        aria-label="Bersihkan">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="mx-auto max-w-full space-y-6">
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('destroy'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    {{ $errors->first('destroy') }}
                </div>
            @endif

            <div class="rounded-xl border w-full max-w-full border-zinc-200 bg-white shadow-sm">
                @if ($agensiPenempatan->count())
                    <div class="hidden md:block">
                        <table class="w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                    <th class="px-6 py-4">Agensi</th>
                                    <th class="px-6 py-4">Lokasi</th>
                                    <th class="px-6 py-4">Logo</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Dibuat</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach ($agensiPenempatan as $agensi)
                                    @php
                                        $logoUrl = null;
                                        if (!empty($agensi->gambar)) {
                                            $logoUrl = \Illuminate\Support\Str::startsWith($agensi->gambar, [
                                                'http://',
                                                'https://',
                                            ])
                                                ? $agensi->gambar
                                                : \Illuminate\Support\Facades\Storage::url($agensi->gambar);
                                        }
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 align-top">
                                            <div class="font-semibold text-zinc-800">{{ $agensi->nama }}</div>
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <div class="max-w-xs text-sm text-zinc-600">
                                                {{ $agensi->lokasi ? \Illuminate\Support\Str::limit($agensi->lokasi, 80) : 'Lokasi belum diisi' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            @if ($logoUrl)
                                                <img src="{{ $logoUrl }}" alt="Logo {{ $agensi->nama }}"
                                                    class="h-12 w-12 rounded-md border border-zinc-200 object-cover"
                                                    onerror="this.style.display='none'">
                                            @else
                                                <span class="text-xs text-zinc-400">Tidak ada logo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <span
                                                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold"
                                                @class([
                                                    'bg-emerald-100 text-emerald-700' => $agensi->is_aktif === 'aktif',
                                                    'bg-rose-100 text-rose-700' => $agensi->is_aktif === 'non_aktif',
                                                ])>
                                                <span class="h-2 w-2 rounded-full" @class([
                                                    'bg-emerald-500' => $agensi->is_aktif === 'aktif',
                                                    'bg-rose-500' => $agensi->is_aktif === 'non_aktif',
                                                ])></span>
                                                {{ ucfirst(str_replace('_', ' ', $agensi->is_aktif)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                            {{ $agensi->created_at?->format('d M Y') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 align-top text-right">
                                            <div class="inline-flex items-center justify-end gap-2">
                                                <a href="{{ route('sirekap.agensi.show', $agensi) }}"
                                                    class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                                    Detail
                                                </a>
                                                <a href="{{ route('sirekap.agensi.edit', $agensi) }}"
                                                    class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                                    Ubah
                                                </a>
                                                <x-modal-delete :action="route('sirekap.agensi.destroy', $agensi)" title="Hapus Agensi">
                                                </x-modal-delete>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="space-y-4 p-4 md:hidden">
                        @foreach ($agensiPenempatan as $agensi)
                            @php
                                $logoUrl = null;
                                if (!empty($agensi->gambar)) {
                                    $logoUrl = \Illuminate\Support\Str::startsWith($agensi->gambar, [
                                        'http://',
                                        'https://',
                                    ])
                                        ? $agensi->gambar
                                        : \Illuminate\Support\Facades\Storage::url($agensi->gambar);
                                }
                            @endphp
                            <article class="rounded-xl border border-zinc-200 p-4 shadow-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-base font-semibold text-zinc-800">{{ $agensi->nama }}</h3>
                                        <p class="text-xs text-zinc-500">ID: {{ $agensi->id }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[11px] font-semibold"
                                        @class([
                                            'bg-emerald-100 text-emerald-700' => $agensi->is_aktif === 'aktif',
                                            'bg-rose-100 text-rose-700' => $agensi->is_aktif === 'non_aktif',
                                        ])>
                                        <span class="h-2.5 w-2.5 rounded-full" @class([
                                            'bg-emerald-500' => $agensi->is_aktif === 'aktif',
                                            'bg-rose-500' => $agensi->is_aktif === 'non_aktif',
                                        ])></span>
                                        {{ ucfirst(str_replace('_', ' ', $agensi->is_aktif)) }}
                                    </span>
                                </div>

                                <div class="mt-3 space-y-2 text-xs text-zinc-500">
                                    <p>Lokasi:
                                        <span class="font-medium text-zinc-700">
                                            {{ $agensi->lokasi ? \Illuminate\Support\Str::limit($agensi->lokasi, 120) : 'Belum diisi' }}
                                        </span>
                                    </p>
                                    <p>Dibuat:
                                        <span class="font-medium text-zinc-700">
                                            {{ $agensi->created_at?->format('d M Y') ?? '-' }}
                                        </span>
                                    </p>
                                    @if ($logoUrl)
                                        <div class="flex items-center gap-2">
                                            <img src="{{ $logoUrl }}" alt="Logo {{ $agensi->nama }}"
                                                class="h-12 w-12 rounded-md border border-zinc-200 object-cover"
                                                onerror="this.style.display='none'">
                                            <span class="text-[10px] text-zinc-400">Logo saat ini</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a href="{{ route('sirekap.agensi.show', $agensi) }}"
                                        class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                        Detail
                                    </a>
                                    <a href="{{ route('sirekap.agensi.edit', $agensi) }}"
                                        class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                        Ubah
                                    </a>
                                    <x-modal-delete :action="route('sirekap.agensi.destroy', $agensi)" title="Hapus Agensi">
                                    </x-modal-delete>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center text-sm text-zinc-500">
                        Belum ada data agensi yang tersimpan.
                        <a href="{{ route('sirekap.agensi.create') }}"
                            class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                            Tambah sekarang
                        </a>
                    </div>
                @endif
            </div>

            @if ($agensiPenempatan instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div
                    class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-center sm:text-left">
                        Menampilkan {{ $agensiPenempatan->firstItem() ?? 0 }} -
                        {{ $agensiPenempatan->lastItem() ?? 0 }} dari
                        {{ $agensiPenempatan->total() }} agensi
                    </div>
                    <div class="flex justify-center sm:justify-end">
                        {{ $agensiPenempatan->withQueryString()->links('components.pagination.simple') }}
                    </div>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
