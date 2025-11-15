@extends('layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-6">
        <h1 class="text-lg font-semibold mb-4">Preview Rekomendasi</h1>

        <div class="mb-6">
            <h2 class="font-medium mb-2">Tenaga Kerja ({{ $tenagaKerjas->count() }})</h2>
            <div class="overflow-x-auto border rounded">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="p-2 text-left">#</th>
                            <th class="p-2 text-left">Nama</th>
                            <th class="p-2 text-left">NIK</th>
                            <th class="p-2 text-left">Perusahaan</th>
                            <th class="p-2 text-left">Negara Tujuan</th>
                            <th class="p-2 text-left">Tgl Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tenagaKerjas as $i => $tk)
                            <tr class="border-t">
                                <td class="p-2">{{ $i + 1 }}</td>
                                <td class="p-2">{{ $tk->nama }}</td>
                                <td class="p-2">{{ $tk->nik }}</td>
                                <td class="p-2">{{ $tk->perusahaan->nama ?? '-' }}</td>
                                <td class="p-2">{{ $tk->negara->nama ?? '-' }}</td>
                                <td class="p-2">
                                    {{ \Illuminate\Support\Carbon::parse($tk->tanggal_lahir)->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form method="POST" action="{{ route('sirekap.rekomendasi.store') }}" class="space-y-4" target="_blank">
            @csrf
            @foreach ($tenagaKerjas as $tk)
                <input type="hidden" name="tenaga_kerja_ids[]" value="{{ $tk->id }}">
            @endforeach

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm mb-1">Kode Rekomendasi</label>
                    <input type="text" name="kode" value="{{ old('kode', $kodeDefault) }}"
                        class="border rounded px-3 py-2 w-full">
                    <p class="text-xs text-zinc-500 mt-1">Format: 562/NNNN/LTSA/{{ now()->year }}</p>
                    @error('kode')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                        class="border rounded px-3 py-2 w-full">
                    @error('tanggal')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm mb-1">Author (Kepala Dinas)</label>
                    <select name="author_id" class="border rounded px-3 py-2 w-full">
                        <option value="">-- pilih author --</option>
                        @foreach ($authors as $a)
                            <option value="{{ $a->id }}" @selected(old('author_id') == $a->id)>{{ $a->nama }} —
                                {{ $a->jabatan }}</option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button name="action" value="print" class="px-4 py-2 rounded bg-amber-600 text-white">Cetak PDF</button>
            </div>
        </form>
    </section>
@endsection
