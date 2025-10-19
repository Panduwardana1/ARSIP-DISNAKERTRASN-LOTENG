@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Destinasi | Detail')
@section('titleContent', 'Detail Destinasi')

@section('content')
    <div class="h-full overflow-y-auto py-4">
        <div class="mx-auto max-w-4xl space-y-6 px-2 font-inter">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold text-zinc-800">{{ $destinasi->nama }}</h2>
                    <p class="text-sm text-zinc-500">Informasi lengkap negara tujuan penempatan tenaga kerja.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('sirekap.destinasi.edit', $destinasi) }}"
                        class="inline-flex items-center gap-2 rounded-md border border-amber-400 bg-amber-50 px-4 py-2 text-sm font-medium text-amber-600 transition hover:bg-amber-100">
                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                        Ubah
                    </a>
                    <form action="{{ route('sirekap.destinasi.destroy', $destinasi) }}" method="POST"
                        onsubmit="return confirm('Hapus destinasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-md border border-rose-400 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-100">
                            <x-heroicon-o-trash class="h-4 w-4" />
                            Hapus
                        </button>
                    </form>
                    <a href="{{ route('sirekap.destinasi.index') }}"
                        class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-600 transition hover:border-blue-400 hover:text-blue-600">
                        <x-heroicon-o-list-bullet class="h-4 w-4" />
                        Daftar Destinasi
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
                            <span class="text-xs font-semibold uppercase text-zinc-400">Nama Negara</span>
                            <p class="mt-1 text-base font-semibold text-zinc-800">{{ $destinasi->nama }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Kode Negara</span>
                                <p class="mt-1 font-mono text-sm uppercase text-zinc-700">{{ $destinasi->kode }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Benua</span>
                                <p class="mt-1">{{ $destinasi->benua ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Dibuat</span>
                                <p class="mt-1">{{ $destinasi->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-zinc-400">Diperbarui</span>
                                <p class="mt-1">{{ $destinasi->updated_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
