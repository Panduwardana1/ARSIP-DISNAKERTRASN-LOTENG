@php
    /** @var \App\Models\LowonganPekerjaan|null $lowonganPekerjaan */
    $lowonganPekerjaan = $lowonganPekerjaan ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="space-y-2 md:col-span-2">
        <label for="nama_pekerjaan" class="block text-sm font-semibold text-zinc-700">Nama Pekerjaan</label>
        <input id="nama_pekerjaan" name="nama_pekerjaan" type="text" required maxlength="255"
            value="{{ old('nama_pekerjaan', optional($lowonganPekerjaan)->nama_pekerjaan) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Contoh: Pekerja Perawatan Lansia">
        @error('nama_pekerjaan')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="kontrak_kerja" class="block text-sm font-semibold text-zinc-700">Durasi Kontrak (bulan)</label>
        <input id="kontrak_kerja" name="kontrak_kerja" type="number" min="1"
            value="{{ old('kontrak_kerja', optional($lowonganPekerjaan)->kontrak_kerja) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Contoh: 24">
        @error('kontrak_kerja')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="keterangan" class="block text-sm font-semibold text-zinc-700">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="4"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Informasi tambahan mengenai lowongan">{{ old('keterangan', optional($lowonganPekerjaan)->keterangan) }}</textarea>
        @error('keterangan')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('disnakertrans.lowongan-pekerjaan.index') }}"
        class="inline-flex items-center gap-2 rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
