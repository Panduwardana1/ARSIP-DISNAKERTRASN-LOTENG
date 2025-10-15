@php
    /** @var \App\Models\Pendidikan|null $pendidikan */
    $pendidikan = $pendidikan ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="space-y-2">
        <label for="kode" class="block text-sm font-semibold text-zinc-700">Kode</label>
        <input id="kode" name="kode" type="text" required maxlength="20"
            value="{{ old('kode', optional($pendidikan)->kode) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Contoh: S1-01">
        @error('kode')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="nama" class="block text-sm font-semibold text-zinc-700">Nama</label>
        <input id="nama" name="nama" type="text" required maxlength="100"
            value="{{ old('nama', optional($pendidikan)->nama) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Contoh: Sarjana Teknik Informatika">
        @error('nama')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="level" class="block text-sm font-semibold text-zinc-700">Level</label>
        <select id="level" name="level" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih level</option>
            @foreach ($levels as $levelOption)
                <option value="{{ $levelOption }}"
                    @selected(old('level', optional($pendidikan)->level) === $levelOption)>
                    {{ $levelOption }}
                </option>
            @endforeach
        </select>
        @error('level')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('disnakertrans.pendidikan.index') }}"
        class="inline-flex items-center gap-2 rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
