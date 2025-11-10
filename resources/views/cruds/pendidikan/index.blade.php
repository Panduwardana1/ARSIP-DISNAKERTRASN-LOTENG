@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Pendidikan')
@section('Title', 'Pendidikan')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Referensi Pendidikan</p>
                <h1 class="text-2xl font-semibold text-zinc-900">Daftar Pendidikan</h1>
                <p class="text-sm text-zinc-600">Kelola kode dan label pendidikan agar pilihan di form CPMI tetap konsisten.</p>
            </div>
            <a href="{{ route('sirekap.pendidikan.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                <x-heroicon-o-plus class="h-5 w-5" />
                Tambah Pendidikan
            </a>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <form method="GET" action="{{ route('sirekap.pendidikan.index') }}" class="flex w-full items-center gap-2 sm:w-auto">
                <div class="relative flex-1 sm:w-72">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-zinc-400">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                    </span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari kode atau label pendidikan..."
                        class="w-full rounded-md border border-zinc-300 bg-white px-10 py-2 text-sm text-zinc-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                    >
                </div>
                <button
                    type="submit"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                >
                    Cari
                </button>
                @if ($search !== '')
                    <a
                        href="{{ route('sirekap.pendidikan.index') }}"
                        class="text-xs font-medium text-zinc-500 underline underline-offset-4"
                    >
                        Reset
                    </a>
                @endif
            </form>

            <div class="flex flex-wrap gap-2 text-xs text-zinc-500">
                <span class="rounded-full bg-zinc-100 px-3 py-1">
                    Total: {{ $pendidikans->total() }} pendidikan
                </span>
                <span class="rounded-full bg-zinc-100 px-3 py-1">
                    Digunakan oleh {{ $pendidikans->sum('tenaga_kerjas_count') }} CPMI
                </span>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @error('app')
            <div class="rounded-md border border-rose-200 bg-rose-50 px-5 py-3 text-sm text-rose-700">
                {{ $message }}
            </div>
        @enderror

        <div class="overflow-hidden rounded-lg border border-zinc-200">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead class="bg-slate-800 text-left text-xs font-semibold uppercase tracking-wide text-white">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Label</th>
                        <th class="px-4 py-3">Digunakan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 bg-white text-zinc-800">
                    @forelse ($pendidikans as $pendidikan)
                        <tr class="hover:bg-zinc-50/70">
                            <td class="px-4 py-4 text-sm text-zinc-500">
                                {{ $loop->iteration + ($pendidikans->firstItem() - 1) }}
                            </td>
                            <td class="px-4 py-4 font-semibold uppercase tracking-wide text-zinc-900">
                                {{ $pendidikan->nama }}
                            </td>
                            <td class="px-4 py-4">
                                {{ $pendidikan->label }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700">
                                    {{ $pendidikan->tenaga_kerjas_count }} Tenaga Kerja
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a
                                        href="{{ route('sirekap.pendidikan.show', $pendidikan) }}"
                                        class="rounded-md border border-zinc-200 px-2.5 py-1.5 text-xs font-semibold text-zinc-700 transition hover:border-indigo-400 hover:text-indigo-600"
                                    >
                                        Detail
                                    </a>
                                    <a
                                        href="{{ route('sirekap.pendidikan.edit', $pendidikan) }}"
                                        class="rounded-md border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-xs font-semibold text-amber-700 transition hover:border-amber-300 hover:bg-amber-100"
                                    >
                                        Ubah
                                    </a>
                                    <x-modal-delete
                                        :action="route('sirekap.pendidikan.destroy', $pendidikan)"
                                        :title="'Hapus ' . $pendidikan->label"
                                        :message="'Data pendidikan ' . $pendidikan->label . ' akan dihapus permanen.'"
                                    >
                                        <button
                                            type="button"
                                            class="rounded-md border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-100"
                                        >
                                            Hapus
                                        </button>
                                    </x-modal-delete>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm text-zinc-500">
                                Data pendidikan belum tersedia. Tambah data baru untuk mulai mengelola referensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pendidikans->hasPages())
            <div class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                <span>
                    Menampilkan {{ $pendidikans->firstItem() ?? 0 }} - {{ $pendidikans->lastItem() ?? 0 }} dari {{ $pendidikans->total() }} pendidikan
                </span>
                <div class="flex justify-center sm:justify-end">
                    {{ $pendidikans->onEachSide(1)->links('components.pagination.rounded') }}
                </div>
            </div>
        @endif
    </section>
@endsection
