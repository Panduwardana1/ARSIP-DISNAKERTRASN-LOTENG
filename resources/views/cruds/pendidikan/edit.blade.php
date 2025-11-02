@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Pendidikan | Ubah')
@section('titlePageContent', 'Ubah Data Pendidikan')

@section('content')
    <div class="flex h-full flex-col font-inter">
        <main class="flex-1 px-4 py-6">
            <div class="mx-auto max-w-3xl space-y-6">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                    <div class="space-y-1">
                        <h2 class="text-xl font-semibold text-zinc-900">Perbarui Informasi Pendidikan</h2>
                        <p class="text-sm text-zinc-500">
                            Sesuaikan nama atau level pendidikan sesuai kebutuhan.
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <a href="{{ route('sirekap.pendidikan.show', $pendidikan) }}"
                            class="inline-flex items-center justify-center rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                            <x-heroicon-o-eye class="mr-2 h-4 w-4" />
                            Lihat Detail
                        </a>
                        <a href="{{ route('sirekap.pendidikan.index') }}"
                            class="inline-flex items-center justify-center rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                            <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                            Kembali ke daftar
                        </a>
                    </div>
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

                <form action="{{ route('sirekap.pendidikan.update', $pendidikan) }}" method="POST"
                    class="rounded-xl border border-zinc-100 bg-white shadow-sm">
                    @csrf
                    @method('PUT')
                    <div class="space-y-8 p-6 md:p-10">
                        <section class="space-y-4">
                            <header>
                                <h3 class="text-lg font-semibold text-zinc-900">Data Pendidikan</h3>
                                <p class="text-sm text-zinc-500">Pastikan tidak terjadi duplikasi nama pendidikan.</p>
                            </header>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                    Nama Pendidikan
                                    <input type="text" name="nama"
                                        value="{{ old('nama', $pendidikan->nama) }}" required
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                    @error('nama')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>

                                <label class="block text-sm font-medium text-zinc-700 md:col-span-2">
                                    Level Pendidikan
                                    <select name="level" required
                                        class="mt-1 w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                                        <option value="">-- Pilih Level --</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level }}" @selected(old('level', $pendidikan->level) === $level)>
                                                {{ $level }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level')
                                        <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span>
                                    @enderror
                                </label>
                            </div>
                        </section>
                    </div>

                    <div
                        class="flex flex-col gap-3 border-t border-zinc-100 bg-zinc-50 px-6 py-5 md:flex-row md:items-center md:justify-between md:px-10">
                        <button type="button"
                            onclick="history.back()"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-300">
                            Batal
                        </button>
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
