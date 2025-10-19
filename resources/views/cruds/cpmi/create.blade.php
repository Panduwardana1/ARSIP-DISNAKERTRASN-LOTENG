@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Tambah Tenaga Kerja')
@section('titleContent', 'Tambah Data Tenaga Kerja')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-full space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="font-inter text-xl font-semibold text-zinc-800">Formulir Pendaftaran CPMI</h2>
                    <p class="text-sm text-zinc-500">Lengkapi seluruh informasi berikut untuk mendaftarkan calon pekerja
                        migran.</p>
                </div>
                <a href="{{ route('sirekap.cpmi.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-blue-400 hover:text-blue-600">
                    <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                    Kembali
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

            <form action="{{ route('sirekap.cpmi.store') }}" method="POST"
                class="rounded-xl border border-zinc-100 bg-white">
                @csrf
                <div class="space-y-10 p-6 md:p-10">
                    <section class="space-y-6">
                        <div class="space-y-1">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Data Pribadi</h3>
                            <p class="text-sm text-zinc-500">Informasi dasar calon tenaga kerja.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Nama Lengkap
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nama')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                NIK
                                <input type="text" name="nik" value="{{ old('nik') }}" minlength="16" maxlength="16"
                                    inputmode="numeric" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nik')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <div class="md:col-span-2">
                                <span class="block text-sm font-medium text-zinc-700">Jenis Kelamin</span>
                                <div class="mt-2 grid grid-cols-2 gap-3 md:max-w-md">
                                    @foreach (['Laki-laki', 'Perempuan'] as $gender)
                                        <label
                                            class="flex cursor-pointer items-center justify-between rounded-2xl border px-4 py-2 text-sm transition {{ old('gender', 'Laki-laki') === $gender ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-zinc-200 text-zinc-600 hover:border-blue-400 hover:text-blue-600' }}">
                                            <span>{{ $gender }}</span>
                                            <input type="radio" name="gender" value="{{ $gender }}"
                                                class="h-4 w-4 border-zinc-300 text-blue-500 focus:ring-blue-500"
                                                {{ old('gender', 'Laki-laki') === $gender ? 'checked' : '' }}>
                                        </label>
                                    @endforeach
                                </div>
                                @error('gender')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="block text-sm font-medium text-zinc-700">
                                Tempat Lahir
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('tempat_lahir')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Tanggal Lahir
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('tanggal_lahir')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="space-y-1">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Kontak & Domisili</h3>
                            <p class="text-sm text-zinc-500">Detail tempat tinggal dan informasi kontak.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Email (Opsional)
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition placeholder:text-zinc-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
                                    placeholder="nama@email.com">
                                @error('email')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Desa/Kelurahan
                                <input type="text" name="desa" value="{{ old('desa') }}" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('desa')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Kecamatan
                                <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('kecamatan')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                Alamat Lengkap
                                <textarea name="alamat_lengkap" rows="4" required
                                    class="mt-1 w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
                                    placeholder="Tulis alamat sesuai KTP atau domisili saat ini">{{ old('alamat_lengkap') }}</textarea>
                                @error('alamat_lengkap')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="space-y-1">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Kualifikasi & Penempatan</h3>
                            <p class="text-sm text-zinc-500">Pilih data pendidikan dan lowongan terkait.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Pendidikan Terakhir
                                <select name="pendidikan_id" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="" disabled {{ old('pendidikan_id') ? '' : 'selected' }}>Pilih pendidikan
                                        terakhir</option>
                                    @forelse (($pendidikans ?? []) as $pendidikan)
                                        <option value="{{ $pendidikan->id }}"
                                            {{ (string) old('pendidikan_id') === (string) $pendidikan->id ? 'selected' : '' }}>
                                            {{ $pendidikan->nama }}
                                            @if ($pendidikan->level)
                                                - {{ $pendidikan->level }}
                                            @endif
                                        </option>
                                    @empty
                                        <option value="" disabled>Data pendidikan belum tersedia</option>
                                    @endforelse
                                </select>
                                @error('pendidikan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Lowongan Aktif
                                <select name="lowongan_id" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="" disabled {{ old('lowongan_id') ? '' : 'selected' }}>Pilih lowongan tujuan
                                    </option>
                                    @forelse (($lowongans ?? []) as $lowongan)
                                        <option value="{{ $lowongan->id }}"
                                            {{ (string) old('lowongan_id') === (string) $lowongan->id ? 'selected' : '' }}>
                                            {{ $lowongan->nama }}
                                            @if (optional($lowongan->perusahaan)->nama)
                                                &mdash; {{ $lowongan->perusahaan->nama }}
                                            @endif
                                            @if (optional($lowongan->agensi)->nama)
                                                (Agensi: {{ $lowongan->agensi->nama }})
                                            @endif
                                        </option>
                                    @empty
                                        <option value="" disabled>Data lowongan belum tersedia</option>
                                    @endforelse
                                </select>
                                @error('lowongan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>
                </div>

                <div class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-10">
                    <button type="reset"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-300">
                        Reset Formulir
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md border border-blue-500 bg-blue-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-1">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
