@php
    /** @var \App\Models\Kecamatan|null $kecamatan */
    $kecamatan = $kecamatan ?? null;
@endphp

<div class="space-y-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="nama" class="block text-sm font-medium text-zinc-700">
                Nama Kecamatan <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', optional($kecamatan)->nama) }}"
                maxlength="100" required
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
                placeholder="Contoh: Kecamatan Kademangan">
            @error('nama')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kode" class="block text-sm font-medium text-zinc-700">
                Kode Kecamatan
            </label>
            <input type="text" name="kode" id="kode" value="{{ old('kode', optional($kecamatan)->kode) }}"
                maxlength="10"
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm uppercase tracking-wide text-zinc-800 focus:outline-none focus:border-blue-300">
            @error('kode')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('sirekap.kecamatan.index') }}"
            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
            Batal
        </a>
        <button type="submit"
            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
            {{ isset($kecamatan) ? 'Update' : 'Simpan' }}
        </button>
    </div>
</div>
