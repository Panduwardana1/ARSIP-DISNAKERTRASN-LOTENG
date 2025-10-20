@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Disnakertrans')
@section('titleContent', 'Daftar CPMI - Tenaga Kerja')

@section('content')
    <div class="flex h-full w-full flex-col">
        <div class="border-b bg-white py-2">
            {{-- <x-navbar-crud>
                <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                    class="inline-flex items-center justify-center rounded-md border border-amber-500 bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
                    <x-heroicon-o-plus class="mr-2 h-4 w-4" />
                    Tambah CPMI
                </a>
            </x-navbar-crud> --}}
        </div>
        <div class="mx-auto max-w-3xl p-4">
            <h1 class="text-xl font-semibold mb-4">Import Data TKI (Excel)</h1>

            {{-- Flash alerts --}}
            @if (session('success'))
                <div class="mb-3 rounded border border-green-200 bg-green-50 text-green-800 px-3 py-2">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('info'))
                <div class="mb-3 rounded border border-blue-200 bg-blue-50 text-blue-800 px-3 py-2">
                    {{ session('info') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-3 rounded border border-yellow-200 bg-yellow-50 text-yellow-800 px-3 py-2">
                    {{ session('warning') }}
                </div>
            @endif

            {{-- Validation errors (file, header, dll.) --}}
            @if ($errors->any())
                <div class="mb-3 rounded border border-red-200 bg-red-50 text-red-800 px-3 py-2">
                    <div class="font-medium">Terjadi kesalahan:</div>
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form upload --}}
            <form action="{{ route('sirekap.pekerja.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">File Excel (.xlsx/.xls)</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required
                        class="w-full rounded border px-3 py-2">
                    <p class="mt-1 text-xs text-zinc-600">
                        Gunakan header: <code>nama, nik, gender, tempat_lahir, tanggal_lahir, email, desa, kecamatan,
                            alamat_lengkap, pendidikan, lowongan</code>
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Mode simpan</label>
                        <select name="mode" class="w-full rounded border px-3 py-2">
                            <option value="upsert" selected>Upsert by NIK (rekomendasi)</option>
                            <option value="insert">Insert only (skip jika NIK sudah ada)</option>
                        </select>
                    </div>

                    <label class="flex items-center gap-2 mt-6 sm:mt-8">
                        <input type="checkbox" name="dry_run" value="1" class="h-4 w-4" checked>
                        <span class="text-sm">Preview saja (cek dulu, tidak menyimpan ke database)</span>
                    </label>
                </div>

                <div class="flex items-center gap-2">
                    <button class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                        Jalankan
                    </button>
                    {{-- <a href="{{ route('tki.template') }}"
                        class="rounded bg-slate-700 px-4 py-2 text-white hover:bg-slate-800">
                        Download Template
                    </a> --}}
                </div>
            </form>

            {{-- Daftar baris gagal (hasil dari import/preview) --}}
            @if (session('failures') && count(session('failures')) > 0)
                <div class="mt-6">
                    <h2 class="font-semibold mb-2">Baris yang gagal</h2>
                    <div class="overflow-x-auto rounded border">
                        <table class="min-w-full text-sm">
                            <thead class="bg-zinc-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">Baris</th>
                                    <th class="px-3 py-2 text-left">Pesan</th>
                                    <th class="px-3 py-2 text-left">Cuplikan Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('failures') as $failure)
                                    <tr class="border-t">
                                        <td class="px-3 py-2 align-top">Baris {{ $failure->row() }}</td>
                                        <td class="px-3 py-2 align-top">
                                            <ul class="list-disc pl-5">
                                                @foreach ($failure->errors() as $msg)
                                                    <li>{{ $msg }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-3 py-2 align-top">
                                            @php
                                                // tampilkan 4-6 kolom penting saja biar ringkas
                                                $vals = $failure->values();
                                                $previewKeys = ['nama', 'nik', 'gender', 'pendidikan', 'lowongan'];
                                                $parts = [];
                                                foreach ($previewKeys as $k) {
                                                    if (isset($vals[$k]) && $vals[$k] !== null && $vals[$k] !== '') {
                                                        $parts[] = $k . ': ' . $vals[$k];
                                                    }
                                                }
                                                echo e(implode(' | ', $parts));
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="mt-2 text-xs text-zinc-600">
                        * Perbaiki baris-baris ini di Excel lalu jalankan ulang. Jika ingin menyimpan ke database, matikan
                        opsi “Preview saja”.
                    </p>
                </div>
            @endif
        </div>
        <div class="flex w-full overflow-y-auto px-4 py-6 font-inter">
            <div class="w-full space-y-4">
                @if (session('success'))
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
                                                        class="inline-flex items-center rounded-xl bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                                                        class="inline-flex items-center rounded-xl bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
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
