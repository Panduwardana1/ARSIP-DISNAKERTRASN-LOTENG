@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agency | Detail')
@section('titlePageContent', 'Profil Agency Penempatan')

@section('content')
    <div class="min-h-screen bg-zinc-100 px-4 py-6 font-inter md:px-6 md:py-8">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl font-semibold text-zinc-900">{{ $agency->nama }}</h2>
                    <p class="text-sm text-zinc-500">
                        Penempatan di {{ $agency->country }} • {{ $agency->kota }}
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('sirekap.agency.index') }}"
                        class="inline-flex items-center justify-center rounded-md border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-emerald-400 hover:text-emerald-600">
                        <x-heroicon-o-arrow-left class="mr-2 h-4 w-4" />
                        Kembali ke daftar
                    </a>
                    <a href="{{ route('sirekap.agency.edit', $agency) }}"
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

            @if ($errors->has('db'))
                <div class="rounded-md border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    {{ $errors->first('db') }}
                </div>
            @endif

            @if ($errors->has('app'))
                <div class="rounded-md border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">
                    {{ $errors->first('app') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
                <section class="rounded-xl border border-zinc-200 bg-white p-6">
                    <header class="mb-4">
                        <h3 class="text-lg font-semibold text-zinc-900">Informasi Agency</h3>
                        <p class="text-sm text-zinc-500">Data inti agency mitra.</p>
                    </header>
                    <dl class="grid grid-cols-1 gap-4 text-sm text-zinc-600 md:grid-cols-2">
                        <div>
                            <dt class="font-medium text-zinc-700">Nama Agency</dt>
                            <dd class="mt-1 text-zinc-900">{{ $agency->nama }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Negara Tujuan</dt>
                            <dd class="mt-1 text-zinc-900">{{ $agency->country }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-zinc-700">Kota Penempatan</dt>
                            <dd class="mt-1 text-zinc-900">{{ $agency->kota }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="font-medium text-zinc-700">Ringkasan Lowongan</dt>
                            <dd class="mt-1 text-zinc-900">{{ $agency->lowongan }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6">
                    <header>
                        <h3 class="text-lg font-semibold text-zinc-900">Status Sistem</h3>
                    </header>
                    <dl class="space-y-3 text-sm text-zinc-600">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Perusahaan Terkait</dt>
                            <dd class="mt-1 text-zinc-900">{{ $agency->perusahaans_count ?? $agency->perusahaans->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">CPMI Terkait</dt>
                            <dd class="mt-1 text-zinc-900">{{ $agency->tenaga_kerjas_count ?? $agency->tenagaKerjas->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Ditambahkan</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $agency->created_at?->translatedFormat('d F Y H:i') ?? '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-zinc-400">Diperbarui</dt>
                            <dd class="mt-1 text-zinc-900">
                                {{ $agency->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </section>
            </div>

            <section class="rounded-xl border border-zinc-200 bg-white p-6">
                <header class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900">Perusahaan Mitra</h3>
                        <p class="text-sm text-zinc-500">Daftar perusahaan dalam negeri yang bekerja sama dengan agency ini.</p>
                    </div>
                    <span class="text-sm text-zinc-500">
                        Total: {{ $agency->perusahaans_count ?? $agency->perusahaans->count() }}
                    </span>
                </header>
                @if (($agency->perusahaans_count ?? $agency->perusahaans->count()) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                            <thead>
                                <tr class="bg-zinc-100 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                    <th class="px-4 py-3">Nama Perusahaan</th>
                                    <th class="px-4 py-3">Kontak</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach ($agency->perusahaans as $perusahaan)
                                    <tr class="transition hover:bg-zinc-50/70">
                                        <td class="px-4 py-3">
                                            <div class="font-semibold text-zinc-800">{{ $perusahaan->nama }}</div>
                                            <div class="text-xs text-zinc-500">
                                                {{ $perusahaan->pimpinan ?: 'Pimpinan belum diisi' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs text-zinc-500">
                                            {{ $perusahaan->email ?: 'Email belum diisi' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-zinc-500">
                        Belum ada perusahaan yang terhubung dengan agency ini.
                    </p>
                @endif
            </section>

            <section class="rounded-xl border border-zinc-200 bg-white p-6">
                <header class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900">CPMI Terdaftar</h3>
                        <p class="text-sm text-zinc-500">Daftar CPMI yang ditempatkan melalui agency ini.</p>
                    </div>
                    <span class="text-sm text-zinc-500">
                        Total: {{ $agency->tenaga_kerjas_count ?? $agency->tenagaKerjas->count() }}
                    </span>
                </header>
                @if (($agency->tenaga_kerjas_count ?? $agency->tenagaKerjas->count()) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                            <thead>
                                <tr class="bg-zinc-100 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">NIK</th>
                                    <th class="px-4 py-3">Gender</th>
                                    <th class="px-4 py-3">Perusahaan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach ($agency->tenagaKerjas as $tenaga)
                                    <tr class="transition hover:bg-zinc-50/70">
                                        <td class="px-4 py-3">{{ $tenaga->nama }}</td>
                                        <td class="px-4 py-3 font-mono text-xs text-zinc-700">{{ $tenaga->nik }}</td>
                                        <td class="px-4 py-3">
                                            {{ method_exists($tenaga, 'getLabelGender') ? $tenaga->getLabelGender() : $tenaga->gender }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ optional($tenaga->perusahaan)->nama ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-zinc-500">
                        Belum ada CPMI yang terdaftar melalui agency ini.
                    </p>
                @endif
            </section>
        </div>
    </div>
@endsection
