@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Detail')

@section('headerAction')
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('sirekap.tenaga-kerja.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-400">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali
        </a>
        <a href="{{ route('sirekap.tenaga-kerja.edit', $tenagaKerja) }}"
            class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
            <x-heroicon-o-pencil-square class="h-4 w-4" />
            Ubah data
        </a>
    </div>
@endsection

@section('content')
    <section class="mx-auto w-full max-w-6xl space-y-6">
        <div class="rounded-md border border-zinc-200 bg-white p-6">
            <div class="flex items-center gap-4">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500 text-lg font-semibold text-white">
                    {{ strtoupper(substr($tenagaKerja->nama, 0, 1)) }}
                </div>
                <div class="space-y-1">
                    <h2 class="text-2xl font-semibold text-zinc-900">{{ $tenagaKerja->nama }}</h2>
                    <p class="text-sm text-zinc-500">
                        NIK {{ $tenagaKerja->nik }}
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
            <section class="space-y-6 rounded-md border border-zinc-200 bg-white p-6">
                <div class="space-y-1">
                    <h3 class="text-lg font-semibold text-zinc-900">Data Pribadi</h3>
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

                <div class="border-t border-zinc-100 pt-4">
                    <div class="space-y-1">
                        <h3 class="text-lg font-semibold text-zinc-900">Kontak & Domisili</h3>
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
                </div>

                <div class="border-t border-zinc-100 pt-4">
                    <div class="space-y-1">
                        <h3 class="text-lg font-semibold text-zinc-900">Relasi Penempatan</h3>
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
                </div>
            </section>

            <section class="space-y-4 rounded-md border border-zinc-200 bg-white p-6">
                <header>
                    <h3 class="text-lg font-semibold text-zinc-900">Status Sistem</h3>
                </header>
                <div class="space-y-4">
                    <dl class="space-y-3 border-t border-zinc-100 pt-3 text-sm text-zinc-600">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Ditambahkan</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $tenagaKerja->created_at?->translatedFormat('d F Y') ?? '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Diperbarui</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $tenagaKerja->updated_at?->translatedFormat('d F Y') ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </section>
        </div>
    </section>
@endsection
