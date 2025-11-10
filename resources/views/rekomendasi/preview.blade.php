@extends('layouts.app')

@section('pageTitle', 'SIREKAP - Preview Rekomendasi')
@section('Title', 'Preview Rekomendasi Paspor')

@section('content')
    <div class="space-y-4">
        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sirekap.rekomendasi.store') }}"
            class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm space-y-6">
            @csrf

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-sm font-semibold text-zinc-600" for="kode">Kode Surat</label>
                    <input type="text" id="kode" name="kode" value="{{ old('kode', $kode) }}"
                        readonly
                        class="mt-1 w-full rounded-lg border border-zinc-200 bg-zinc-100 px-3 py-2 text-sm font-semibold text-zinc-800 focus:outline-none">
                </div>
                <div>
                    <label class="text-sm font-semibold text-zinc-600" for="tanggal">Tanggal Surat</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $tanggal) }}"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
                </div>
                <div>
                    <label class="text-sm font-semibold text-zinc-600" for="author_id">Author / Pejabat Penandatangan</label>
                    <select id="author_id" name="author_id"
                        class="mt-1 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900">
                        <option value="">-- Pilih Author --</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" @selected(old('author_id') == $author->id)>
                                {{ $author->nama }} - {{ $author->jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('author_id')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="rounded-lg border border-zinc-100">
                <div class="flex items-center justify-between border-b border-zinc-100 px-4 py-3">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-800">Data Tenaga Kerja</h3>
                        <p class="text-sm text-zinc-500">Total {{ $tenagaKerjas->count() }} orang</p>
                    </div>
                    <a href="{{ route('sirekap.rekomendasi.index') }}"
                        class="text-sm font-semibold text-slate-900 underline underline-offset-4">Kembali ke daftar</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-100 text-sm">
                        <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            <tr>
                                <th class="px-3 py-2 text-left">No</th>
                                <th class="px-3 py-2 text-left">Nama</th>
                                <th class="px-3 py-2 text-left">NIK</th>
                                <th class="px-3 py-2 text-left">Perusahaan</th>
                                <th class="px-3 py-2 text-left">Destinasi</th>
                                <th class="px-3 py-2 text-left">Tanggal Lahir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($tenagaKerjas as $index => $tenagaKerja)
                                <tr>
                                    <td class="px-3 py-2">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2 font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</td>
                                    <td class="px-3 py-2">{{ $tenagaKerja->nik }}</td>
                                    <td class="px-3 py-2">{{ $tenagaKerja->perusahaan->nama ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $tenagaKerja->negara->nama ?? '-' }}</td>
                                    <td class="px-3 py-2">
                                        {{ optional($tenagaKerja->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @foreach ($tenagaKerjas as $tenagaKerja)
                <input type="hidden" name="tenaga_kerja_ids[]" value="{{ $tenagaKerja->id }}">
            @endforeach

            <div class="flex flex-col gap-3 border-t border-zinc-100 pt-4 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-zinc-500">
                    Pastikan data sudah benar sebelum menyimpan. Setelah tersimpan, Anda dapat melakukan export PDF.
                </p>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Simpan Rekomendasi
                </button>
            </div>
        </form>
    </div>
@endsection
