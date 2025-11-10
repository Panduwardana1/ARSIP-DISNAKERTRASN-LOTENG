@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Pendidikan | Detail')
@section('Title', 'Pendidikan')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="space-y-1">
                <p class="text-sm font-medium text-indigo-600">Referensi Pendidikan</p>
                <h1 class="text-3xl font-semibold text-zinc-900">{{ $pendidikan->label }}</h1>
                <p class="text-sm text-zinc-600">
                    Ringkasan kode pendidikan beserta hubungan dengan data CPMI.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('sirekap.pendidikan.edit', $pendidikan) }}"
                    class="inline-flex items-center rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600">
                    <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                    Ubah
                </a>
                <a href="{{ route('sirekap.pendidikan.index') }}"
                    class="inline-flex items-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                    <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
            <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-zinc-900">Informasi Pendidikan</h2>
                <div class="mt-4 grid gap-6 text-sm text-zinc-600 md:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Kode</p>
                        <p class="mt-1 inline-flex items-center rounded-md bg-zinc-100 px-3 py-1 text-base font-semibold uppercase tracking-wide text-zinc-900">
                            {{ $pendidikan->nama }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Label</p>
                        <p class="mt-1 text-base text-zinc-900">{{ $pendidikan->label }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Tanggal Dibuat</p>
                        <p class="mt-1 text-zinc-900">
                            {{ $pendidikan->created_at?->translatedFormat('d M Y H:i') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Terakhir Diperbarui</p>
                        <p class="mt-1 text-zinc-900">
                            {{ $pendidikan->updated_at?->translatedFormat('d M Y H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-zinc-900">Penggunaan</h2>
                <dl class="mt-4 space-y-4 text-sm text-zinc-700">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Total CPMI</dt>
                        <dd class="mt-1 text-2xl font-semibold text-zinc-900">
                            {{ $pendidikan->tenaga_kerjas_count }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Catatan</dt>
                        <dd class="mt-1 text-zinc-600">
                            Pastikan menghapus kode pendidikan hanya jika sudah tidak digunakan oleh data CPMI.
                        </dd>
                    </div>
                </dl>
            </section>
        </div>

        <section class="rounded-2xl border border-rose-100 bg-rose-50 px-6 py-4 text-sm text-rose-700 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-shield-exclamation class="h-5 w-5" />
                    <span>Hapus data ini hanya jika sudah dipastikan tidak dipakai pada data CPMI.</span>
                </div>
                <x-modal-delete
                    :action="route('sirekap.pendidikan.destroy', $pendidikan)"
                    :title="'Hapus ' . $pendidikan->label"
                    message="Data pendidikan akan dihapus permanen. Lanjutkan?"
                >
                    <span class="inline-flex items-center rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                        <x-heroicon-o-trash class="mr-2 h-4 w-4" />
                        Hapus Pendidikan
                    </span>
                </x-modal-delete>
            </div>
        </section>
    </section>
@endsection
