@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI | Ubah')
@section('titlePageContent', 'Ubah Data P3MI')

@section('content')
    <div class="flex h-full flex-col font-inter">
        <main class="flex-1 px-4 py-6">
            <div class="mx-auto max-w-4xl space-y-6">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                    <div class="space-y-1">
                        <h2 class="text-xl font-semibold text-zinc-900">Perbarui Profil Perusahaan</h2>
                        <p class="text-sm text-zinc-500">
                            Sesuaikan informasi perusahaan untuk menjaga data tetap akurat.
                        </p>
                    </div>
                    <a href="{{ route('sirekap.perusahaan.show', $perusahaan) }}"
                        class="inline-flex items-center justify-center rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                        <x-heroicon-o-eye class="mr-2 h-4 w-4" />
                        Lihat detail
                    </a>
                </div>

                @if ($errors->any())
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        <p class="font-semibold">Periksa kembali data berikut:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('sirekap.perusahaan.update', $perusahaan) }}" method="POST"
                    enctype="multipart/form-data" class="rounded-xl border border-zinc-100 bg-white shadow-sm">
                    @csrf
                    @method('PUT')
                    <div class="space-y-10 p-6 md:p-10">
                        <section class="space-y-6">
                            <header>
                                <h3 class="text-lg font-semibold text-zinc-900">Informasi Perusahaan</h3>
                                <p class="text-sm text-zinc-500">Data dasar dan relasi ke agency penempatan.</p>
                            </header>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <label class="block text-sm font-medium text-zinc-700">
                                    Agency Penempatan
                                    <select name="agency_id" required
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                        <option value="">-- Pilih Agency --</option>
                                        @foreach ($agencies as $agency)
                                            <option value="{{ $agency->id }}"
                                                @selected(old('agency_id', $perusahaan->agency_id) == $agency->id)>
                                                {{ $agency->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('agency_id')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>
                                <label class="block text-sm font-medium text-zinc-700">
                                    Nama Perusahaan
                                    <input type="text" name="nama" value="{{ old('nama', $perusahaan->nama) }}" required
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                    @error('nama')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>
                                <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                    Nama Pimpinan (Opsional)
                                    <input type="text" name="pimpinan" value="{{ old('pimpinan', $perusahaan->pimpinan) }}"
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                    @error('pimpinan')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                        </section>

                        <section class="space-y-6">
                            <header>
                                <h3 class="text-lg font-semibold text-zinc-900">Kontak & Identitas</h3>
                                <p class="text-sm text-zinc-500">Informasi komunikasi serta alamat perusahaan.</p>
                            </header>
                            <div class="grid grid-cols-1 gap-5">
                                <label class="block text-sm font-medium text-zinc-700 md:grid md:grid-cols-2 md:gap-5">
                                    <span>Email (Opsional)</span>
                                    <input type="email" name="email" value="{{ old('email', $perusahaan->email) }}"
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                    @error('email')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block text-sm font-medium text-zinc-700">
                                    Alamat (Opsional)
                                    <textarea name="alamat" rows="3"
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                                    @error('alamat')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <div class="grid gap-4 md:grid-cols-[auto,1fr] md:items-start">
                                    <label class="block text-sm font-medium text-zinc-700">
                                        Logo Perusahaan (JPG/JPEG/PNG, maks 2 MB)
                                        <input type="file" name="gambar" accept=".jpg,.jpeg,.png"
                                            class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 transition file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1 file:text-sm file:font-medium file:text-zinc-700 hover:file:bg-zinc-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                        <span class="mt-1 block text-xs text-zinc-400">
                                            Kosongkan bila tidak mengganti logo.
                                        </span>
                                        @error('gambar')
                                            <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    @if ($perusahaan->gambar)
                                        <figure class="overflow-hidden rounded-lg border border-zinc-200 bg-white p-2">
                                            <img src="{{ asset('storage/' . $perusahaan->gambar) }}"
                                                alt="Logo {{ $perusahaan->nama }}"
                                                class="h-24 w-24 rounded-md object-cover"
                                                onerror="this.style.display='none'">
                                            <figcaption class="mt-2 text-center text-xs text-zinc-500">
                                                Logo saat ini
                                            </figcaption>
                                        </figure>
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>

                    <div
                        class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-10">
                        <a href="{{ route('sirekap.perusahaan.index') }}"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-300">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-md border border-emerald-600 bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
