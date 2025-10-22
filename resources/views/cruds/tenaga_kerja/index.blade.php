@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Disnakertrans')
@section('titleContent', 'Daftar CPMI - Tenaga Kerja')

@section('content')
    <div class="flex h-full w-full flex-col">
        <div class="border-b bg-white py-2">
            <a href="{{ route('sirekap.tenaga-kerja.create') }}" class="p-2 border">BUAT</a>
        </div>
        {{-- ! modal --}}
    @section('content')
        <div class="max-w-3xl mx-auto p-4 font-inter">
            <h1 class="text-xl font-semibold mb-4">Export Rekap TKI Per Bulan</h1>

            @if ($errors->any())
                <div class="mb-3 rounded border border-red-200 bg-red-50 text-red-800 px-3 py-2">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="GET" action="{{ route('sirekap.cpmi.export') }}" class="grid sm:grid-cols-2 gap-4">
                @php
                    $now = now();
                @endphp

                <div>
                    <label class="block text-sm font-medium mb-1">Bulan</label>
                    <select name="month" class="w-full rounded border px-3 py-2">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected($m == $now->month)>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Tahun</label>
                    <input type="number" name="year" class="w-full rounded border px-3 py-2" value="{{ $now->year }}"
                        min="2000" max="2100">
                </div>

                {{-- Filter opsional --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Agensi (opsional)</label>
                    <select name="agensi_id" class="w-full rounded border px-3 py-2">
                        <option value="">Semua</option>
                        @foreach (\App\Models\AgensiPenempatan::orderBy('nama')->get() as $a)
                            <option value="{{ $a->id }}">{{ $a->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Perusahaan (opsional)</label>
                    <select name="perusahaan_id" class="w-full rounded border px-3 py-2">
                        <option value="">Semua</option>
                        @foreach (\App\Models\PerusahaanIndonesia::orderBy('nama')->get() as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Destinasi (opsional)</label>
                    <select name="destinasi_id" class="w-full rounded border px-3 py-2">
                        <option value="">Semua</option>
                        @foreach (\App\Models\Destinasi::orderBy('nama')->get() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <button class="rounded bg-blue-600 text-white px-4 py-2 hover:bg-blue-700">
                        Export Excel
                    </button>
                </div>
            </form>
        </div>
        <div class="hidden">
            @include('partials._modal-import')
        </div>
        <div class="flex w-full overflow-y-auto px-4 py-6 font-inter">
            <div class="w-full space-y-4">
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

                {{-- resources/views/tenaga-kerja/index.blade.php (bagian filter) --}}
                <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}"
                    class="grid md:grid-cols-5 gap-3 mb-4">
                    <input type="text" name="keyword" value="{{ $filters['keyword'] ?? '' }}"
                        placeholder="Cari nama / NIK" class="border rounded px-3 py-2 md:col-span-2">

                    <select name="gender" class="border rounded px-3 py-2">
                        <option value="">Semua Gender</option>
                        @foreach (['Laki-laki', 'Perempuan'] as $g)
                            <option value="{{ $g }}" @selected(($filters['gender'] ?? '') === $g)>{{ $g }}</option>
                        @endforeach
                    </select>

                    <select name="pendidikan" class="border rounded px-3 py-2">
                        <option value="">Semua Pendidikan</option>
                        @foreach ($pendidikans as $p)
                            <option value="{{ $p->id }}" @selected(($filters['pendidikan'] ?? null) == $p->id)>{{ $p->nama }}</option>
                        @endforeach
                    </select>

                    <select name="lowongan" class="border rounded px-3 py-2">
                        <option value="">Semua Lowongan</option>
                        @foreach ($lowongans as $l)
                            <option value="{{ $l->id }}" @selected(($filters['lowongan'] ?? null) == $l->id)>{{ $l->nama }}</option>
                        @endforeach
                    </select>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-emerald-600 text-white rounded">Filter</button>
                        <a href="{{ route('sirekap.tenaga-kerja.index') }}" class="px-4 py-2 border rounded">Reset</a>
                    </div>
                </form>


                <div class="rounded-lg w-full border border-zinc-100 bg-white">
                    @if ($tenagaKerjas->isEmpty())
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data CPMI yang tersimpan.
                            <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                                class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @else
                        {{-- TABEL UNTUK LAYAR BESAR --}}
                        <div class="overflow-x-auto w-full">
                            <table class="min-w-max w-full text-sm text-zinc-600 divide-y divide-zinc-200">
                                <thead class="bg-zinc-800/80 text-xs uppercase tracking-wide text-zinc-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Nama</th>
                                        <th class="px-4 py-3 text-left">NIK</th>
                                        <th class="px-4 py-3 text-left">Kecamatan</th>
                                        <th class="px-4 py-3 text-left">Pendidikan</th>
                                        <th class="px-4 py-3 text-left">P3MI</th>
                                        <th class="px-4 py-3 text-left">Agensi</th>
                                        <th class="px-4 py-3 text-left">Job</th>
                                        <th class="px-4 py-3 text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($tenagaKerjas as $tenagaKerja)
                                        <tr class="hover:bg-zinc-50/80 transition">
                                            <td class="px-4 py-3">
                                                <div class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</div>
                                                <div class="text-xs text-zinc-500">{{ $tenagaKerja->gender }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="font-mono text-sm text-zinc-700">{{ $tenagaKerja->nik }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-zinc-600">
                                                <div class="text-xs text-zinc-500">{{ $tenagaKerja->kecamatan }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm text-zinc-700">
                                                    {{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->lowongan?->perusahaan)->nama ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->lowongan?->agensi)->nama ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-700">
                                                {{ optional($tenagaKerja->lowongan)->nama ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
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


                @if ($tenagaKerjas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $tenagaKerjas->firstItem() ?? 0 }} -
                            {{ $tenagaKerjas->lastItem() ?? 0 }}
                            dari {{ $tenagaKerjas->total() }} CPMI
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-2 py-1">
                                {{ $tenagaKerjas->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
