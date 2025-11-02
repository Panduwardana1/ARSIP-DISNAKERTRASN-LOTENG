@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Pendidikan | Detail')
@section('titlePageContent', 'Detail Pendidikan')

@section('content')
    <div class="flex h-full flex-col font-inter">
        <main class="flex-1 px-4 py-6">
            <div class="mx-auto max-w-3xl space-y-6">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                    <div class="space-y-1">
                        <h2 class="text-xl font-semibold text-zinc-900">{{ $pendidikan->nama }}</h2>
                        <p class="text-sm text-zinc-500">
                            Ringkasan data pendidikan dan relasi ke tenaga kerja.
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <a href="{{ route('sirekap.pendidikan.edit', $pendidikan) }}"
                            class="inline-flex items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-amber-50 transition hover:bg-amber-600">
                            <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                            Ubah Data
                        </a>
                        <a href="{{ route('sirekap.pendidikan.index') }}"
                            class="inline-flex items-center justify-center rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                            <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                            Kembali ke daftar
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="rounded-xl border border-zinc-100 bg-white shadow-sm">
                    <header class="border-b border-zinc-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-zinc-900">Informasi Pendidikan</h3>
                    </header>
                    <dl class="grid grid-cols-1 gap-x-6 gap-y-5 px-6 py-6 text-sm md:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Nama Pendidikan</dt>
                            <dd class="mt-1 text-base text-zinc-800">{{ $pendidikan->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Level Pendidikan</dt>
                            <dd class="mt-1 inline-flex items-center rounded-full bg-zinc-100 px-2 py-0.5 text-sm font-medium uppercase text-zinc-700">
                                {{ $pendidikan->level }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Digunakan Oleh</dt>
                            <dd class="mt-1 text-base text-zinc-800">
                                {{ $pendidikan->tenaga_kerjas_count }} Tenaga Kerja
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Dibuat / Diperbarui</dt>
                            <dd class="mt-1 text-sm text-zinc-700">
                                Dibuat: {{ $pendidikan->created_at?->translatedFormat('d M Y H:i') ?? '-' }}<br>
                                Diperbarui: {{ $pendidikan->updated_at?->translatedFormat('d M Y H:i') ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </section>

                <section class="rounded-xl border border-rose-100 bg-rose-50 px-6 py-4 text-sm text-rose-700">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-shield-exclamation class="h-5 w-5" />
                            <span>
                                Hapus data pendidikan hanya jika tidak lagi digunakan oleh tenaga kerja.
                            </span>
                        </div>
                        <x-modal-delete :action="route('sirekap.pendidikan.destroy', $pendidikan)" title="Hapus Pendidikan"
                            message="Data pendidikan akan dihapus permanen. Lanjutkan?">
                            <span
                                class="inline-flex items-center justify-center rounded-md bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-rose-700">
                                <x-heroicon-o-trash class="mr-2 h-4 w-4" />
                                Hapus Data
                            </span>
                        </x-modal-delete>
                    </div>
                </section>
            </div>
        </main>
    </div>
@endsection
