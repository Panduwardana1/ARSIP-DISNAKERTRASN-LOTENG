@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI | Ubah')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Perusahaan</h1>
            <p class="mt-1 text-sm text-zinc-600">Lengkapi informasi terbaru dan unggah logo baru bila diperlukan.</p>
        </div>

        @if ($errors->has('message'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('message') }}
            </div>
        @endif

        <form action="{{ route('sirekap.perusahaan.update', $perusahaan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-zinc-700">
                    Nama Perusahaan <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $perusahaan->nama) }}"
                    maxlength="100"
                    required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                >
                @error('nama')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="pimpinan" class="block text-sm font-medium text-zinc-700">
                        Nama Pimpinan
                    </label>
                    <input
                        type="text"
                        id="pimpinan"
                        name="pimpinan"
                        value="{{ old('pimpinan', $perusahaan->pimpinan) }}"
                        maxlength="100"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('pimpinan')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700">
                        Email Perusahaan
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $perusahaan->email) }}"
                        maxlength="100"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-zinc-700">
                    Alamat Operasional
                </label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="4"
                    placeholder="Tuliskan alamat lengkap perusahaan."
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="gambar" class="block text-sm font-medium text-zinc-700">
                    Logo/Identitas Visual
                </label>
                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept=".png,.jpg,.jpeg"
                    class="w-full rounded-md border border-dashed border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                >
                <p class="text-xs text-zinc-500">Format PNG, JPG, atau JPEG (maks. 2 MB).</p>
                @error('gambar')
                    <p class="text-sm text-rose-600">{{ $message }}</p>
                @enderror

                @if ($perusahaan->gambar)
                    <div class="flex items-center gap-3 rounded-md border border-zinc-200 bg-zinc-50 p-3 text-sm text-zinc-600">
                        <x-heroicon-o-photo class="h-5 w-5 text-indigo-500" />
                        <span>File saat ini: {{ $perusahaan->gambar }}</span>
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('sirekap.perusahaan.index') }}"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
