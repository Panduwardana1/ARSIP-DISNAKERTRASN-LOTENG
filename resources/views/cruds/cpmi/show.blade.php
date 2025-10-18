@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Detail Tenaga Kerja')
@section('titleContent', 'Detail Tenaga Kerja')

@section('content')
    <div class="h-full overflow-y-auto bg-slate-50 px-6 py-6">
        <div class="mx-auto max-w-5xl space-y-6">
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h2 class="font-inter text-xl font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</h2>
                    <p class="text-sm text-zinc-500">Informasi detail calon pekerja migran Indonesia.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sirekap.cpmi.index') }}"
                        class="inline-flex items-center rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-amber-400 hover:text-amber-600">
                        <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                        Kembali
                    </a>
                    <a href="{{ route('sirekap.cpmi.edit', $tenagaKerja) }}"
                        class="inline-flex items-center rounded-xl border border-amber-500 bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1">
                        <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                        Ubah Data
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="space-y-6 lg:col-span-2">
                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <header class="mb-4 flex items-center justify-between">
                            <div>
                                <h3 class="font-inter text-lg font-semibold text-zinc-800">Data Pribadi</h3>
                                <p class="text-sm text-zinc-500">Identitas utama calon pekerja.</p>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-500">
                                {{ $tenagaKerja->gender }}
                            </span>
                        </header>
                        <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">NIK</dt>
                                <dd class="font-mono text-sm text-zinc-700">{{ $tenagaKerja->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Email</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ $tenagaKerja->email ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Tempat Lahir</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ $tenagaKerja->tempat_lahir }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Tanggal Lahir</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ \Illuminate\Support\Carbon::parse($tenagaKerja->tanggal_lahir)->translatedFormat('d F Y') }}
                                </dd>
                            </div>
                        </dl>
                    </section>

                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <header class="mb-4">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Alamat & Domisili</h3>
                            <p class="text-sm text-zinc-500">Lokasi tinggal sesuai data terakhir.</p>
                        </header>
                        <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Desa / Kelurahan</dt>
                                <dd class="text-sm text-zinc-700">{{ $tenagaKerja->desa }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Kecamatan</dt>
                                <dd class="text-sm text-zinc-700">{{ $tenagaKerja->kecamatan }}</dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Alamat Lengkap</dt>
                                <dd class="text-sm text-zinc-700">{{ $tenagaKerja->alamat_lengkap }}</dd>
                            </div>
                        </dl>
                    </section>

                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <header class="mb-4">
                            <h3 class="font-inter text-lg font-semibold text-zinc-800">Penempatan & Pendidikan</h3>
                            <p class="text-sm text-zinc-500">Informasi kualifikasi dan lowongan aktif.</p>
                        </header>
                        <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Pendidikan Terakhir</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}
                                </dd>
                                @if (optional($tenagaKerja->pendidikan)->level)
                                    <dd class="text-xs text-zinc-500">
                                        Level {{ $tenagaKerja->pendidikan->level }}
                                    </dd>
                                @endif
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-wide text-zinc-400">Lowongan</dt>
                                <dd class="text-sm text-zinc-700">
                                    {{ optional($tenagaKerja->lowongan)->nama ?? '-' }}
                                </dd>
                                @if (optional($tenagaKerja->lowongan?->agensi)->nama)
                                    <dd class="text-xs text-zinc-500">
                                        Agensi: {{ $tenagaKerja->lowongan->agensi->nama }}
                                    </dd>
                                @endif
                                @if (optional($tenagaKerja->lowongan?->perusahaan)->nama)
                                    <dd class="text-xs text-zinc-500">
                                        Perusahaan: {{ $tenagaKerja->lowongan->perusahaan->nama }}
                                    </dd>
                                @endif
                            </div>
                        </dl>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <h3 class="font-inter text-base font-semibold text-zinc-800">Ringkasan</h3>
                        <dl class="mt-4 space-y-3 text-sm text-zinc-600">
                            <div class="flex items-start justify-between">
                                <dt class="text-zinc-500">Dibuat</dt>
                                <dd class="text-right text-zinc-700">
                                    {{ $tenagaKerja->created_at->translatedFormat('d M Y H:i') }}
                                </dd>
                            </div>
                            <div class="flex items-start justify-between">
                                <dt class="text-zinc-500">Pembaharuan</dt>
                                <dd class="text-right text-zinc-700">
                                    {{ $tenagaKerja->updated_at->translatedFormat('d M Y H:i') }}
                                </dd>
                            </div>
                        </dl>
                    </section>

                    <section class="rounded-3xl border border-zinc-100 bg-white p-6 shadow-sm">
                        <header class="mb-4 flex items-center justify-between">
                            <h3 class="font-inter text-base font-semibold text-zinc-800">Riwayat Rekap</h3>
                            <span class="text-xs text-zinc-400">({{ $riwayatRekap->count() }})</span>
                        </header>
                        <ul class="space-y-3">
                            @forelse ($riwayatRekap as $rekap)
                                <li class="rounded-2xl border border-zinc-100 bg-zinc-50 px-4 py-3 text-xs text-zinc-600">
                                    <div class="font-medium text-zinc-700">
                                        {{ optional($rekap->lowongan)->nama ?? 'Lowongan tidak diketahui' }}
                                    </div>
                                    @if ($rekap->lowongan?->agensi)
                                        <div class="text-[11px] text-zinc-500">
                                            {{ $rekap->lowongan->agensi->nama }}
                                        </div>
                                    @endif
                                    <div class="mt-2 text-[11px] text-zinc-400">
                                        {{ $rekap->created_at->translatedFormat('d M Y') }}
                                    </div>
                                </li>
                            @empty
                                <li class="rounded-2xl border border-dashed border-zinc-200 px-4 py-5 text-center text-xs text-zinc-400">
                                    Belum ada riwayat rekap untuk tenaga kerja ini.
                                </li>
                            @endforelse
                        </ul>
                    </section>
                </aside>
            </div>
        </div>
    </div>
@endsection
