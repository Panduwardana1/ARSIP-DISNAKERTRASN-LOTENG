@php
    /** @var \App\Models\Perusahaan|null $perusahaan */
    $perusahaan = $perusahaan ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="space-y-2 md:col-span-2">
        <label for="nama_perusahaan" class="block text-sm font-semibold text-zinc-700">Nama Perusahaan</label>
        <input id="nama_perusahaan" name="nama_perusahaan" type="text" required maxlength="150"
            value="{{ old('nama_perusahaan', optional($perusahaan)->nama_perusahaan) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="PT Contoh Indonesia">
        @error('nama_perusahaan')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="email" class="block text-sm font-semibold text-zinc-700">Email</label>
        <input id="email" name="email" type="email" maxlength="120"
            value="{{ old('email', optional($perusahaan)->email) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="perusahaan@email.com">
        @error('email')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="nama_pimpinan" class="block text-sm font-semibold text-zinc-700">Nama Pimpinan</label>
        <input id="nama_pimpinan" name="nama_pimpinan" type="text" maxlength="120"
            value="{{ old('nama_pimpinan', optional($perusahaan)->nama_pimpinan) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Nama pimpinan">
        @error('nama_pimpinan')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="no_telepon" class="block text-sm font-semibold text-zinc-700">Nomor Telepon</label>
        <input id="no_telepon" name="no_telepon" type="text" maxlength="20"
            value="{{ old('no_telepon', optional($perusahaan)->no_telepon) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="+62 812 3456 7890">
        @error('no_telepon')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="alamat" class="block text-sm font-semibold text-zinc-700">Alamat</label>
        <textarea id="alamat" name="alamat" rows="4"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500"
            placeholder="Alamat lengkap kantor">{{ old('alamat', optional($perusahaan)->alamat) }}</textarea>
        @error('alamat')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('disnakertrans.perusahaan.index') }}"
        class="inline-flex items-center gap-2 rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
