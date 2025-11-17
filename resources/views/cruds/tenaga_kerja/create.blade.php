@extends('layouts.app')

@php
    /** @var \Illuminate\Support\Collection|\App\Models\Perusahaan[] $perusahaans */
    /** @var \Illuminate\Support\Collection|\App\Models\Kecamatan[] $kecamatans */
    /** @var \Illuminate\Support\Collection|\App\Models\Desa[] $desas */
    /** @var \Illuminate\Support\Collection|\App\Models\Pendidikan[] $pendidikans */
    /** @var \Illuminate\Support\Collection|\App\Models\Agency[] $agencies */
    /** @var \Illuminate\Support\Collection|\App\Models\Negara[] $negaras */
    /** @var array $genders */
    /** @var array $statusOptions */

    $isEdit = isset($tenagaKerja);
    $formAction = $isEdit ? route('sirekap.tenaga-kerja.update', $tenagaKerja) : route('sirekap.tenaga-kerja.store');
    $formTitle = $isEdit ? 'Ubah Data Tenaga Kerja' : 'Tambah Data Tenaga Kerja';
    $submitLabel = $isEdit ? 'Perbarui' : 'Simpan';
    $tanggalLahirValue = old(
        'tanggal_lahir',
        isset($tenagaKerja) && $tenagaKerja->tanggal_lahir ? $tenagaKerja->tanggal_lahir->format('Y-m-d') : null,
    );
@endphp

@section('pageTitle', $formTitle)
@section('Title', 'Tenaga Kerja')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Data CPMI</p>
                <h1 class="text-2xl font-semibold text-zinc-900">{{ $formTitle }}</h1>
                <p class="text-sm text-zinc-600">
                    Lengkapi identitas, domisili, dan relasi penempatan CPMI secara terstruktur.
                </p>
            </div>
        </div>
        @error('app')
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $message }}
            </div>
        @enderror

        @if ($errors->any())
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <p class="font-semibold">Periksa kembali data berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto w-full max-w-6xl">
            <form action="{{ $formAction }}" method="POST" class="space-y-2 border">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <section class="space-y-4 bg-white p-6">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900">Data Pribadi</h2>
                        <p class="text-sm text-zinc-500">Isi identitas CPMI sesuai dokumen resmi.</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1">
                            <label for="nama" class="text-sm font-medium text-zinc-700">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nama" name="nama"
                                value="{{ old('nama', $tenagaKerja->nama ?? '') }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                placeholder="Masukkan nama sesuai KTP" required>
                            @error('nama')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="nik" class="text-sm font-medium text-zinc-700">NIK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="nik" name="nik"
                                value="{{ old('nik', $tenagaKerja->nik ?? '') }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                placeholder="16 digit NIK" inputmode="numeric" maxlength="16" required>
                            @error('nik')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="gender" class="text-sm font-medium text-zinc-700">Jenis Kelamin <span
                                    class="text-red-500">*</span></label>
                            <select id="gender" name="gender"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                                <option value="">Pilih Jenis Kelamin</option>
                                @foreach ($genders as $key => $label)
                                    <option value="{{ $key }}" @selected(old('gender', $tenagaKerja->gender ?? '') === $key)>
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
                                value="{{ old('tempat_lahir', $tenagaKerja->tempat_lahir ?? '') }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                placeholder="Kota/Kabupaten" required>
                            @error('tempat_lahir')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="tanggal_lahir" class="text-sm font-medium text-zinc-700">Tanggal Lahir <span
                                    class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $tanggalLahirValue }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                            @error('tanggal_lahir')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="is_active" class="text-sm font-medium text-zinc-700">Status</label>
                            <select id="is_active" name="is_active"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('is_active', $tenagaKerja->is_active ?? 'Aktif') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('is_active')
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
                                value="{{ old('email', $tenagaKerja->email ?? '') }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                placeholder="contoh@email.com">
                            @error('email')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="no_telpon" class="text-sm font-medium text-zinc-700">No. Telepon</label>
                            <input type="text" id="no_telpon" name="no_telpon"
                                value="{{ old('no_telpon', $tenagaKerja->no_telpon ?? '') }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
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
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                                @foreach ($kecamatans as $kecamatan)
                                    @php
                                        $desaByKecamatan = $desas->where('kecamatan_id', $kecamatan->id);
                                    @endphp
                                    @if ($desaByKecamatan->isNotEmpty())
                                        <optgroup label="{{ $kecamatan->nama }}">
                                            @foreach ($desaByKecamatan as $desa)
                                                <option value="{{ $desa->id }}" @selected(old('desa_id', $tenagaKerja->desa_id ?? '') == $desa->id)>
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
                                value="{{ old('kode_pos', $tenagaKerja->kode_pos ?? '') }}"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
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
                            class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                            placeholder="Nama jalan, RT/RW, dsb." required>{{ old('alamat_lengkap', $tenagaKerja->alamat_lengkap ?? '') }}</textarea>
                        @error('alamat_lengkap')
                            <p class="text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </section>

                <section class="space-y-4 bg-white p-6">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900">Relasi Penempatan</h2>
                        <p class="text-sm text-zinc-500">Hubungkan CPMI dengan pendidikan, perusahaan, dan negara tujuan.
                        </p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1">
                            <label for="pendidikan_id" class="text-sm font-medium text-zinc-700">Pendidikan Terakhir <span
                                    class="text-red-500">*</span></label>
                            <select id="pendidikan_id" name="pendidikan_id"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                                <option value="">Pilih Pendidikan</option>
                                @foreach ($pendidikans as $pendidikan)
                                    <option value="{{ $pendidikan->id }}" @selected(old('pendidikan_id', $tenagaKerja->pendidikan_id ?? '') == $pendidikan->id)>
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
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                                <option value="">Pilih Perusahaan</option>
                                @foreach ($perusahaans as $perusahaan)
                                    <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id', $tenagaKerja->perusahaan_id ?? '') == $perusahaan->id)>
                                        {{ $perusahaan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('perusahaan_id')
                                <p class="text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- agency --}}
                        <div class="space-y-1">
                            <label for="agency_id" class="text-sm font-medium text-zinc-700">Agency Penempatan <span
                                    class="text-red-500">*</span></label>
                            <select id="agency_id" name="agency_id"
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                                <option value="">Pilih Agency</option>
                                @foreach ($agencies as $agency)
                                    <option value="{{ $agency->id }}" @selected(old('agency_id', $tenagaKerja->agency_id ?? '') == $agency->id)>
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
                                class="w-full rounded border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                required>
                                <option value="">Pilih Negara</option>
                                @foreach ($negaras as $negara)
                                    <option value="{{ $negara->id }}" @selected(old('negara_id', $tenagaKerja->negara_id ?? '') == $negara->id)>
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
            </form>
        </div>
    </section>
@endsection
