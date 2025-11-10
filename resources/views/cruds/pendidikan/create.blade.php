@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Pendidikan | Tambah')
@section('Title', 'Pendidikan')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Referensi Pendidikan</p>
                <h1 class="text-2xl font-semibold text-zinc-900">Tambah Pendidikan Baru</h1>
                <p class="text-sm text-zinc-600">
                    Masukkan kode singkat (misal: SD, SMA, S1) beserta label lengkap agar mudah dikenali di seluruh modul.
                </p>
            </div>
            <a href="{{ route('sirekap.pendidikan.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                Kembali ke Daftar
            </a>
        </div>

        @if ($errors->has('app'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('app') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <p class="font-semibold">Periksa kembali data berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sirekap.pendidikan.store') }}" method="POST"
            class="space-y-6 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-medium text-zinc-700">
                        Kode Pendidikan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        maxlength="10"
                        required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm uppercase tracking-wide focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Contoh: SD, SMP, SMA, S1"
                    >
                    <p class="mt-1 text-xs text-zinc-500">Maksimal 10 karakter huruf kapital.</p>
                    @error('nama')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="label" class="block text-sm font-medium text-zinc-700">
                        Label Pendidikan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="label"
                        name="label"
                        value="{{ old('label') }}"
                        maxlength="100"
                        required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Contoh: Sekolah Dasar / Sekolah Menengah Atas / Sarjana"
                    >
                    @error('label')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="reset"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                    Reset
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                >
                    <x-heroicon-o-check class="mr-2 h-4 w-4" />
                    Simpan Pendidikan
                </button>
            </div>
        </form>
    </section>
@endsection
