@php
    /** @var \App\Models\Desa|null $desa */
    /** @var \Illuminate\Support\Collection|\App\Models\Kecamatan[] $kecamatans */
    $desa = $desa ?? null;
@endphp

<div class="space-y-6">
    <div class="grid gap-6">
        <div class="grid gap-6 md:grid-cols-1">
            <div>
                <label for="nama" class="block text-sm font-medium text-zinc-700">
                    Nama Desa <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', optional($desa)->nama) }}" maxlength="100" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
                    placeholder="Contoh: Desa Sukamakmur">
                @error('nama')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kecamatan_id" class="block text-sm font-medium text-zinc-700">
                    Kecamatan Induk <span class="text-rose-500">*</span>
                </label>
                <select name="kecamatan_id" id="kecamatan_id" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300">
                    <option value="">Pilih kecamatan...</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" @selected(old('kecamatan_id', optional($desa)->kecamatan_id) == $kecamatan->id)>
                            {{ $kecamatan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('sirekap.desa.index') }}"
                class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                Batal
            </a>
            <button type="submit"
                class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                {{ isset($desa) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </div>
