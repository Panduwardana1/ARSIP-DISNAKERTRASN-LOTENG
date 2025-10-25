@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agensi Penempatan')
@section('titleContent', 'Agensi Penempatan')

@section('content')
    <div class="flex h-full flex-col">
        <div class="border-b bg-white">
            <div
                class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 font-inter sm:flex-row sm:items-center sm:justify-between">
                <div class="flex w-full flex-col gap-3 sm:max-w-xl sm:flex-row sm:items-center sm:gap-4">
                    <x-search-data class="w-full" :action="route('sirekap.agensi.index')" placeholder="Cari nama agensi" name="keyword"
                        :value="$filters['keyword'] ?? ''" />

                    <form action="{{ route('sirekap.agensi.index') }}" method="GET"
                        class="flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-600 transition focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400/20">
                        <input type="hidden" name="keyword" value="{{ $filters['keyword'] ?? '' }}">
                        <label class="flex items-center gap-2">
                            <span class="hidden text-xs font-semibold uppercase text-zinc-400 sm:block">Status</span>
                            <select name="status" onchange="this.form.submit()"
                                class="w-full min-w-[8rem] bg-transparent text-sm font-medium text-zinc-700 focus:outline-none">
                                <option value="">Semua Status</option>
                                <option value="aktif" @selected(($filters['status'] ?? '') === 'aktif')>Aktif</option>
                                <option value="non_aktif" @selected(($filters['status'] ?? '') === 'non_aktif')>Non Aktif</option>
                            </select>
                        </label>
                    </form>
                </div>

                <x-button href="{{ route('sirekap.agensi.create') }}" color="teal" class="justify-center items-center">
                    <x-heroicon-o-plus class="h-5 w-5" />
                    Tambah
                </x-button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4 font-inter">
            <div class="mx-auto max-w-6xl space-y-4">
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

                <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">
                    @if ($agensiPenempatan->count())
                        <div class="hidden md:block">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
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
                                        <tr>
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $agensi->nama }}</div>
                                                <div class="text-xs text-zinc-500">
                                                    ID: {{ $agensi->id }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="max-w-xs text-sm text-zinc-600">
                                                    {{ $agensi->lokasi ? \Illuminate\Support\Str::limit($agensi->lokasi, 80) : 'Lokasi belum diisi' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                @if ($agensi->gambar_url)
                                                    <img src="{{ $agensi->gambar_url }}" alt="Logo {{ $agensi->nama }}"
                                                        class="h-10 w-10 rounded-md border border-zinc-200 object-cover"
                                                        onerror="this.style.display='none'">
                                                @else
                                                    <span class="text-xs text-zinc-400">Tidak ada logo</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span @class([
                                                    'items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold',
                                                    'bg-emerald-100 text-emerald-700' => $agensi->is_aktif === 'aktif',
                                                    'bg-rose-100 text-rose-700' => $agensi->is_aktif === 'non_aktif',
                                                ])>
                                                    <span class="h-2.5 w-2.5 rounded-full"
                                                        @class([
                                                            'bg-emerald-500' => $agensi->is_aktif === 'aktif',
                                                            'bg-rose-500' => $agensi->is_aktif === 'non_aktif',
                                                        ])></span>
                                                    {{ ucfirst(str_replace('_', ' ', $agensi->is_aktif)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $agensi->created_at?->format('d M Y') ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-right align-top">
                                                <x-action :show-url="route('sirekap.agensi.show', $agensi)"
                                                    :edit-url="route('sirekap.agensi.edit', $agensi)"
                                                    :delete-url="route('sirekap.agensi.destroy', $agensi)" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-4 p-4 md:hidden">
                            @foreach ($agensiPenempatan as $agensi)
                                <article class="rounded-lg border border-zinc-200 p-4">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <p class="text-base font-semibold text-zinc-800">{{ $agensi->nama }}</p>
                                            <p class="text-xs text-zinc-500">ID: {{ $agensi->id }}</p>
                                        </div>
                                        <span @class([
                                            'inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold',
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
                                        @if ($agensi->gambar_url)
                                            <div class="flex items-center gap-2">
                                                <img src="{{ $agensi->gambar_url }}" alt="Logo {{ $agensi->nama }}"
                                                    class="h-12 w-12 rounded-md border border-zinc-200 object-cover"
                                                    onerror="this.style.display='none'">
                                                <span class="text-[10px] text-zinc-400">Logo saat ini</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4">
                                        <x-action :show-url="route('sirekap.agensi.show', $agensi)"
                                            :edit-url="route('sirekap.agensi.edit', $agensi)"
                                            :delete-url="route('sirekap.agensi.destroy', $agensi)" />
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
                        class="flex flex-col gap-3 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $agensiPenempatan->firstItem() ?? 0 }} -
                            {{ $agensiPenempatan->lastItem() ?? 0 }}
                            dari {{ $agensiPenempatan->total() }} agensi
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-3 py-1.5">
                                {{ $agensiPenempatan->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
