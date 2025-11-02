@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Tambah Tenaga Kerja')
@section('titlePageContent', 'Tambah Data CPMI')

@section('content')
    <div class="max-w-4xl rounded-xl border p-6 bg-white font-inter">
        <form action="{{ route('sirekap.tenaga-kerja.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700">Nama</label>
                    <input type="text" name="nama" id="nama"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-semibold text-slate-700">NIK</label>
                    <input type="text" name="nik" id="nik" maxlength="16"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nik') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('nik') }}" required>
                    @error('nik')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                    <select name="gender" id="gender"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('gender') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih --</option>
                        <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                        <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email (Opsional)</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="tempat_lahir" class="block text-sm font-semibold text-slate-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tempat_lahir') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('tempat_lahir') }}" required>
                    @error('tempat_lahir')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-semibold text-slate-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_lahir') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="alamat_lengkap" class="block text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3"
                    class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('alamat_lengkap') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                    required>{{ old('alamat_lengkap') }}</textarea>
                @error('alamat_lengkap')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2" data-dependant-desa>
                <div>
                    <label for="kecamatan_id" class="block text-sm font-semibold text-slate-700">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" data-role="kecamatan"
                        data-initial="{{ old('kecamatan_id') }}"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kecamatan_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" @selected(old('kecamatan_id') == $kecamatan->id)>
                                {{ $kecamatan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="desa_id" class="block text-sm font-semibold text-slate-700">Desa</label>
                    <select name="desa_id" id="desa_id" data-role="desa" data-placeholder="-- Pilih Desa --"
                        data-initial="{{ old('desa_id') }}"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('desa_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Desa --</option>
                        @foreach ($desas as $desa)
                            <option value="{{ $desa->id }}" data-kecamatan="{{ $desa->kecamatan_id ?? '' }}"
                                @selected(old('desa_id') == $desa->id)>
                                {{ $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('desa_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Pilih kecamatan terlebih dahulu untuk menampilkan daftar desa.</p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label for="pendidikan_id" class="block text-sm font-semibold text-slate-700">Pendidikan</label>
                    <select name="pendidikan_id" id="pendidikan_id"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('pendidikan_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach ($pendidikans as $pendidikan)
                            <option value="{{ $pendidikan->id }}" @selected(old('pendidikan_id') == $pendidikan->id)>
                                {{ $pendidikan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('pendidikan_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="perusahaan_id" class="block text-sm font-semibold text-slate-700">Perusahaan</label>
                    <select name="perusahaan_id" id="perusahaan_id"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('perusahaan_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id') == $perusahaan->id)>
                                {{ $perusahaan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('perusahaan_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="agency_id" class="block text-sm font-semibold text-slate-700">Agency</label>
                    <select name="agency_id" id="agency_id"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('agency_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Agency --</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}" @selected(old('agency_id') == $agency->id)>
                                {{ $agency->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('agency_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                    class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.__desaSelectScriptLoaded) {
                return;
            }
            window.__desaSelectScriptLoaded = true;
            document.querySelectorAll('[data-dependant-desa]').forEach(function (container) {
                if (container.dataset.initialized === 'true') {
                    return;
                }
                container.dataset.initialized = 'true';

                const kecSelect = container.querySelector('[data-role="kecamatan"]');
                const desaSelect = container.querySelector('[data-role="desa"]');
                if (!kecSelect || !desaSelect) {
                    return;
                }

                const placeholderOption = desaSelect.querySelector('option[value=""]');
                const allOptions = Array.from(desaSelect.options).filter(option => option.value !== '');

                const getMatches = (kecamatanId) => {
                    if (!kecamatanId) {
                        return [];
                    }

                    return allOptions.filter(option => String(option.dataset.kecamatan || '') === String(kecamatanId));
                };

                const syncOptions = () => {
                    const selectedKec = kecSelect.value;
                    const matches = getMatches(selectedKec);

                    allOptions.forEach(option => {
                        const match = matches.includes(option);
                        option.hidden = !match;
                        option.disabled = !match;
                    });

                    if (!selectedKec || matches.length === 0) {
                        desaSelect.value = '';
                    } else if (!matches.some(option => option.value === desaSelect.value)) {
                        desaSelect.value = '';
                    }

                    desaSelect.disabled = !selectedKec || matches.length === 0;
                    if (placeholderOption) {
                        placeholderOption.disabled = desaSelect.disabled;
                        placeholderOption.hidden = false;
                    }
                };

                let initialKecamatan = kecSelect.dataset.initial || kecSelect.value || '';
                const initialDesa = desaSelect.dataset.initial || desaSelect.value || '';

                if (!initialKecamatan && initialDesa) {
                    const relatedOption = allOptions.find(option => option.value === initialDesa);
                    if (relatedOption) {
                        initialKecamatan = relatedOption.dataset.kecamatan || '';
                    }
                }

                if (initialKecamatan) {
                    kecSelect.value = initialKecamatan;
                }

                syncOptions();

                if (initialDesa) {
                    const matches = getMatches(kecSelect.value);
                    if (matches.some(option => option.value === initialDesa)) {
                        desaSelect.value = initialDesa;
                        desaSelect.disabled = false;
                    }
                }

                if (!kecSelect.value) {
                    desaSelect.disabled = true;
                }

                kecSelect.addEventListener('change', function () {
                    syncOptions();
                });
            });
        });
    </script>
@endpush
