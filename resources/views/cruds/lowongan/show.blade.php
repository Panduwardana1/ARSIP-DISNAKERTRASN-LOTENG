@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Lowongan | Detail')
@section('titleContent', 'Detail Lowongan')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-4xl space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold text-zinc-800">{{ $lowongan->nama }}</h2>
                    <p class="text-sm text-zinc-500">Informasi lengkap lowongan kerja dan relasinya.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('sirekap.lowongan.edit', $lowongan) }}"
                        class="inline-flex items-center gap-2 rounded-md border border-amber-400 bg-amber-50 px-4 py-2 text-sm font-medium text-amber-600 transition hover:bg-amber-100">
                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                        Ubah
                    </a>
                    <form action="{{ route('sirekap.lowongan.destroy', $lowongan) }}" method="POST"
                        onsubmit="return confirm('Hapus lowongan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md border border-rose-400 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-100">
                            <x-heroicon-o-trash class="h-4 w-4" />
                            Hapus
                        </button>
                    </form>
                    <a href="{{ route('sirekap.lowongan.index') }}"
                        class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-blue-400 hover:text-blue-600">
                        <x-heroicon-o-list-bullet class="h-4 w-4" />
                        Daftar Lowongan
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('destroy'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                    {{ $errors->first('destroy') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6">
                <div class="rounded-xl border border-zinc-100 bg-white p-6 shadow-sm">
                    <div class="space-y-5 text-sm text-zinc-600">
                        <div>
                            <span class="text-xs font-semibold uppercase text-zinc-400">Nama Lowongan</span>
                            <p class="mt-1 text-base font-semibold text-zinc-800">{{ $lowongan->nama }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Agensi Penempatan</span>
                                <p class="mt-1">{{ $lowongan->agensi->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Perusahaan</span>
                                <p class="mt-1">{{ $lowongan->perusahaan->nama ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Destinasi</span>
                                <p class="mt-1">{{ $lowongan->destinasi->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Nomor Kontrak</span>
                                <p class="mt-1 font-mono text-sm uppercase text-zinc-700">{{ $lowongan->kontrak_kerja }}</p>
                            </div>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase text-zinc-400">Status</span>
                            <p class="mt-1">
                                <span @class([
                                    'inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-emerald-100 text-emerald-700' => $lowongan->is_aktif === 'aktif',
                                    'bg-rose-100 text-rose-700' => $lowongan->is_aktif === 'non_aktif',
                                ])>
                                    {{ ucfirst(str_replace('_', ' ', $lowongan->is_aktif)) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase text-zinc-400">Catatan</span>
                            <p class="mt-1 whitespace-pre-line">{{ $lowongan->catatan ?? '-' }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Dibuat</span>
                                <p class="mt-1">{{ $lowongan->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Diperbarui</span>
                                <p class="mt-1">{{ $lowongan->updated_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
