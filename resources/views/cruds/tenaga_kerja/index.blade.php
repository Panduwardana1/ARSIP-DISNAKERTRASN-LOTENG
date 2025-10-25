@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Disnakertrans')
@section('titleContent', 'Daftar CPMI - Tenaga Kerja')

@section('content')
    <div class="flex h-full flex-col font-inter">
        {{-- Header --}}
        <header class="border-b border-zinc-200 bg-white px-4 py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-xl font-semibold text-zinc-800">Daftar CPMI Terdata</h1>
                    <p class="text-sm text-zinc-500">Kelola data calon pekerja migran, ekspor laporan, dan lakukan pencarian cepat.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <x-heroicon-s-user-plus class="h-5 w-5" />
                        Tambah CPMI
                    </a>
                    <button type="button"
                        class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        x-data @click="$dispatch('toggle-import-modal')">
                        <x-heroicon-s-arrow-up-tray class="h-5 w-5" />
                        Import
                    </button>
                </div>
            </div>
        </header>

        {{-- Export --}}
        <section class="border-b border-zinc-200 bg-white px-4 py-4">
            <form method="GET" action="{{ route('sirekap.cpmi.export') }}" class="grid gap-4 lg:grid-cols-6">
                @php($now = now())
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Bulan</label>
                    <select name="month"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m == $now->month)>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Tahun</label>
                    <input type="number" name="year" min="2000" max="2100"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        value="{{ $now->year }}">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Agensi</label>
                    <select name="agensi_id"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">Semua</option>
                        @foreach (\App\Models\AgensiPenempatan::orderBy('nama')->get() as $a)
                            <option value="{{ $a->id }}">{{ $a->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Perusahaan</label>
                    <select name="perusahaan_id"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">Semua</option>
                        @foreach (\App\Models\PerusahaanIndonesia::orderBy('nama')->get() as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Destinasi</label>
                    <select name="destinasi_id"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <option value="">Semua</option>
                        @foreach (\App\Models\Destinasi::orderBy('nama')->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-200">
                        <img src="{{ asset('asset/excel-svgrepo-com.svg') }}" alt="Excel-icon" class="h-5 w-5">
                        Export
                    </button>
                </div>
            </form>
        </section>

        {{-- Hidden import modal placeholder --}}
        <section class="hidden">
            @include('partials._modal-import')
        </section>

        {{-- Body --}}
        <main class="flex-1 overflow-y-auto bg-zinc-50 px-4 py-6">
            <div class="mx-auto max-w-6xl space-y-6">
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

                {{-- Filter --}}
                <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}"
                    class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm">
                    <div class="grid gap-3 md:grid-cols-5">
                        <div>
                            <label for="keyword"
                                class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Kata Kunci</label>
                            <input type="text" id="keyword" name="keyword" value="{{ request('keyword') }}"
                                placeholder="Nama/ NIK"
                                class="mt-1 block w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        </div>
                        <div>
                            <label for="gender"
                                class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Gender</label>
                            <select id="gender" name="gender"
                                class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                <option value="">Semua</option>
                                @foreach (\App\Models\TenagaKerja::GENDERS as $gender)
                                    <option value="{{ $gender }}" @selected(request('gender') === $gender)>{{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pendidikan"
                                class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Pendidikan</label>
                            <select id="pendidikan" name="pendidikan"
                                class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                <option value="">Semua</option>
                                @foreach ($pendidikans as $pendidikan)
                                    <option value="{{ $pendidikan->id }}" @selected(request('pendidikan') == $pendidikan->id)>
                                        {{ $pendidikan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="lowongan"
                                class="block text-xs font-semibold uppercase tracking-wide text-zinc-500">Lowongan</label>
                            <select id="lowongan" name="lowongan"
                                class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                <option value="">Semua</option>
                                @foreach ($lowongans as $lowongan)
                                    <option value="{{ $lowongan->id }}" @selected(request('lowongan') == $lowongan->id)>
                                        {{ $lowongan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <div class="flex w-full gap-2">
                                <button type="submit"
                                    class="flex-1 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    Terapkan
                                </button>
                                <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                                    class="rounded-lg border border-zinc-200 px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Table --}}
                <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3">
                        <div class="text-sm font-semibold text-zinc-700">Total CPMI: {{ $tenagaKerjas->total() ?? $tenagaKerjas->count() }}</div>
                        @if (session('import_context'))
                            <div class="text-xs text-amber-600">Import terakhir: {{ session('import_context') }}</div>
                        @endif
                    </div>

                    @if ($tenagaKerjas->isEmpty())
                        <div class="flex flex-col items-center justify-center gap-3 px-6 py-16 text-center text-sm text-zinc-500">
                            <x-heroicon-s-user-group class="h-16 w-16 text-zinc-200" />
                            <p>Belum ada data CPMI yang tersimpan. Tambahkan data baru atau sesuaikan filter di atas.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-zinc-100 text-sm">
                                <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-500">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Nama</th>
                                        <th class="px-4 py-3 text-left">NIK</th>
                                        <th class="px-4 py-3 text-left">Kecamatan</th>
                                        <th class="px-4 py-3 text-left">Pendidikan</th>
                                        <th class="px-4 py-3 text-left">Perusahaan</th>
                                        <th class="px-4 py-3 text-left">Agensi</th>
                                        <th class="px-4 py-3 text-left">Lowongan</th>
                                        <th class="px-4 py-3 text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($tenagaKerjas as $tenagaKerja)
                                        <tr class="transition hover:bg-zinc-50/70">
                                            <td class="px-4 py-3">
                                                <div class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</div>
                                                <div class="text-xs text-zinc-500">{{ $tenagaKerja->gender }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="font-mono text-sm text-zinc-700">{{ $tenagaKerja->nik }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-600">{{ $tenagaKerja->kecamatan ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">{{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">{{ optional($tenagaKerja->lowongan?->perusahaan)->nama ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">{{ optional($tenagaKerja->lowongan?->agensi)->nama ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">{{ optional($tenagaKerja->lowongan)->nama ?? '-' }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex flex-wrap justify-end gap-2">
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
                    <div class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $tenagaKerjas->firstItem() ?? 0 }} - {{ $tenagaKerjas->lastItem() ?? 0 }} dari
                            {{ $tenagaKerjas->total() }} CPMI
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-2 py-1">
                                {{ $tenagaKerjas->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
