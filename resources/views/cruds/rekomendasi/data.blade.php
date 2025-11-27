@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Data Rekomendasi')
@section('titlePageContent', 'Data Rekomendasi')
@section('description', 'Daftar rekomendasi yang sudah dibuat.')

@section('headerAction')
    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between w-full">
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('sirekap.rekomendasi.data') }}" class="relative w-full sm:max-w-xs font-inter group">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 group-focus-within:text-blue-600">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>
            <input type="search" name="q" value="{{ request('q', $search ?? '') }}" placeholder="Cari kode atau perusahaan"
                class="w-full pl-10 py-2 rounded-lg border border-zinc-200 bg-white text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none text-sm" />
        </form>

        {{-- Action Button --}}
        <div class="w-full sm:w-auto">
            <a href="{{ route('sirekap.rekomendasi.index') }}"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-all shadow-sm w-full sm:w-auto">
                <x-heroicon-o-plus class="w-5 h-5" />
                Tambah
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{-- Error Alert --}}
    @error('app')
        <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 flex items-center gap-2">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            {{ $message }}
        </div>
    @enderror

    {{-- Main Table Card --}}
    <div class="bg-white border border-zinc-200 rounded-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-zinc-600 border-b border-zinc-200">
                    <tr>
                        <th class="p-4 w-10">
                            <p class="text-xs font-semibold text-zinc-100 uppercase tracking-wider text-center">No</p>
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Kode Rekom
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Perusahaan
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Negara
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Total CPMI
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Author
                        </th>
                        <th class="py-4 px-4 text-end text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($rekomendasis as $rekomendasi)
                        @php
                            $perusahaanNames = $rekomendasi->items->pluck('perusahaan.nama')->filter()->unique();
                            if ($perusahaanNames->isEmpty()) {
                                $perusahaanNames = $rekomendasi->tenagaKerjas->pluck('perusahaan.nama')->filter()->unique();
                            }

                            $negaraNames = $rekomendasi->items->pluck('negara.nama')->filter()->unique();
                            if ($negaraNames->isEmpty()) {
                                $negaraNames = $rekomendasi->tenagaKerjas->pluck('negara.nama')->filter()->unique();
                            }

                            $totalCpmi = $rekomendasi->total ?? ($rekomendasi->tenaga_kerjas_count ?? $rekomendasi->tenagaKerjas->count());
                        @endphp
                        <tr class="group hover:bg-zinc-50/80 transition-colors duration-200">
                            {{-- Number --}}
                            <td class="p-4 align-middle text-center">
                                <span class="text-sm text-zinc-500">
                                    {{ ($rekomendasis->currentPage() - 1) * $rekomendasis->perPage() + $loop->iteration }}
                                </span>
                            </td>

                            {{-- Kode --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm font-semibold text-zinc-900">
                                    {{ $rekomendasi->kode }}
                                </p>
                            </td>

                            {{-- Tanggal --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-500">
                                    {{ optional($rekomendasi->tanggal)->translatedFormat('d F Y') }}
                                </p>
                            </td>

                            {{-- Perusahaan --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ $perusahaanNames->isNotEmpty() ? $perusahaanNames->implode(', ') : '-' }}
                                </p>
                            </td>

                            {{-- Negara --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ $negaraNames->isNotEmpty() ? $negaraNames->implode(', ') : '-' }}
                                </p>
                            </td>

                            {{-- Total --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm font-semibold text-zinc-900">
                                    {{ number_format($totalCpmi) }}
                                </p>
                            </td>

                            {{-- Author --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ optional($rekomendasi->author)->nama ?? '-' }}
                                </p>
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 align-middle text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('sirekap.rekomendasi.export', $rekomendasi) }}" target="_blank"
                                        class="p-1.5 text-blue-600 hover:text-blue-700 transition-colors"
                                        title="Lihat PDF">
                                        <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center text-zinc-500">
                                    <x-heroicon-o-document-text class="w-12 h-12 text-zinc-300 mb-3" />
                                    <p class="text-base font-medium">Belum ada rekomendasi</p>
                                    <p class="text-sm">Buat rekomendasi baru untuk melihat riwayat di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        @if ($rekomendasis->hasPages())
            <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3 sm:px-6">
                {{ $rekomendasis->onEachSide(2)->links() }}
            </div>
        @endif
    </div>
@endsection
