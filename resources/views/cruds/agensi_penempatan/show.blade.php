@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agensi Penempatan | Detail')
@section('titleContent', 'Detail Agensi Penempatan')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-5xl space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold text-zinc-800">{{ $agensi->nama }}</h2>
                    <p class="text-sm text-zinc-500">Informasi lengkap mengenai agensi penempatan tenaga kerja.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('sirekap.agensi.edit', $agensi) }}"
                        class="inline-flex items-center gap-2 rounded-md border border-amber-400 bg-amber-50 px-4 py-2 text-sm font-medium text-amber-600 transition hover:bg-amber-100">
                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                        Ubah
                    </a>
                    <form action="{{ route('sirekap.agensi.destroy', $agensi) }}" method="POST"
                        onsubmit="return confirm('Hapus data agensi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md border border-rose-400 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-100">
                            <x-heroicon-o-trash class="h-4 w-4" />
                            Hapus
                        </button>
                    </form>
                    <a href="{{ route('sirekap.agensi.index') }}"
                        class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-blue-400 hover:text-blue-600">
                        <x-heroicon-o-list-bullet class="h-4 w-4" />
                        Daftar Agensi
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

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-zinc-100 bg-white p-6 shadow-sm lg:col-span-2">
                    <div class="space-y-5 text-sm text-zinc-600">
                        <div>
                            <span class="text-xs font-semibold uppercase text-zinc-400">Nama Agensi</span>
                            <p class="mt-1 text-base font-semibold text-zinc-800">{{ $agensi->nama }}</p>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase text-zinc-400">Lokasi</span>
                            <p class="mt-1 whitespace-pre-line">{{ $agensi->lokasi ?? '-' }}</p>
                        </div>

                        <div>
                            <span class="text-xs font-semibold uppercase text-zinc-400">Status</span>
                            <p class="mt-1">
                                <span @class([
                                    'inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-emerald-100 text-emerald-700' => $agensi->is_aktif === 'aktif',
                                    'bg-rose-100 text-rose-700' => $agensi->is_aktif === 'non_aktif',
                                ])>
                                    <span class="h-2.5 w-2.5 rounded-full"
                                        @class([
                                            'bg-emerald-500' => $agensi->is_aktif === 'aktif',
                                            'bg-rose-500' => $agensi->is_aktif === 'non_aktif',
                                        ])></span>
                                    {{ ucfirst(str_replace('_', ' ', $agensi->is_aktif)) }}
                                </span>
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Dibuat</span>
                                <p class="mt-1">{{ $agensi->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Diperbarui</span>
                                <p class="mt-1">{{ $agensi->updated_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-xl border border-zinc-100 bg-white p-6 text-sm text-zinc-600 shadow-sm">
                        <p class="text-xs font-semibold uppercase text-zinc-400">Logo Agensi</p>
                        @if ($agensi->gambar_url)
                            <img src="{{ $agensi->gambar_url }}" alt="Logo {{ $agensi->nama }}"
                                class="mt-4 h-32 w-32 rounded-lg border border-zinc-200 object-cover"
                                onerror="this.style.display='none'">
                            <p class="mt-3 text-xs text-zinc-500 break-all">{{ $agensi->gambar }}</p>
                        @else
                            <p class="mt-3 text-zinc-500">Belum ada logo yang diunggah.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
