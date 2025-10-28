@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Disnakertrans')
@section('titlePageContent', 'Daftar CPMI')

{{-- Content --}}
@section('content')
    <div class="flex h-full flex-col font-inter">
        {{-- Export modal --}}
        <div x-data="{ open: false }" x-on:toggle-export-modal.window="open = !open"
            x-on:close-export-modal.window="open = false" x-on:keydown.escape.window="open = false">
            <div x-cloak x-show="open" x-transition.opacity.duration.200ms class="fixed inset-0 z-40 bg-slate-900/40">
            </div>

            <div x-cloak x-show="open" x-transition x-on:click.self="open = false"
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
                <section class="relative w-full max-w-2xl rounded-md border border-zinc-200 bg-white shadow-xl">
                    <div class="flex items-start justify-between border-b border-zinc-200 px-6 py-4">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-800">Export Data CPMI</h2>
                            <p class="text-sm text-zinc-500">Sesuaikan parameter export lalu unduh berkas Excel.</p>
                        </div>
                        <button type="button"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700"
                            x-on:click="open = false" aria-label="Tutup">
                            <x-heroicon-o-x-mark class="h-5 w-5" />
                        </button>
                    </div>
                    <div class="px-6 py-5 grid">
                        <form method="GET" action="{{ route('sirekap.cpmi.export') }}" class="grid gap-4">
                            @php($now = now())
                            <div class="lg:col-span-2">
                                <label
                                    class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Bulan</label>
                                <select name="month"
                                    class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" @selected($m == $now->month)>
                                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Tahun</label>
                                <input type="number" name="year" min="2000" max="2100"
                                    class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    value="{{ $now->year }}">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Agensi</label>
                                <select name="agensi_id"
                                    class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value="">Semua</option>
                                    @foreach (\App\Models\AgensiPenempatan::orderBy('nama')->get() as $a)
                                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Perusahaan</label>
                                <select name="perusahaan_id"
                                    class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value="">Semua</option>
                                    @foreach (\App\Models\PerusahaanIndonesia::orderBy('nama')->get() as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Destinasi</label>
                                <select name="destinasi_id"
                                    class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value="">Semua</option>
                                    @foreach (\App\Models\Destinasi::orderBy('nama')->get() as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex w-full col-span-2">
                                <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-200">
                                    <img src="{{ asset('asset/excel-svgrepo-com.svg') }}" alt="Excel-icon" class="h-5 w-5">
                                    Export
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>

        {{-- Import modal --}}
        <div x-data="{ open: {{ json_encode(
            session()->has('import_context') ||
                session()->has('failures') ||
                session()->has('schema_errors') ||
                $errors->has('file') ||
                $errors->has('mode') ||
                $errors->has('dry_run'),
        ) }} }" x-on:toggle-import-modal.window="open = !open"
            x-on:close-import-modal.window="open = false" x-on:keydown.escape.window="open = false">
            <div x-cloak x-show="open" x-transition.opacity.duration.200ms class="fixed inset-0 z-40 bg-slate-900/40">
            </div>

            <div x-cloak x-show="open" x-transition x-on:click.self="open = false"
                class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
                <section
                    class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl border border-zinc-200 bg-white shadow-xl"
                    role="dialog" aria-modal="true">
                    @include('partials._modal-import')
                </section>
            </div>
        </div>

        {{-- Body --}}
        <main class="flex-1 px-4 py-6">
            <div class="flex items-center justify-between pb-4 w-full">
                <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}" class="relative w-full max-w-md"
                    role="search">
                    @foreach (request()->except('keyword', 'page') as $queryName => $queryValue)
                        @if (is_scalar($queryValue))
                            <input type="hidden" name="{{ $queryName }}" value="{{ $queryValue }}">
                        @endif
                    @endforeach
                    <!-- Icon kiri -->
                    <span class="pointer-events-none absolute inset-y-0 left-3 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a7 7 0 111.414-1.414l3.39 3.39a1 1 0 01-1.414 1.415l-3.39-3.39zM14 9a5 5 0 11-10 0 5 5 0 0110 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>

                    <!-- Input -->
                    <input id="search" name="keyword" type="search" placeholder="Cari nama atau NIK"
                        value="{{ old('keyword', $filters['keyword'] ?? '') }}"
                        class="peer w-full rounded-md border border-zinc-300 bg-zinc-100 py-2 pl-9 pr-9 text-sm text-zinc-700 placeholder:text-zinc-400 hover:border-zinc-400 active:outline-none focus:outline-none" />

                    <!-- Tombol clear -->
                    @if (!empty($filters['keyword']))
                        <a href="{{ route('sirekap.tenaga-kerja.index', request()->except('keyword', 'page')) }}"
                            class="absolute inset-y-0 right-2 my-auto inline-flex items-center rounded-full px-2 text-xs text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white"
                            aria-label="Bersihkan">
                            Clear
                        </a>
                    @endif
                </form>

                {{-- button action --}}
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="flex items-center gap-2 rounded-md border border-sky-200 bg-sky-600 px-4 py-1.5 text-sm font-semibold text-zinc-50 hover:bg-sky-500 focus:outline-none"
                        x-data @click="$dispatch('toggle-import-modal')">
                        <x-heroicon-s-arrow-up-tray class="h-5 w-5" />
                        Import
                    </button>
                    <button type="button"
                        class="flex items-center gap-2 rounded-md border border-emerald-200 bg-emerald-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-emerald-500 focus:outline-none"
                        x-data @click="$dispatch('toggle-export-modal')">
                        <x-heroicon-s-arrow-down-tray class="h-5 w-5" />
                        Export
                    </button>
                    <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                        class="flex items-center gap-2 rounded-md bg-green-600 px-4 py-1.5 text-sm font-semibold text-white shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                        <x-heroicon-s-plus class="h-5 w-5" />
                        CPMI
                    </a>
                </div>
            </div>

            <div class="mx-auto max-w-full space-y-6">
                @if (session('success') && !session('import_context'))
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('destroy'))
                    <div class="rounded-md border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ $errors->first('destroy') }}
                    </div>
                @endif

                {{-- Table --}}
                @if (session('import_context'))
                    <div class="text-xs text-amber-600">Import terakhir: {{ session('import_context') }}</div>
                @endif
                <div class="rounded-md border border-zinc-200 bg-white">
                    {{-- <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3">
                        <div class="text-sm font-semibold text-zinc-700">Total CPMI:
                            {{ $tenagaKerjas->total() ?? $tenagaKerjas->count() }}</div>
                    </div> --}}

                    @if ($tenagaKerjas->isEmpty())
                        <div
                            class="flex flex-col items-center justify-center gap-3 px-6 py-16 text-center text-sm text-zinc-500">
                            <x-heroicon-s-user-group class="h-16 w-16 text-zinc-200" />
                            <p>Belum ada data CPMI yang tersimpan. Tambahkan data baru atau sesuaikan filter di atas.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Nama</th>
                                        <th class="px-6 py-4">NIK</th>
                                        <th class="px-6 py-4">Kecamatan</th>
                                        <th class="px-6 py-4">Pendidikan</th>
                                        <th class="px-6 py-4">Perusahaan</th>
                                        <th class="px-6 py-4">Agensi</th>
                                        <th class="px-6 py-4">Lowongan</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($tenagaKerjas as $tenagaKerja)
                                        <tr class="transition hover:bg-zinc-50/70">
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</div>
                                                <div class="text-xs text-zinc-500">{{ $tenagaKerja->gender }}</div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="text-sm text-zinc-700">{{ $tenagaKerja->nik }}</div>
                                            </td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                                {{ $tenagaKerja->kecamatan ?? '-' }}</td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                                {{ optional($tenagaKerja->pendidikan)->level ?? '-' }}</td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                                {{ optional($tenagaKerja->lowongan?->perusahaan)->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                                {{ optional($tenagaKerja->lowongan?->agensi)->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                                {{ optional($tenagaKerja->lowongan)->nama ?? '-' }}</td>
                                            <td class="px-6 py-4 align-top text-right">
                                                <div class="inline-flex items-center justify-end gap-2 whitespace-nowrap">
                                                    <a href="{{ route('sirekap.tenaga-kerja.show', $tenagaKerja) }}"
                                                        class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                                                        class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                                        Ubah
                                                    </a>
                                                    <x-modal-delete :action="route('sirekap.tenaga-kerja.destroy', $tenagaKerja)" title="Hapus Data">
                                                    </x-modal-delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                @if ($tenagaKerjas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $tenagaKerjas->firstItem() ?? 0 }} - {{ $tenagaKerjas->lastItem() ?? 0 }} dari
                            {{ $tenagaKerjas->total() }} CPMI
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $tenagaKerjas->withQueryString()->links('components.pagination.simple') }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
