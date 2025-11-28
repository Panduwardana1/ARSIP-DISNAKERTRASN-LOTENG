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
    $selectedDesaId = old('desa_id', optional($tenagaKerja)->desa_id);
    $selectedKecamatanId = old('kecamatan_id', optional(optional($tenagaKerja)->desa)->kecamatan_id);
    $selectedPerusahaanId = old('perusahaan_id', optional($tenagaKerja)->perusahaan_id);
    $selectedAgencyId = old('agency_id', optional($tenagaKerja)->agency_id);
@endphp

<div class="bg-white">
    <section class="space-y-4 bg-white p-6">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900">Data Pribadi</h2>
            <p class="text-sm text-zinc-500">Isi identitas CPMI sesuai dokumen resmi.</p>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 bg-white">
            <div class="space-y-1">
                <label for="nama" class="text-sm font-medium text-zinc-700">Nama Lengkap <span
                        class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama"
                    value="{{ old('nama', optional($tenagaKerja)->nama) }}"
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                    required>
                @error('nama')
                    <p class="text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <label for="nik" class="text-sm font-medium text-zinc-700">NIK <span
                        class="text-red-500">*</span></label>
                <input type="text" id="nik" name="nik"
                    value="{{ old('nik', optional($tenagaKerja)->nik) }}"
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                    inputmode="numeric" maxlength="16" required>
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
                    required>
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
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300">
                @error('email')
                    <p class="text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <label for="no_telpon" class="text-sm font-medium text-zinc-700">No. Telepon</label>
                <input type="text" id="no_telpon" name="no_telpon"
                    value="{{ old('no_telpon', optional($tenagaKerja)->no_telpon) }}"
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                    inputmode="numeric">
                @error('no_telpon')
                    <p class="text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="space-y-1">
                <div class="flex items-center justify-between gap-2">
                    <label for="kecamatan_id" class="text-sm font-medium text-zinc-700">Kecamatan <span
                            class="text-red-500">*</span></label>
                    <p class="text-xs text-zinc-500">Pilih kecamatan untuk memfilter desa.</p>
                </div>
                <select id="kecamatan_id" name="kecamatan_id"
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300"
                    data-kecamatan-select required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" @selected((int) $selectedKecamatanId === $kecamatan->id)>
                            {{ $kecamatan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <p class="text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <div class="flex items-center justify-between gap-2">
                    <label for="desa_id" class="text-sm font-medium text-zinc-700">Desa/Kelurahan <span
                            class="text-red-500">*</span></label>
                    <p class="text-xs text-zinc-500">Hanya menampilkan desa sesuai kecamatan.</p>
                </div>
                <select id="desa_id" name="desa_id"
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300 disabled:cursor-not-allowed disabled:bg-zinc-100"
                    data-desa-select @disabled(!$selectedKecamatanId) required>
                    <option value="">Pilih Desa</option>
                    @foreach ($desas as $desa)
                        <option value="{{ $desa->id }}" data-kecamatan="{{ $desa->kecamatan_id }}"
                            @selected((int) $selectedDesaId === $desa->id)>
                            {{ $desa->nama }}
                        </option>
                    @endforeach
                </select>
                @error('desa_id')
                    <p class="text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="space-y-1">
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
                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300" required>{{ old('alamat_lengkap', optional($tenagaKerja)->alamat_lengkap) }}</textarea>
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
                            {{ $pendidikan->nama }}
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
                    data-perusahaan-select required>
                    <option value="">Pilih Perusahaan</option>
                    @foreach ($perusahaans as $perusahaan)
                        <option value="{{ $perusahaan->id }}" @selected((int) $selectedPerusahaanId === $perusahaan->id)>
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
                    class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-300 disabled:cursor-not-allowed disabled:bg-zinc-100"
                    data-agency-select @disabled(!$selectedPerusahaanId) required>
                    <option value="">Pilih Agency</option>
                    @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}" data-perusahaan="{{ $agency->perusahaan_id }}"
                            @selected((int) $selectedAgencyId === $agency->id)>
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
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kecamatanSelect = document.querySelector('[data-kecamatan-select]');
            const desaSelect = document.querySelector('[data-desa-select]');
            const perusahaanSelect = document.querySelector('[data-perusahaan-select]');
            const agencySelect = document.querySelector('[data-agency-select]');

            const desaPlaceholder = desaSelect ? desaSelect.querySelector('option[value=""]') : null;
            const desaOptions = desaSelect ? Array.from(desaSelect.options).filter(opt => opt.value !== '') : [];

            const agencyPlaceholder = agencySelect ? agencySelect.querySelector('option[value=""]') : null;
            const agencyOptions = agencySelect ? Array.from(agencySelect.options).filter(opt => opt.value !== '') :
                [];

            function syncDesaOptions(kecamatanId) {
                if (!desaSelect) return;

                const hasKecamatan = Boolean(kecamatanId);
                let hasMatch = false;

                desaOptions.forEach(option => {
                    const match = hasKecamatan && String(option.dataset.kecamatan) === String(kecamatanId);
                    option.hidden = !match;
                    option.disabled = !match;

                    if (!match && option.selected) {
                        option.selected = false;
                    }

                    if (match) {
                        hasMatch = true;
                    }
                });

                desaSelect.disabled = !hasKecamatan;

                if ((!hasMatch || !hasKecamatan) && desaPlaceholder) {
                    desaPlaceholder.selected = true;
                }
            }

            function syncAgencyOptions(perusahaanId) {
                if (!agencySelect) return;

                const hasPerusahaan = Boolean(perusahaanId);
                let hasMatch = false;

                agencyOptions.forEach(option => {
                    const match = hasPerusahaan && String(option.dataset.perusahaan) === String(
                        perusahaanId);
                    option.hidden = !match;
                    option.disabled = !match;

                    if (!match && option.selected) {
                        option.selected = false;
                    }

                    if (match) {
                        hasMatch = true;
                    }
                });

                agencySelect.disabled = !hasPerusahaan;

                if ((!hasMatch || !hasPerusahaan) && agencyPlaceholder) {
                    agencyPlaceholder.selected = true;
                }
            }

            if (kecamatanSelect) {
                syncDesaOptions(kecamatanSelect.value);
                kecamatanSelect.addEventListener('change', event => {
                    syncDesaOptions(event.target.value);
                });
            }

            if (perusahaanSelect) {
                syncAgencyOptions(perusahaanSelect.value);
                perusahaanSelect.addEventListener('change', event => {
                    syncAgencyOptions(event.target.value);
                });
            }
        });
    </script>
@endpush
