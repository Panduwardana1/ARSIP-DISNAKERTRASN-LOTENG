@php
    /** @var \App\Models\TenagaKerja|null $tenagaKerja */
    /** @var \Illuminate\Support\Collection|\App\Models\Perusahaan[] $perusahaans */
    /** @var \Illuminate\Support\Collection|\App\Models\Kecamatan[] $kecamatans */
    /** @var \Illuminate\Support\Collection|\App\Models\Desa[] $desas */
    /** @var \Illuminate\Support\Collection|\App\Models\Pendidikan[] $pendidikans */
    /** @var \Illuminate\Support\Collection|\App\Models\Agency[] $agencies */
    /** @var \Illuminate\Support\Collection|\App\Models\Negara[] $negaras */
    /** @var array $genders */
    /** @var array $statusOptions */
    $tenagaKerja = $tenagaKerja ?? null;
    $isEdit = isset($tenagaKerja);
    $submitLabel = $isEdit ? 'Perbarui' : 'Simpan';
    $tanggalLahirValue = old('tanggal_lahir', optional(optional($tenagaKerja)->tanggal_lahir)->format('Y-m-d'));
@endphp

<section class="space-y-4 bg-white p-6">
    <div>
        <h2 class="text-lg font-semibold text-zinc-900">Data Pribadi</h2>
        <p class="text-sm text-zinc-500">Isi identitas CPMI sesuai dokumen resmi.</p>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1">
            <label for="nama" class="text-sm font-medium text-zinc-700">Nama Lengkap <span
                    class="text-red-500">*</span></label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', optional($tenagaKerja)->nama) }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                placeholder="Masukkan nama sesuai KTP" required>
            @error('nama')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="nik" class="text-sm font-medium text-zinc-700">NIK <span
                    class="text-red-500">*</span></label>
            <input type="text" id="nik" name="nik" value="{{ old('nik', optional($tenagaKerja)->nik) }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                placeholder="16 digit NIK" inputmode="numeric" maxlength="16" required>
            @error('nik')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="gender" class="text-sm font-medium text-zinc-700">Jenis Kelamin <span
                    class="text-red-500">*</span></label>
            <select id="gender" name="gender"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
                <option value="">Pilih Jenis Kelamin</option>
                @foreach ($genders as $key => $label)
                    <option value="{{ $key }}" @selected(old('gender', optional($tenagaKerja)->gender) === $key)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('gender')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="tempat_lahir" class="text-sm font-medium text-zinc-700">Tempat Lahir <span
                    class="text-red-500">*</span></label>
            <input type="text" id="tempat_lahir" name="tempat_lahir"
                value="{{ old('tempat_lahir', optional($tenagaKerja)->tempat_lahir) }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                placeholder="Kota/Kabupaten" required>
            @error('tempat_lahir')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="tanggal_lahir" class="text-sm font-medium text-zinc-700">Tanggal Lahir <span
                    class="text-red-500">*</span></label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $tanggalLahirValue }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
            @error('tanggal_lahir')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

