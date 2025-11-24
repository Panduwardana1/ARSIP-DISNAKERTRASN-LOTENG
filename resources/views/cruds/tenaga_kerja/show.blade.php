@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Detail Tenaga Kerja')
@section('titlePageContent', 'Biodata PMI')

@section('content')

    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-4 rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-400 to-cyan-500 text-white shadow flex items-center justify-center text-lg font-semibold">
                    {{ strtoupper(substr($tenagaKerja->nama, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">CPMI</p>
                    <h1 class="text-2xl font-semibold text-zinc-900">{{ $tenagaKerja->nama }}</h1>
                    <p class="text-sm text-zinc-600">
                        NIK {{ $tenagaKerja->nik }}
                        <span class="mx-2 text-zinc-300">&middot;</span>
                        {{ $tenagaKerja->getLabelGender() }}
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-400">
                    <x-heroicon-o-arrow-left class="h-4 w-4" />
                    Kembali
                </a>
                <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
                    <x-heroicon-o-pencil-square class="h-4 w-4" />
                    Ubah Data
                </a>
            </div>
        </div>

        <div class="mx-auto w-full max-w-6xl space-y-5">
            <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900">Data Pribadi</h2>
                    <p class="text-sm text-zinc-500">Ringkasan identitas CPMI sesuai dokumen resmi.</p>
                </div>
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
                        <dt class="font-medium text-zinc-700">Jenis Kelamin</dt>
                        <dd class="mt-1">{{ $tenagaKerja->getLabelGender() }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Usia</dt>
                        <dd class="mt-1">{{ $tenagaKerja->usia !== null ? "{$tenagaKerja->usia} tahun" : '-' }}</dd>
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
                </dl>
            </section>

            <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900">Kontak & Domisili</h2>
                    <p class="text-sm text-zinc-500">Informasi komunikasi dan alamat terkini.</p>
                </div>
                <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                    <div>
                        <dt class="font-medium text-zinc-700">Email</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->email ?: 'Tidak diisi' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">No. Telepon</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->no_telpon ?: 'Tidak diisi' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Desa/Kelurahan</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->desa)->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Kecamatan</dt>
                        <dd class="mt-1 text-zinc-900">
                            {{ optional(optional($tenagaKerja->desa)->kecamatan)->nama ?? '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Kode Pos</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->kode_pos ?? '-' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-medium text-zinc-700">Alamat Lengkap</dt>
                        <dd class="mt-1 text-zinc-900 leading-relaxed">{{ $tenagaKerja->alamat_lengkap ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900">Relasi Penempatan</h2>
                    <p class="text-sm text-zinc-500">Detail pendidikan, agency, dan tujuan kerja.</p>
                </div>
                <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                    <div>
                        <dt class="font-medium text-zinc-700">Pendidikan Terakhir</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}</dd>
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
                        <dt class="font-medium text-zinc-700">Lowongan/Posisi</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->agency)->lowongan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Negara Penempatan</dt>
                        <dd class="mt-1 text-zinc-900">{{ optional($tenagaKerja->negara)->nama ?? '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900">Status Sistem</h2>
                    <p class="text-sm text-zinc-500">Riwayat aktivitas dan kontrol keaktifan.</p>
                </div>
                <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-3">
                    <div>
                        <dt class="font-medium text-zinc-700">Status Keaktifan</dt>
                        <dd class="mt-2">
                            @php
                                $isActive = $tenagaKerja->is_active === 'Aktif';
                                $badgeClasses = $isActive
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-rose-100 text-rose-700';
                            @endphp
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $tenagaKerja->is_active }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Tanggal Dibuat</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->created_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-700">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-zinc-900">{{ $tenagaKerja->updated_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </div>
                </dl>
            </section>
        </div>
    </section>
@endsection
