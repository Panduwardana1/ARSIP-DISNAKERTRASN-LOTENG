@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Preview Rekomendasi')
@section('titlePageContent', 'Preview Rekomendasi')
@section('description', 'Tinjau kembali data PMI terpilih sebelum mencetak surat rekomendasi.')

@push('head')
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
@endpush

@section('headerAction')
    <div class="flex items-center gap-2">
        <a href="{{ route('sirekap.rekomendasi.index') }}"
            class="inline-flex items-center gap-2 rounded-md border border-zinc-300 px-3 py-1.5 text-sm font-medium text-zinc-700 hover:bg-zinc-100">
            <x-heroicon-o-arrow-uturn-left class="w-4 h-4" />
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        <div class="bg-white border border-zinc-200 rounded-md overflow-hidden shadow-sm">
            <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3">
                <div>
                    <p class="text-sm font-semibold text-zinc-900">Daftar PMI</p>
                    <p class="text-xs text-zinc-500">Verifikasi ulang data sebelum melanjutkan.</p>
                </div>
                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                    {{ $tenagaKerjas->count() }} PMI
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-zinc-600 border-b border-zinc-200">
                        <tr>
                            <th class="p-4 w-12 text-xs font-semibold text-zinc-100 uppercase tracking-wider">No</th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                NIK
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                P3MI
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Agency
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Pekerjaan
                            </th>
                            <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                                Penempatan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($tenagaKerjas as $i => $tk)
                            <tr class="group hover:bg-zinc-50/80 transition-colors duration-200">
                                <td class="p-4 align-middle text-center text-sm text-zinc-500">{{ $i + 1 }}</td>
                                <td class="p-4 align-middle">
                                    <p class="text-sm font-semibold text-zinc-900">{{ $tk->nama }}</p>
                                </td>
                                <td class="p-4 align-middle text-sm text-zinc-900">{{ $tk->nik }}</td>
                                <td class="p-4 align-middle text-sm text-zinc-900">{{ $tk->perusahaan->nama ?? '-' }}</td>
                                <td class="p-4 align-middle text-sm text-zinc-900">{{ $tk->agency->nama ?? '-' }}</td>
                                <td class="p-4 align-middle text-sm text-zinc-900">{{ $tk->agency->lowongan ?? 'Belum ditentukan' }}</td>
                                <td class="p-4 align-middle text-sm text-zinc-900">{{ $tk->negara->nama ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" action="{{ route('sirekap.rekomendasi.store') }}"
            class="space-y-4 rounded-md border border-zinc-200 bg-white p-6 shadow-sm" target="_blank">
            @csrf
            @foreach ($tenagaKerjas as $tk)
                <input type="hidden" name="tenaga_kerja_ids[]" value="{{ $tk->id }}">
            @endforeach

            <div class="grid gap-4 md:grid-cols-3">
                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-700">Kode Rekomendasi</label>
                    <input type="text" name="kode" value="{{ old('kode', $kodeDefault) }}"
                        class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="text-xs text-zinc-500">Format umum: 562/NNNN/LTSA/{{ now()->year }}</p>
                    @error('kode')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-700">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                        class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('tanggal')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-700">Author (Kepala Dinas)</label>
                    <select name="author_id"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach ($authors as $a)
                            <option value="{{ $a->id }}" @selected(old('author_id') == $a->id)>{{ $a->nama }}
                                ({{ $a->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-700">Perusahaan (P3MI)</label>
                    <select name="perusahaan_id"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" disabled {{ old('perusahaan_id', $defaultPerusahaanId) ? '' : 'selected' }}>
                            Pilih perusahaan
                        </option>
                        @foreach ($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id', $defaultPerusahaanId) == $perusahaan->id)>
                                {{ $perusahaan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('perusahaan_id')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium text-zinc-700">Negara Tujuan</label>
                    <select name="negara_id"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" disabled {{ old('negara_id', $defaultNegaraId) ? '' : 'selected' }}>
                            Pilih negara tujuan
                        </option>
                        @foreach ($negaras as $negara)
                            <option value="{{ $negara->id }}" @selected(old('negara_id', $defaultNegaraId) == $negara->id)>
                                {{ $negara->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('negara_id')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-zinc-500">Pastikan data sudah benar. Hasil PDF terbuka pada tab baru.</p>
                <button name="action" value="print"
                    class="inline-flex items-center gap-2 rounded-md bg-amber-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-amber-700 transition">
                    <x-heroicon-o-printer class="w-5 h-5" />
                    Cetak PDF
                </button>
            </div>
        </form>
    </div>
@endsection
