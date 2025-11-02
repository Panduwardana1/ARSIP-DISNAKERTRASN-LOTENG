@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI | Detail')
@section('titlePageContent', 'Profil P3MI')

@section('content')
    <div class="min-h-screen bg-zinc-100 px-4 py-6 font-inter md:px-6 md:py-8">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl font-semibold text-zinc-900">{{ $perusahaan->nama }}</h2>
                    <p class="text-sm text-zinc-500">
                        Terdaftar pada agency
                        <span class="font-medium text-zinc-700">
                            {{ optional($perusahaan->agency)->nama ?? 'Tidak ada data agency' }}
                        </span>
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('sirekap.perusahaan.index') }}"
                        class="inline-flex items-center justify-center rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                        <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                        Kembali ke daftar
                    </a>
                    <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                        class="inline-flex items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-amber-600">
                        <x-heroicon-o-pencil-square class="mr-2 h-4 w-4" />
                        Ubah data
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-md border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <section class="rounded-xl border border-zinc-200 bg-white p-6">
                    <header class="mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900">Informasi Perusahaan</h3>
                        <p class="text-sm text-zinc-500">Data utama perusahaan dan pimpinan.</p>
                    </header>
                    <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                        <div>
                            <dt class="font-medium text-zinc-700">Nama Perusahaan</dt>
                            <dd class="mt-1 text-zinc-900">{{ $perusahaan->nama }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Agency Penempatan</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ optional($perusahaan->agency)->nama ?? '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Nama Pimpinan</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $perusahaan->pimpinan ?: 'Belum diisi' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Alamat Email</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $perusahaan->email ?: 'Belum diisi' }}
                            </dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="font-medium text-zinc-700">Alamat</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $perusahaan->alamat ?: 'Belum diisi' }}
                            </dd>
                        </div>
                    </dl>
                </section>

                <section class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6">
                    <header>
                        <h3 class="text-lg font-semibold text-zinc-900">Identitas & Status</h3>
                    </header>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-zinc-700">Logo Perusahaan</h4>
                            @if ($perusahaan->gambar)
                                <div class="mt-3 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $perusahaan->gambar) }}"
                                        alt="Logo {{ $perusahaan->nama }}"
                                        class="h-20 w-20 rounded-md border border-zinc-200 object-cover"
                                        onerror="this.style.display='none'">
                                    <a href="{{ asset('storage/' . $perusahaan->gambar) }}" target="_blank"
                                        class="text-sm font-medium text-emerald-600 hover:underline">
                                        Lihat ukuran penuh
                                    </a>
                                </div>
                            @else
                                <p class="mt-2 text-sm text-zinc-500">Logo belum diunggah.</p>
                            @endif
                        </div>
                        <dl class="space-y-3 text-sm text-zinc-600">
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Ditambahkan</dt>
                                <dd class="mt-1 text-zinc-900">
                                    {{ $perusahaan->created_at?->translatedFormat('d F Y H:i') ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Diperbarui</dt>
                                <dd class="mt-1 text-zinc-900">
                                    {{ $perusahaan->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </section>
            </div>

            <section class="rounded-xl border border-zinc-200 bg-white p-6">
                <header class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900">Tenaga Kerja Terkait</h3>
                        <p class="text-sm text-zinc-500">Daftar CPMI yang terkait dengan perusahaan ini.</p>
                    </div>
                    <span class="text-sm text-zinc-500">
                        Total: {{ $perusahaan->tenagaKerja_count ?? $perusahaan->tenagaKerja->count() }}
                    </span>
                </header>
                @if (($perusahaan->tenagaKerja_count ?? $perusahaan->tenagaKerja->count()) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                            <thead>
                                <tr class="bg-zinc-100 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">NIK</th>
                                    <th class="px-4 py-3">Gender</th>
                                    <th class="px-4 py-3">Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach ($perusahaan->tenagaKerja as $tenaga)
                                    <tr class="transition hover:bg-zinc-50/70">
                                        <td class="px-4 py-3">{{ $tenaga->nama }}</td>
                                        <td class="px-4 py-3 font-mono text-xs text-zinc-700">{{ $tenaga->nik }}</td>
                                        <td class="px-4 py-3">{{ $tenaga->getLabelGender() ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            {{ $tenaga->created_at?->translatedFormat('d M Y') ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-zinc-500">
                        Belum ada CPMI yang terhubung dengan perusahaan ini.
                    </p>
                @endif
            </section>
        </div>
    </div>
@endsection
