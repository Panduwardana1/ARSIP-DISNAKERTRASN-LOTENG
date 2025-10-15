@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Detail Tenaga Kerja')

@php
    $lokasi = collect([$tenagaKerja->desa, $tenagaKerja->kecamatan])->filter()->implode(', ');
    $perusahaan = optional($tenagaKerja->agensiLowongan?->perusahaanAgensi?->perusahaan)->nama_perusahaan;
    $agensi = optional($tenagaKerja->agensiLowongan?->perusahaanAgensi?->agensi)->nama_agensi;
    $negara = optional($tenagaKerja->agensiLowongan?->negaraTujuan)->nama_negara;
    $lowongan = optional($tenagaKerja->agensiLowongan?->lowonganPekerjaan)->nama_pekerjaan;
@endphp

@section('headerActions')
    <div class="flex items-center gap-2">
        <a href="{{ route('disnakertrans.pekerja.index') }}"
            class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto w-full px-4 py-6">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-zinc-200">
            <div class="flex flex-col gap-1 border-b border-zinc-200 pb-4">
                <h2 class="text-xl font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</h2>
                <p class="text-sm text-zinc-500">
                    <span class="font-medium">NIK:</span> {{ $tenagaKerja->nomor_induk }}
                </p>
                <p class="text-sm text-zinc-500">
                    <span class="font-medium">Lokasi:</span> {{ $lokasi ?: '-' }}
                </p>
            </div>

            <dl class="mt-6 grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-2">
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $tenagaKerja->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm text-zinc-800">
                        {{ optional($tenagaKerja->tanggal_lahir)?->format('d-m-Y') ?? '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Tempat Lahir</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $tenagaKerja->tempat_lahir ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Email</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $tenagaKerja->email ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Pendidikan Terakhir</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Alamat Lengkap</dt>
                    <dd class="mt-1 text-sm text-zinc-800 whitespace-pre-line">{{ $tenagaKerja->alamat_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Lowongan</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $lowongan ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Perusahaan</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $perusahaan ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Agensi</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $agensi ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Negara Tujuan</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $negara ?: '-' }}</dd>
                </div>
            </dl>

            <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Dibuat</p>
                    <p class="mt-1 text-sm text-zinc-800">
                        {{ optional($tenagaKerja->created_at)?->format('d-m-Y H:i') ?? '-' }}
                    </p>
                </div>
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Terakhir Diperbarui</p>
                    <p class="mt-1 text-sm text-zinc-800">
                        {{ optional($tenagaKerja->updated_at)?->format('d-m-Y H:i') ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
