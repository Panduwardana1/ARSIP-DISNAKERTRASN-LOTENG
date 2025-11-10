@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Detail Tenaga Kerja')
@section('titlePageContent', 'Biodata PMI')

@section('content')
    <div class="min-h-screen bg-zinc-100 px-4 py-6 font-inter md:px-6 md:py-8">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl font-semibold text-zinc-900">{{ $tenagaKerja->nama }}</h2>
                    <p class="text-sm text-zinc-500">
                        NIK {{ $tenagaKerja->nik }}
                        <span aria-hidden="true" class="px-2 text-zinc-300">|</span>
                        {{ $tenagaKerja->getLabelGender() }}
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                        class="inline-flex items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-amber-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                        <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                        Ubah data
                    </a>
                    <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                        class="inline-flex items-center justify-center rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
                        <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                        Kembali ke daftar
                    </a>
                </div>
            </div>

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
                            <dd class="mt-1">{{ $tenagaKerja->getLabelGender() }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Usia</dt>
                            <dd class="mt-1">
                                {{ $tenagaKerja->usia !== null ? "{$tenagaKerja->usia} tahun" : '-' }}
                            </dd>
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
                            <dt class="font-medium text-zinc-700">Status Keaktifan</dt>
                            <dd class="mt-1">
                                @php
                                    $isActive = $tenagaKerja->is_active === 'Aktif';
                                    $badgeClasses = $isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700';
                                @endphp
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                    {{ $tenagaKerja->is_active }}
                                </span>
                            </dd>
                        </div>
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
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->desa)->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Kecamatan</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional(optional($tenagaKerja->desa)->kecamatan)->nama ?? '-' }}</dd>
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
                    <p class="text-sm text-zinc-500">Detail pendidikan serta relasi perusahaan dan agency.</p>
                </header>
                <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                    <div>
                        <dt class="font-medium text-zinc-700">Pendidikan Terakhir</dt>
                        <dd class="mt-1 text-zinc-900">
                            {{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Perusahaan (P3MI)</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->perusahaan)->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Agency Penempatan</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->agency)->nama ?? '-' }}</dd>
                    </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Negara Penempatan</dt>
                            <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->negara)->nama ?? '-' }}</dd>
                        </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Email</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->email ?? '-' }}</dd>
                    </div>
                </dl>
            </section>
        </div>
    </div>
@endsection
