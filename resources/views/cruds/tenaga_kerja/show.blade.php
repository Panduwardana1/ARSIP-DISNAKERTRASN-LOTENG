@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Detail Tenaga Kerja')
@section('titleContent', 'Detail Data Tenaga Kerja')

@section('content')
    <div class="min-h-screen bg-zinc-100 px-4 py-6 font-inter md:px-6 md:py-8">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl font-semibold text-zinc-900">{{ $tenagaKerja->nama }}</h2>
                    <p class="text-sm text-zinc-500">
                        NIK {{ $tenagaKerja->nik }}
                        <span aria-hidden="true" class="px-2 text-zinc-300">|</span>
                        {{ $tenagaKerja->gender ?? '-' }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                        class="inline-flex items-center justify-center rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
                        <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                        Kembali ke daftar
                    </a>
                    <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                        class="inline-flex items-center justify-center rounded-md bg-sky-600 px-4 py-2 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                        <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                        Ubah data
                    </a>
                    <x-modal-delete :action="route('sirekap.tenaga-kerja.destroy', $tenagaKerja)" title="Hapus Data Tenaga Kerja">
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center justify-center rounded-md border border-rose-500 bg-white px-4 py-2 text-sm font-semibold text-rose-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-500">
                                <x-heroicon-o-trash class="mr-2 h-4 w-4" />
                                Hapus
                            </button>
                        </x-slot>
                        <div class="space-y-2 text-sm text-zinc-600">
                            <p>Anda yakin ingin menghapus data <span class="font-semibold">{{ $tenagaKerja->nama }}</span>?
                            </p>
                            <p>Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </x-modal-delete>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-md border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <section class="rounded-xl border border-zinc-200 bg-white p-6 lg:col-span-2">
                    <header class="mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900">Profil Pribadi</h3>
                    </header>
                    <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                        <div>
                            <dt class="font-medium text-zinc-700">Nama Lengkap</dt>
                            <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->nama }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">NIK</dt>
                            <dd class="mt-1 font-mono text-zinc-900">{{ $tenagaKerja->nik }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Gender</dt>
                            <dd class="mt-1">{{ $tenagaKerja->gender ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Usia</dt>
                            <dd class="mt-1">{{ $tenagaKerja->usia }} tahun</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Tempat Lahir</dt>
                            <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->tempat_lahir ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Tanggal Lahir</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $tenagaKerja->tanggal_lahir?->translatedFormat('d F Y') ?? '-' }}
                            </dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="font-medium text-zinc-700">Alamat Email</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $tenagaKerja->email ?: 'Tidak diisi' }}
                            </dd>
                        </div>
                    </dl>
                </section>

                <section class="rounded-xl border border-zinc-200 bg-white p-6">
                    <header class="mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900">Status Sistem</h3>
                    </header>
                    <dl class="space-y-3 text-sm text-zinc-600">
                        <div>
                            <dt class="font-medium text-zinc-700">Dibuat</dt>
                            <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->created_at?->format('d M Y H:i') ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Diperbarui</dt>
                            <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->updated_at?->format('d M Y H:i') ?? '-' }}</dd>
                        </div>
                    </dl>
                </section>
            </div>

            <section class="rounded-xl border border-zinc-200 bg-white p-6">
                <header class="mb-4">
                    <h3 class="text-lg font-semibold text-zinc-900">Domisili</h3>
                    <p class="text-sm text-zinc-500">Informasi alamat sesuai data terakhir.</p>
                </header>
                <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-3">
                    <div>
                        <dt class="font-medium text-zinc-700">Desa/Kelurahan</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->desa ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Kecamatan</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->kecamatan ?? '-' }}</dd>
                    </div>
                    <div class="md:col-span-3">
                        <dt class="font-medium text-zinc-700">Alamat Lengkap</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->alamat_lengkap ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-6">
                <header class="mb-4">
                    <h3 class="text-lg font-semibold text-zinc-900">Kualifikasi & Penempatan</h3>
                    <p class="text-sm text-zinc-500">Detail pendidikan dan lowongan yang diikuti.</p>
                </header>
                <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                    <div>
                        <dt class="font-medium text-zinc-700">Pendidikan Terakhir</dt>
                        <dd class="mt-1 text-zinc-900">
                            {{ optional($tenagaKerja->pendidikan)->level ?? (optional($tenagaKerja->pendidikan)->nama ?? '-') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Lowongan</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->lowongan->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Perusahaan (P3MI)</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->lowongan?->perusahaan?->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Agensi Penempatan</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->lowongan?->agensi?->nama ?? '-' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-medium text-zinc-700">Destinasi</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->lowongan?->destinasi?->nama ?? '-' }}</dd>
                    </div>
                </dl>
            </section>
        </div>
    </div>
@endsection
