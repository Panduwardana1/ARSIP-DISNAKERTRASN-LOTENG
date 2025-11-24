@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agency | Detail')

@section('headerAction')
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('sirekap.agency.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-400">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali
        </a>
        <a href="{{ route('sirekap.agency.edit', $agency) }}"
            class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">
            <x-heroicon-o-pencil-square class="h-4 w-4" />
            Ubah data
        </a>
    </div>
@endsection

@section('content')
    <section class="mx-auto w-full max-w-6xl space-y-6">
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

        <div class="rounded-md border border-zinc-200 bg-white p-6">
            <div class="space-y-1">
                <h2 class="text-2xl font-semibold text-zinc-900">{{ $agency->nama }}</h2>
                <p class="text-sm text-zinc-500">
                    Kemitraan dengan {{ $agency->perusahaan->nama ?? '-' }}
                </p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
            <section class="rounded-md border border-zinc-200 bg-white p-6">
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
                        <dt class="font-medium text-zinc-700">Perusahaan Mitra</dt>
                        <dd class="mt-1 text-zinc-900">{{ $agency->perusahaan->nama ?? '-' }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-medium text-zinc-700">Ringkasan Lowongan</dt>
                        <dd class="mt-1 text-zinc-900">{{ $agency->lowongan }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="font-medium text-zinc-700">Keterangan</dt>
                        <dd class="mt-1 whitespace-pre-line text-zinc-900">
                            {{ $agency->keterangan ?? '-' }}
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="space-y-4 rounded-md border border-zinc-200 bg-white p-6">
                <header>
                    <h3 class="text-lg font-semibold text-zinc-900">Status Sistem</h3>
                </header>
                <dl class="space-y-3 text-sm text-zinc-600">
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
    </section>
@endsection
