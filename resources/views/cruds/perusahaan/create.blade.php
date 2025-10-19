@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Perusahaan | Tambah Data')
@section('titleContent', 'Tambah Data Perusahaan')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-4xl space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold text-zinc-800">Formulir Perusahaan Penempatan</h2>
                    <p class="text-sm text-zinc-500">Lengkapi profil perusahaan penempatan tenaga kerja untuk digunakan pada modul SIREKAP.</p>
                </div>
                <a href="{{ route('sirekap.perusahaan.index') }}"
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

            <form action="{{ route('sirekap.perusahaan.store') }}" method="POST" enctype="multipart/form-data"
                class="rounded-xl border border-zinc-100 bg-white shadow-sm">
                @csrf
                <div class="space-y-10 p-6 md:p-10">
                    <section class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-800">Informasi Perusahaan</h3>
                            <p class="text-sm text-zinc-500">Data dasar perusahaan penempatan.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Nama Perusahaan
                                <input type="text" name="nama" value="{{ old('nama') }}" required
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nama')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="block text-sm font-medium text-zinc-700">
                                Nama Pimpinan
                                <input type="text" name="nama_pimpinan" value="{{ old('nama_pimpinan') }}"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nama_pimpinan')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-800">Kontak & Branding</h3>
                            <p class="text-sm text-zinc-500">Informasi komunikasi yang dapat dihubungi beserta identitas visual.</p>
                        </div>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <label class="block text-sm font-medium text-zinc-700">
                                Email
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('email')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="block text-sm font-medium text-zinc-700">
                                Nomor HP
                                <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                @error('nomor_hp')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="md:col-span-2 block text-sm font-medium text-zinc-700">
                                Alamat
                                <textarea name="alamat" rows="3"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                @enderror
                            </label>
                            {{--todo image --}}
                            <label class="block text-sm font-medium text-zinc-700">
                                Upload Logo (opsional)
                                <input type="file" name="gambar"
                                    class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 transition file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1 file:text-sm file:font-medium file:text-zinc-700 hover:file:bg-zinc-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                                <span class="mt-1 block text-xs text-zinc-400">Format gambar (JPG/JPEG, PNG, atau SVG) maksimal 2 MB.</span>
                                @error('gambar')
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
