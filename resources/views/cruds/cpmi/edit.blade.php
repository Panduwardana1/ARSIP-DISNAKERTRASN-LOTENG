@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Ubah Tenaga Kerja')
@section('titleContent', 'Ubah Data Tenaga Kerja')

@section('content')
    <div class="h-full overflow-y-auto bg-slate-50 px-6 py-6">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="font-inter text-xl font-semibold text-zinc-800">Perbarui Informasi CPMI</h2>
                    <p class="text-sm text-zinc-500">Periksa dan sesuaikan data jika terdapat perubahan.</p>
                </div>
                <a href="{{ route('sirekap.cpmi.show', $tenagaKerja) }}"
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
                    $tenagaKerja->tanggal_lahir
                        ? \Illuminate\Support\Carbon::parse($tenagaKerja->tanggal_lahir)->format('Y-m-d')
                        : null,
                );
            @endphp

            <form action="{{ route('sirekap.cpmi.update', $tenagaKerja) }}" method="POST"
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
                                    @foreach (['Laki-laki', 'Perempuan'] as $gender)
                                        <label
                                            class="flex cursor-pointer items-center justify-between rounded-2xl border px-4 py-2 text-sm transition {{ old('gender', $tenagaKerja->gender) === $gender ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-zinc-200 text-zinc-600 hover:border-amber-400 hover:text-amber-600' }}">
                                            <span>{{ $gender }}</span>
                                            <input type="radio" name="gender" value="{{ $gender }}"
                                                class="h-4 w-4 border-zinc-300 text-amber-500 focus:ring-amber-500"
                                                {{ old('gender', $tenagaKerja->gender) === $gender ? 'checked' : '' }}>
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
                                <input type="email" name="email" value="{{ old('email', $tenagaKerja->email) }}"
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition placeholder:text-zinc-400 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30"
                                    placeholder="nama@email.com">
                                @error('email')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Desa/Kelurahan
                                <input type="text" name="desa" value="{{ old('desa', $tenagaKerja->desa) }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('desa')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Kecamatan
                                <input type="text" name="kecamatan" value="{{ old('kecamatan', $tenagaKerja->kecamatan) }}" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                @error('kecamatan')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
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
                            <p class="text-sm text-zinc-500">Pilih data pendidikan dan lowongan terkait.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Pendidikan Terakhir
                                <select name="pendidikan_id" required
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="" disabled {{ old('pendidikan_id', $tenagaKerja->pendidikan_id) ? '' : 'selected' }}>Pilih pendidikan
                                        terakhir</option>
                                    @forelse ($pendidikans as $pendidikan)
                                        <option value="{{ $pendidikan->id }}"
                                            {{ (string) old('pendidikan_id', $tenagaKerja->pendidikan_id) === (string) $pendidikan->id ? 'selected' : '' }}>
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
                                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                                    <option value="" disabled {{ old('lowongan_id', $tenagaKerja->lowongan_id) ? '' : 'selected' }}>Pilih lowongan tujuan
                                    </option>
                                    @forelse ($lowongans as $lowongan)
                                        <option value="{{ $lowongan->id }}"
                                            {{ (string) old('lowongan_id', $tenagaKerja->lowongan_id) === (string) $lowongan->id ? 'selected' : '' }}>
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
                    <a href="{{ route('sirekap.cpmi.show', $tenagaKerja) }}"
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
