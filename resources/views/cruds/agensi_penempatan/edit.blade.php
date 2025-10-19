@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agensi Penempatan | Ubah Data')
@section('titleContent', 'Perbarui Data Agensi')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-4xl space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold text-zinc-800">Ubah Agensi Penempatan</h2>
                    <p class="text-sm text-zinc-500">
                        Perbarui data agensi untuk memastikan informasi tetap akurat dan terkini.
                    </p>
                </div>
                <a href="{{ route('sirekap.agensi.show', $agensi) }}"
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

            <form action="{{ route('sirekap.agensi.update', $agensi) }}" method="POST" enctype="multipart/form-data"
                class="rounded-xl border border-zinc-100 bg-white shadow-sm">
                @csrf
                @method('PUT')

                <div class="space-y-10 p-6 md:p-10">
                    <section class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-800">Informasi Utama</h3>
                            <p class="text-sm text-zinc-500">Perbarui data dasar agensi penempatan.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5">
                            <label class="block text-sm font-medium text-zinc-700">
                                Nama Agensi <span class="text-rose-500">*</span>
                                <input type="text" name="nama" value="{{ old('nama', $agensi->nama) }}" maxlength="150"
                                    required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nama')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Lokasi
                                <textarea name="lokasi" rows="3" maxlength="1000"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
                                    placeholder="Tuliskan alamat atau kota operasional">{{ old('lokasi', $agensi->lokasi) }}</textarea>
                                @error('lokasi')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-800">Status & Logo</h3>
                            <p class="text-sm text-zinc-500">Kelola status operasional serta logo agensi.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Status Aktif <span class="text-rose-500">*</span>
                                <select name="is_aktif" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                    <option value="aktif" @selected(old('is_aktif', $agensi->is_aktif) === 'aktif')>Aktif</option>
                                    <option value="non_aktif" @selected(old('is_aktif', $agensi->is_aktif) === 'non_aktif')>Non Aktif</option>
                                </select>
                                @error('is_aktif')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block text-sm font-medium text-zinc-700">
                                Logo Agensi (opsional)
                                <input type="file" name="gambar"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 transition file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1 file:text-sm file:font-medium file:text-zinc-700 hover:file:bg-zinc-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                <span class="mt-1 block text-xs text-zinc-400">Format JPG, JPEG, PNG, atau WEBP maksimal 2
                                    MB.</span>
                                @error('gambar')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>

                        @if ($agensi->gambar_url)
                            <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4 text-sm text-zinc-600">
                                <p class="font-medium text-zinc-700">Logo saat ini</p>
                                <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                                    <img src="{{ $agensi->gambar_url }}" alt="Logo {{ $agensi->nama }}"
                                        class="h-14 w-14 rounded-md border border-zinc-200 object-cover"
                                        onerror="this.style.display='none'">
                                    <label class="inline-flex items-center gap-2 text-xs text-zinc-500">
                                        <input type="checkbox" name="remove_gambar" value="1"
                                            class="h-4 w-4 rounded border-zinc-300 text-blue-500 focus:ring-blue-400"
                                            @checked(old('remove_gambar'))>
                                        Hapus logo saat ini
                                    </label>
                                </div>
                            </div>
                        @endif
                    </section>
                </div>

                <div
                    class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-10">
                    <a href="{{ route('sirekap.agensi.show', $agensi) }}"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md border border-blue-500 bg-blue-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:ring-offset-1">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
