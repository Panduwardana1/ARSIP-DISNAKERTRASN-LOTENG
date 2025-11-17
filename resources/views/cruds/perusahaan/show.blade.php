@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI | Detail')
@section('titlePageContent', 'Profil P3MI')
@section('description', 'Profil lengkap perusahaan penempatan tenaga kerja.')

@section('headerAction')
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('sirekap.perusahaan.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-400">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali ke daftar
        </a>
        <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
            class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
            <x-heroicon-o-pencil-square class="h-4 w-4" />
            Ubah data
        </a>
    </div>
@endsection

@section('content')
    <section class="mx-auto w-full max-w-5xl space-y-6">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <div class="space-y-1">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Perusahaan Penempatan</p>
                <h2 class="text-2xl font-semibold text-zinc-900">{{ $perusahaan->nama }}</h2>
                <p class="text-sm text-zinc-500">
                    Profil lengkap perusahaan penempatan tenaga kerja.
                </p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
            <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
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

            <section class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
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

        <section class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <header class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900">Tenaga Kerja Terkait</h3>
                    <p class="text-sm text-zinc-500">Daftar CPMI yang terkait dengan perusahaan ini.</p>
                </div>
                <span class="text-sm text-zinc-500">
                    Total: {{ $perusahaan->tenaga_kerja_count ?? $perusahaan->tenagaKerja->count() }}
                </span>
            </header>
            @if (($perusahaan->tenaga_kerja_count ?? $perusahaan->tenagaKerja->count()) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                        <thead>
                            <tr class="bg-zinc-50 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
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
    </section>
@endsection
