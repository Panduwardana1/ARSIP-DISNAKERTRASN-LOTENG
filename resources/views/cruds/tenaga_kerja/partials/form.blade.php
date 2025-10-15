@php
    $tenagaKerja = $tenagaKerja ?? null;
    $selectedPendidikan = old('pendidikan_id', optional($tenagaKerja)->pendidikan_id);
    $selectedAgensiLowongan = old('agensi_lowongan_id', optional($tenagaKerja)->agensi_lowongan_id);
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 font-inter">
    <div class="space-y-2">
        <label for="nama" class="block text-sm font-semibold text-neutral-700">Nama Lengkap</label>
        <input id="nama" name="nama" type="text" required maxlength="255"
            value="{{ old('nama', optional($tenagaKerja)->nama) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
        @error('nama')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="nomor_induk" class="block text-sm font-semibold text-neutral-700">NIK</label>
        <input id="nomor_induk" name="nomor_induk" type="text" inputmode="numeric" required minlength="16"
            maxlength="16" value="{{ old('nomor_induk', optional($tenagaKerja)->nomor_induk) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 font-mono text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
        @error('nomor_induk')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="jenis_kelamin" class="block text-sm font-semibold text-neutral-700">Jenis Kelamin</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
            <option value="">Pilih jenis kelamin</option>
            <option value="L" @selected(old('jenis_kelamin', optional($tenagaKerja)->jenis_kelamin) === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', optional($tenagaKerja)->jenis_kelamin) === 'P')>Perempuan</option>
        </select>
        @error('jenis_kelamin')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="email" class="block text-sm font-semibold text-neutral-700">Email</label>
        <input id="email" name="email" type="email" maxlength="150"
            value="{{ old('email', optional($tenagaKerja)->email) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
            placeholder="contoh@email.com">
        @error('email')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="tempat_lahir" class="block text-sm font-semibold text-neutral-700">Tempat Lahir</label>
        <input id="tempat_lahir" name="tempat_lahir" type="text" maxlength="150"
            value="{{ old('tempat_lahir', optional($tenagaKerja)->tempat_lahir) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
        @error('tempat_lahir')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="tanggal_lahir" class="block text-sm font-semibold text-neutral-700">Tanggal Lahir</label>
        <input id="tanggal_lahir" name="tanggal_lahir" type="date"
            value="{{ old('tanggal_lahir', optional($tenagaKerja?->tanggal_lahir)->format('Y-m-d')) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
        @error('tanggal_lahir')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="desa" class="block text-sm font-semibold text-neutral-700">Desa</label>
        <input id="desa" name="desa" type="text" maxlength="100"
            value="{{ old('desa', optional($tenagaKerja)->desa) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
        @error('desa')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="kecamatan" class="block text-sm font-semibold text-neutral-700">Kecamatan</label>
        <input id="kecamatan" name="kecamatan" type="text" maxlength="100"
            value="{{ old('kecamatan', optional($tenagaKerja)->kecamatan) }}"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
        @error('kecamatan')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="alamat_lengkap" class="block text-sm font-semibold text-neutral-700">Alamat Lengkap</label>
        <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required maxlength="65535"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">{{ old('alamat_lengkap', optional($tenagaKerja)->alamat_lengkap) }}</textarea>
        @error('alamat_lengkap')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="pendidikan_id" class="block text-sm font-semibold text-neutral-700">Pendidikan Terakhir</label>
        <select id="pendidikan_id" name="pendidikan_id"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
            <option value="">Pilih pendidikan</option>
            @foreach ($pendidikan as $id => $namaPendidikan)
                <option value="{{ $id }}" @selected((string) $selectedPendidikan === (string) $id)>{{ $namaPendidikan }}</option>
            @endforeach
        </select>
        @error('pendidikan_id')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="agensi_lowongan_id" class="block text-sm font-semibold text-neutral-700">Penempatan (Agensi Lowongan)</label>
        <select id="agensi_lowongan_id" name="agensi_lowongan_id"
            class="block w-full rounded-md border border-neutral-300 bg-neutral-50 px-3 py-2 text-sm text-neutral-700 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500">
            <option value="">Pilih agensi / penempatan</option>
            @foreach ($agensiLowongan as $al)
                @php
                    $lowongan = optional($al->lowonganPekerjaan)->nama_pekerjaan;
                    $kemitraan = collect([
                        optional($al->perusahaanAgensi?->perusahaan)->nama_perusahaan,
                        optional($al->perusahaanAgensi?->agensi)->nama_agensi,
                    ])->filter()->implode(' / ');
                    $negara = optional($al->negaraTujuan)->nama_negara;
                    $label = $lowongan ?: 'Tanpa lowongan';
                    if ($kemitraan) {
                        $label .= ' — ' . $kemitraan;
                    }
                    if ($negara) {
                        $label .= ' (' . $negara . ')';
                    }
                @endphp
                <option value="{{ $al->id }}" @selected((string) $selectedAgensiLowongan === (string) $al->id)>{{ $label }}</option>
            @endforeach
        </select>
        @error('agensi_lowongan_id')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('disnakertrans.pekerja.index') }}"
        class="inline-flex items-center font-inter gap-2 rounded-md border bg-rose-500 border-rose-400 px-4 py-2 text-sm font-medium text-neutral-50 hover:bg-rose-600">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center font-inter gap-2 rounded-md border bg-sky-500 border-sky-400 px-4 py-2 text-sm font-medium text-neutral-50 hover:bg-sky-600">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