<section class="space-y-4 bg-white p-6">
    <div>
        <h2 class="text-lg font-semibold text-zinc-900">Kontak & Domisili</h2>
        <p class="text-sm text-zinc-500">Hubungi CPMI dan pastikan alamat terbaru.</p>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1">
            <label for="email" class="text-sm font-medium text-zinc-700">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email', optional($tenagaKerja)->email) }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                placeholder="contoh@email.com">
            @error('email')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="no_telpon" class="text-sm font-medium text-zinc-700">No. Telepon</label>
            <input type="text" id="no_telpon" name="no_telpon"
                value="{{ old('no_telpon', optional($tenagaKerja)->no_telpon) }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                placeholder="08XXXXXXXXXX" inputmode="numeric">
            @error('no_telpon')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1 sm:col-span-1">
            <label for="desa_id" class="text-sm font-medium text-zinc-700">Kecamatan & Desa<span
                    class="text-red-500">*</span></label>
            <select id="desa_id" name="desa_id"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
                @foreach ($kecamatans as $kecamatan)
                    @php
                        $desaByKecamatan = $desas->where('kecamatan_id', $kecamatan->id);
                    @endphp
                    @if ($desaByKecamatan->isNotEmpty())
                        <optgroup label="{{ $kecamatan->nama }}">
                            @foreach ($desaByKecamatan as $desa)
                                <option value="{{ $desa->id }}" @selected(old('desa_id', optional($tenagaKerja)->desa_id) == $desa->id)>
                                    {{ $kecamatan->nama }} | {{ $desa->nama }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
            @error('desa_id')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1 col-span-1">
            <label for="kode_pos" class="text-sm font-medium text-zinc-700">Kode Pos</label>
            <input type="text" id="kode_pos" name="kode_pos"
                value="{{ old('kode_pos', optional($tenagaKerja)->kode_pos) }}"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                inputmode="numeric">
            @error('kode_pos')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="space-y-1 sm:col-span-2">
        <label for="alamat_lengkap" class="text-sm font-medium text-zinc-700">Alamat Lengkap <span
                class="text-red-500">*</span></label>
        <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3"
            class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
            placeholder="Nama jalan, RT/RW, dsb." required>{{ old('alamat_lengkap', optional($tenagaKerja)->alamat_lengkap) }}</textarea>
        @error('alamat_lengkap')
            <p class="text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>
</section>

<section class="space-y-4 bg-white p-6">
    <div>
        <h2 class="text-lg font-semibold text-zinc-900">Relasi Penempatan</h2>
        <p class="text-sm text-zinc-500">Hubungkan CPMI dengan pendidikan, perusahaan, dan negara tujuan.</p>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="space-y-1">
            <label for="pendidikan_id" class="text-sm font-medium text-zinc-700">Pendidikan Terakhir <span
                    class="text-red-500">*</span></label>
            <select id="pendidikan_id" name="pendidikan_id"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
                <option value="">Pilih Pendidikan</option>
                @foreach ($pendidikans as $pendidikan)
                    <option value="{{ $pendidikan->id }}" @selected(old('pendidikan_id', optional($tenagaKerja)->pendidikan_id) == $pendidikan->id)>
                        {{ $pendidikan->nama ?? $pendidikan->label }}
                    </option>
                @endforeach
            </select>
            @error('pendidikan_id')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="perusahaan_id" class="text-sm font-medium text-zinc-700">Perusahaan (P3MI) <span
                    class="text-red-500">*</span></label>
            <select id="perusahaan_id" name="perusahaan_id"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
                <option value="">Pilih Perusahaan</option>
                @foreach ($perusahaans as $perusahaan)
                    <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id', optional($tenagaKerja)->perusahaan_id) == $perusahaan->id)>
                        {{ $perusahaan->nama }}
                    </option>
                @endforeach
            </select>
            @error('perusahaan_id')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="agency_id" class="text-sm font-medium text-zinc-700">Agency Penempatan <span
                    class="text-red-500">*</span></label>
            <select id="agency_id" name="agency_id"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
                <option value="">Pilih Agency</option>
                @foreach ($agencies as $agency)
                    <option value="{{ $agency->id }}" @selected(old('agency_id', optional($tenagaKerja)->agency_id) == $agency->id)>
                        {{ $agency->nama }} | {{ $agency->lowongan }}
                    </option>
                @endforeach
            </select>
            @error('agency_id')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="negara_id" class="text-sm font-medium text-zinc-700">Negara Tujuan <span
                    class="text-red-500">*</span></label>
            <select id="negara_id" name="negara_id"
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                required>
                <option value="">Pilih Negara</option>
                @foreach ($negaras as $negara)
                    <option value="{{ $negara->id }}" @selected(old('negara_id', optional($tenagaKerja)->negara_id) == $negara->id)>
                        {{ $negara->nama }}
                    </option>
                @endforeach
            </select>
            @error('negara_id')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</section>

<div class="flex items-center justify-end gap-3 bg-white px-6 pb-6">
    <a href="{{ route('sirekap.tenaga-kerja.index') }}"
        class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
        {{ $submitLabel }}
    </button>
</div>
