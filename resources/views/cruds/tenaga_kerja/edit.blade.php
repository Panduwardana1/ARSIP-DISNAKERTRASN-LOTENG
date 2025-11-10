{{-- @extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Ubah Tenaga Kerja')
@section('titleContent', 'Ubah Data Tenaga Kerja')

<x-wal-session />

@section('content')
    <div class="h-full overflow-y-auto bg-slate-50 px-6 py-6">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="font-inter text-xl font-semibold text-zinc-800">Perbarui Informasi CPMI</h2>
                    <p class="text-sm text-zinc-500">Periksa dan sesuaikan data jika terdapat perubahan.</p>
                </div>
                <a href="{{ route('sirekap.tenaga-kerja.show', $tenagaKerja) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-amber-400 hover:text-amber-600">
                    <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                    Kembali ke detail
                </a>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    <p class="font-semibold">Harap periksa ulang data yang Anda masukkan:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $tanggalLahirValue = old(
                    'tanggal_lahir',
                    $tenagaKerja->tanggal_lahir ? $tenagaKerja->tanggal_lahir->format('Y-m-d') : null,
                );
                $currentKecamatanId = old('kecamatan_id', optional($tenagaKerja->desa)->kecamatan_id);
            @endphp

            <form action="{{ route('sirekap.tenaga-kerja.update', $tenagaKerja) }}" method="POST"
                class="rounded-3xl border border-zinc-100 bg-white shadow-sm">
                @csrf
                @method('PUT')
                <div class="space-y-10 p-6 md:p-10">
                    <section class="space-y-6">
                        <div class="space-y-1">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Data Pribadi</h3>
                            <p class="text-sm text-zinc-500">Informasi dasar calon tenaga kerja.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Nama Lengkap
                                <input type="text" name="nama" value="{{ old('nama', $tenagaKerja->nama) }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('nama')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                NIK
                                <input type="text" name="nik" value="{{ old('nik', $tenagaKerja->nik) }}" minlength="16" maxlength="16"
                                    inputmode="numeric" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('nik')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <div class="md:col-span-2">
                                <span class="block text-sm font-medium text-zinc-700">Jenis Kelamin</span>
                                <div class="mt-2 grid grid-cols-2 gap-3 md:max-w-md">
                                    @foreach (\App\Models\TenagaKerja::GENDERS as $value => $label)
                                        @php
                                            $isChecked = old('gender', $tenagaKerja->gender) === $value;
                                        @endphp
                                        <label
                                            class="flex cursor-pointer items-center justify-between rounded-2xl border px-4 py-2 text-sm transition {{ $isChecked ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-zinc-200 text-zinc-600 hover:border-amber-400 hover:text-amber-600' }}">
                                            <span>{{ $label }}</span>
                                            <input type="radio" name="gender" value="{{ $value }}" @checked($isChecked)
                                                class="h-4 w-4 border-zinc-300 text-amber-500 focus:ring-amber-500">
                                        </label>
                                    @endforeach
                                </div>
                                @error('gender')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="block text-sm font-medium text-zinc-700">
                                Tempat Lahir
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $tenagaKerja->tempat_lahir) }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('tempat_lahir')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Tanggal Lahir
                                <input type="date" name="tanggal_lahir" value="{{ $tanggalLahirValue }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('tanggal_lahir')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                Alamat Email
                                <input type="email" name="email" value="{{ old('email', $tenagaKerja->email) }}"
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30"
                                    placeholder="contoh: nama@email.com">
                                @error('email')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="space-y-1">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Domisili</h3>
                            <p class="text-sm text-zinc-500">Lengkapi informasi lokasi domisili saat ini.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2" data-dependant-desa>
                            <label class="block text-sm font-medium text-zinc-700">
                                Kecamatan
                                <select name="kecamatan_id" data-role="kecamatan"
                                    data-initial="{{ $currentKecamatanId }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="">Pilih kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}"
                                            {{ (string) $currentKecamatanId === (string) $kecamatan->id ? 'selected' : '' }}>
                                            {{ $kecamatan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Desa/Kelurahan
                                <select name="desa_id" data-role="desa" data-placeholder="Pilih desa/kelurahan"
                                    data-initial="{{ old('desa_id', $tenagaKerja->desa_id) }}" required
                                    data-disabled-label="Pilih kecamatan terlebih dahulu" @disabled(! $currentKecamatanId)
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="">Pilih desa/kelurahan</option>
                                    @foreach ($desas as $desa)
                                        <option value="{{ $desa->id }}" data-kecamatan="{{ $desa->kecamatan_id }}"
                                            {{ (string) old('desa_id', $tenagaKerja->desa_id) === (string) $desa->id ? 'selected' : '' }}>
                                            {{ $desa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('desa_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                                <span class="mt-1 block text-xs text-zinc-500">Pilih kecamatan untuk menampilkan daftar desa.</span>
                            </label>

                            <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                Alamat Lengkap
                                <textarea name="alamat_lengkap" rows="4" required
                                    class="mt-1 w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30"
                                    placeholder="Tulis alamat sesuai KTP atau domisili saat ini">{{ old('alamat_lengkap', $tenagaKerja->alamat_lengkap) }}</textarea>
                                @error('alamat_lengkap')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="space-y-1">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Kualifikasi & Penempatan</h3>
                            <p class="text-sm text-zinc-500">Pilih data pendidikan serta relasi perusahaan dan agency.</p>
                        </div>
                        <div class="grid gap-5 md:grid-cols-3">
                            <label class="block text-sm font-medium text-zinc-700">
                                Pendidikan Terakhir
                                <select name="pendidikan_id" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="" disabled {{ old('pendidikan_id', $tenagaKerja->pendidikan_id) ? '' : 'selected' }}>Pilih pendidikan
                                        terakhir</option>
                                    @foreach ($pendidikans as $pendidikan)
                                        <option value="{{ $pendidikan->id }}"
                                            {{ (string) old('pendidikan_id', $tenagaKerja->pendidikan_id) === (string) $pendidikan->id ? 'selected' : '' }}>
                                            {{ $pendidikan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pendidikan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Perusahaan
                                <select name="perusahaan_id" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="" disabled {{ old('perusahaan_id', $tenagaKerja->perusahaan_id) ? '' : 'selected' }}>Pilih perusahaan</option>
                                    @foreach ($perusahaans as $perusahaan)
                                        <option value="{{ $perusahaan->id }}"
                                            {{ (string) old('perusahaan_id', $tenagaKerja->perusahaan_id) === (string) $perusahaan->id ? 'selected' : '' }}>
                                            {{ $perusahaan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('perusahaan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Agency
                                <select name="agency_id" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="" disabled {{ old('agency_id', $tenagaKerja->agency_id) ? '' : 'selected' }}>Pilih agency</option>
                                    @foreach ($agencies as $agency)
                                        <option value="{{ $agency->id }}"
                                            {{ (string) old('agency_id', $tenagaKerja->agency_id) === (string) $agency->id ? 'selected' : '' }}>
                                            {{ $agency->nama }} {{ $agency->country ? '(' . $agency->country . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agency_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="md:col-span-3 block text-sm font-medium text-zinc-700">
                                Negara Penempatan
                                <input type="text" name="negara" value="{{ old('negara', $tenagaKerja->negara) }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('negara')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>
                </div>

                <div class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-10">
                    <a href="{{ route('sirekap.tenaga-kerja.show', $tenagaKerja) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-transparent bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-300">
                        Batalkan
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl border border-amber-500 bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @include('components.dependant-desa-script')
@endpush --}}
