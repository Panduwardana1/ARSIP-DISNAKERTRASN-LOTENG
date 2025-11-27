@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | PMI')
@section('titlePageContent', 'Data PMI')
@section('description', 'Kelola data calon pekerja migran Indonesia.')

@section('headerAction')
    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between w-full">
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}" class="relative w-full sm:max-w-xs font-inter group">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 group-focus-within:text-blue-600">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>
            <input type="search" name="q" value="{{ $search ?? '' }}" placeholder="Cari nama atau NIK"
                class="w-full pl-10 py-2 rounded-lg border border-zinc-200 bg-white text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none text-sm" />
        </form>

        {{-- Action Button --}}
        <div class="w-full sm:w-auto">
            <a href="{{ route('sirekap.tenaga-kerja.create') }}"
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
                            Identitas
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Gender
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            P3MI
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Agency
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Pekerjaan
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Terdata
                        </th>
                        <th class="py-4 px-4 text-end text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($tenagaKerjas as $items)
                        <tr class="group hover:bg-zinc-50/80 transition-colors duration-200">
                            {{-- Number --}}
                            <td class="p-4 align-middle text-center">
                                <span class="text-sm text-zinc-500">
                                    {{ ($tenagaKerjas->currentPage() - 1) * $tenagaKerjas->perPage() + $loop->iteration }}
                                </span>
                            </td>

                            {{-- Identitas --}}
                            <td class="p-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('sirekap.tenaga-kerja.show', $items) }}">
                                        <img src="{{ asset('asset/images/default-profile.jpg') }}" alt="Profile"
                                            class="h-12 w-12 rounded-full border border-zinc-200 object-cover">
                                    </a>
                                    <span class="grid items-center">
                                        <p class="text-sm font-semibold text-zinc-900">{{ $items->nama }}</p>
                                        <p class="text-xs font-medium text-zinc-600">{{ $items->nik }}</p>
                                    </span>
                                </div>
                            </td>

                            {{-- Gender --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ $items->gender }}
                                </p>
                            </td>

                            {{-- P3MI --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ $items->perusahaan->nama ?? '-' }}
                                </p>
                            </td>

                            {{-- Agency --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ $items->agency->nama ?? '-' }}
                                </p>
                            </td>

                            {{-- Pekerjaan --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-900">
                                    {{ $items->agency->lowongan ?? '-' }}
                                </p>
                            </td>

                            {{-- Date --}}
                            <td class="p-4 align-middle">
                                <p class="text-sm text-zinc-500">
                                    {{ optional($items->created_at)->translatedFormat('d F Y') }}
                                </p>
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 align-middle text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('sirekap.tenaga-kerja.edit', $items) }}"
                                        class="p-1.5 text-zinc-500 hover:text-amber-700 transition-colors"
                                        title="Edit">
                                        <x-heroicon-o-pencil class="w-5 h-5" />
                                    </a>

                                    <x-modal-delete :action="route('sirekap.tenaga-kerja.destroy', $items)" :title="'Hapus Data'"
                                        :message="'Data ' . $items->nama . ' akan dihapus permanen.'" confirm-field="confirm_delete">
                                        <button type="button"
                                            class="p-1.5 text-zinc-500 hover:text-rose-600 transition-colors"
                                            title="Hapus">
                                            <x-heroicon-o-trash class="h-5 w-5" />
                                        </button>
                                    </x-modal-delete>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center text-zinc-500">
                                    <x-heroicon-o-user-circle class="w-12 h-12 text-zinc-300 mb-3" />
                                    <p class="text-base font-medium">Belum ada data PMI</p>
                                    <p class="text-sm">Silakan tambahkan data baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        @if ($tenagaKerjas->hasPages())
            <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3 sm:px-6">
                {{ $tenagaKerjas->onEachSide(2)->links() }}
            </div>
        @endif
    </div>
@endsection
