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
                <a href="{{ route('sirekap.tenaga-kerja.index') }}"
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

            <form action="{{ route('sirekap.tenaga-kerja.store') }}" method="POST"
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
                                <input type="text" name="nik" value="{{ old('nik') }}" minlength="16"
                                    maxlength="16" inputmode="numeric" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nik')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <div class="md:col-span-2">
                                <p class="text-sm font-medium">Gender <span class="text-red-600">*</span></p>
                                <div class="mt-1 flex gap-6">
                                    @foreach (\App\Models\TenagaKerja::GENDERS as $g)
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" name="gender" value="{{ $g }}"
                                                class="border rounded" @checked(old('gender', $tenagaKerja->gender ?? '') === $g) required>
                                            <span>{{ $g }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('gender')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
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
                                <select name="pendidikan_id" class="mt-1 w-full border rounded px-3 py-2">
                                    <option value="" disabled
                                        {{ old('pendidikan_id', $tenagaKerja->pendidikan_id ?? '') === '' ? 'selected' : '' }}>
                                        -- Pilih Pendidikan --
                                    </option>

                                    @forelse ($pendidikans as $p)
                                        <option value="{{ $p->id }}" @selected(old('pendidikan_id', $tenagaKerja->pendidikan_id ?? '') == $p->id)>
                                            {{ $p->nama }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada data pendidikan</option>
                                    @endforelse
                                </select>
                                @error('pendidikan_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </label>

                            @php
                                $selectedLowongan = $lowongans->firstWhere('id', (int) old('lowongan_id', $tenagaKerja->lowongan_id ?? null));
                                $initialPerusahaan = $selectedLowongan?->perusahaan?->nama ?? '';
                                $initialAgensi = $selectedLowongan?->agensi?->nama ?? '';
                            @endphp
                            <label class="block text-sm font-medium text-zinc-700"
                                x-data="{
                                    selectedPerusahaan: @js($initialPerusahaan),
                                    selectedAgensi: @js($initialAgensi),
                                    sync(event) {
                                        const option = event.target.selectedOptions[0];
                                        this.selectedPerusahaan = option?.dataset.perusahaan || '';
                                        this.selectedAgensi = option?.dataset.agensi || '';
                                    }
                                }">
                                Lowongan Aktif
                                <select name="lowongan_id" required x-on:change="sync($event)" x-ref="lowongan"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="" disabled
                                        {{ old('lowongan_id', $tenagaKerja->lowongan_id ?? '') === '' ? 'selected' : '' }}>
                                        Pilih
                                        lowongan
                                    </option>

                                    @forelse ($lowongans as $items)
                                        <option value="{{ $items->id }}" @selected(old('lowongan_id', $tenagaKerja->lowongan_id ?? '') == $items->id)
                                            data-perusahaan="{{ $items->perusahaan->nama ?? '' }}"
                                            data-agensi="{{ $items->agensi->nama ?? '' }}">
                                            {{ $items->nama }}
                                            @if ($items->perusahaan?->nama || $items->agensi?->nama)
                                                - {{ $items->perusahaan->nama ?? 'Tanpa P3MI' }} |
                                                {{ $items->agensi->nama ?? 'Tanpa Agensi' }}
                                            @endif
                                        </option>
                                    @empty
                                        <option value="" disabled>Data lowongan belum tersedia</option>
                                    @endforelse
                                </select>
                                <div class="mt-2 space-y-1 text-xs text-zinc-500">
                                    <p>P3MI:
                                        <span x-text="selectedPerusahaan || '-'" class="font-medium text-zinc-700">
                                            {{ $initialPerusahaan !== '' ? $initialPerusahaan : '-' }}
                                        </span>
                                    </p>
                                    <p>Agensi:
                                        <span x-text="selectedAgensi || '-'" class="font-medium text-zinc-700">
                                            {{ $initialAgensi !== '' ? $initialAgensi : '-' }}
                                        </span>
                                    </p>
                                </div>
                                @error('lowongan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>
                </div>

                <div
                    class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-10">
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
