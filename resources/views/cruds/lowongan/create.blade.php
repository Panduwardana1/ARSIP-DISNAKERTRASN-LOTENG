@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Lowongan | Tambah')
@section('titleContent', 'Tambah Lowongan Baru')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-3xl space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold text-zinc-800">Form Lowongan</h2>
                    <p class="text-sm text-zinc-500">Lengkapi data lowongan kerja untuk penempatan tenaga kerja.</p>
                </div>
                <a href="{{ route('sirekap.lowongan.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-blue-400 hover:text-blue-600">
                    <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    <p class="font-semibold">Periksa kembali data berikut:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sirekap.lowongan.store') }}" method="POST"
                class="rounded-xl border border-zinc-100 bg-white shadow-sm">
                @csrf

                <div class="space-y-10 p-6 md:p-8">
                    <section class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-800">Informasi Utama</h3>
                            <p class="text-sm text-zinc-500">Detail umum lowongan kerja.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <label class="block text-sm font-medium text-zinc-700">
                                Nama Lowongan <span class="text-rose-500">*</span>
                                <input type="text" name="nama" value="{{ old('nama') }}" maxlength="150" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nama')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Agensi Penempatan <span class="text-rose-500">*</span>
                                <select name="agensi_id" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="">Pilih Agensi</option>
                                    @foreach ($daftarAgensi as $id => $nama)
                                        <option value="{{ $id }}" @selected(old('agensi_id') == $id)>{{ $nama }}</option>
                                    @endforeach
                                </select>
                                @error('agensi_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Perusahaan <span class="text-rose-500">*</span>
                                <select name="perusahaan_id" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach ($daftarPerusahaan as $id => $nama)
                                        <option value="{{ $id }}" @selected(old('perusahaan_id') == $id)>{{ $nama }}</option>
                                    @endforeach
                                </select>
                                @error('perusahaan_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Destinasi <span class="text-rose-500">*</span>
                                <select name="destinasi_id" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="">Pilih Destinasi</option>
                                    @foreach ($daftarDestinasi as $id => $nama)
                                        <option value="{{ $id }}" @selected(old('destinasi_id') == $id)>{{ $nama }}</option>
                                    @endforeach
                                </select>
                                @error('destinasi_id')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Nomor Kontrak Kerja <span class="text-rose-500">*</span>
                                <input type="number" name="kontrak_kerja" value="{{ old('kontrak_kerja') }}" min="1" max="65535"
                                    required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('kontrak_kerja')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Status Lowongan <span class="text-rose-500">*</span>
                                <select name="is_aktif" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    @foreach ($statusOptions as $value => $label)
                                        <option value="{{ $value }}" @selected(old('is_aktif', 'aktif') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('is_aktif')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                Catatan
                                <textarea name="catatan" rows="3" maxlength="255"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>
                </div>

                <div
                    class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-8">
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
