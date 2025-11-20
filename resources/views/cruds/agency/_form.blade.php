@php
    /** @var \App\Models\Agency|null $agency */
    /** @var \Illuminate\Support\Collection|\App\Models\Perusahaan[] $perusahaans */
    $agency = $agency ?? null;
@endphp

<div class="space-y-6">
    <div>
        <label for="nama" class="block text-sm font-medium text-zinc-700">
            Nama Agency <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', optional($agency)->nama) }}"
            maxlength="100" required
            class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
            placeholder="Contoh: Japan Placement Agency">
        @error('nama')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="perusahaan_id" class="block text-sm font-medium text-zinc-700">
            Perusahaan Mitra <span class="text-rose-500">*</span>
        </label>
        <select name="perusahaan_id" id="perusahaan_id" required
            class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300">
            <option value="">Pilih P3MI</option>
            @foreach ($perusahaans as $perusahaan)
                <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id', optional($agency)->perusahaan_id) == $perusahaan->id)>
                    {{ $perusahaan->nama }}
                </option>
            @endforeach
        </select>
        @error('perusahaan_id')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-1">
        <div>
            <label for="lowongan" class="block text-sm font-medium text-zinc-700">
                Ringkasan Lowongan
            </label>
            <input type="text" name="lowongan" id="lowongan"
                value="{{ old('lowongan', optional($agency)->lowongan) }}" maxlength="100"
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
                placeholder="Contoh: Caregiver, Manufacturing">
            @error('lowongan')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-zinc-700">
                Keterangan Tambahan
            </label>
            <textarea name="keterangan" id="keterangan" rows="4" placeholder="Masukkan catatan penting mengenai agency."
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300">{{ old('keterangan', optional($agency)->keterangan) }}</textarea>
            @error('keterangan')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('sirekap.agency.index') }}"
            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
            Batal
        </a>
        <button type="submit"
            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
            {{ isset($agency) ? 'Simpan Perubahan' : 'Simpan' }}
        </button>
    </div>
</div>
