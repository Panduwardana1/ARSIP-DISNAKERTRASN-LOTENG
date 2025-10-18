@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | CPMI | Disnakertrans')
@section('titleContent', 'Daftar CPMI - Tenaga Kerja')

@section('content')
    <div class="flex h-full flex-col">
        <div class="border-b py-2 bg-white">
            <x-navbar-crud />
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6 font-inter">
            <div class="mx-auto max-w-6xl space-y-4">
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

                {{-- <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-800">Data Calon Pekerja Migran</h2>
                        <p class="text-sm text-zinc-500">Kelola data CPMI, termasuk detail penempatan dan riwayat.</p>
                    </div>
                    <div
                        class="flex w-full flex-col gap-2 sm:flex-row sm:items-center sm:justify-between lg:w-auto lg:justify-end">
                        <x-search-data class="w-full sm:max-w-xs lg:w-72" placeholder="Cari nama atau NIK" :action="route('sirekap.cpmi.index')"
                            name="keyword" />
                        <a href="{{ route('sirekap.cpmi.create') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-amber-500 bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1 sm:w-auto">
                            <x-heroicon-o-plus class="mr-2 h-4 w-4" />
                            Tambah CPMI
                        </a>
                    </div>
                </div> --}}

                <div class="rounded-3xl border border-zinc-100 bg-white shadow-sm">
                    @if ($tenagaKerjas->count())
                        <div class="divide-y divide-zinc-200 lg:hidden">
                            @foreach ($tenagaKerjas as $tenagaKerja)
                                <article class="space-y-3 p-4">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <h3 class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</h3>
                                            <p class="text-xs text-zinc-500">{{ $tenagaKerja->gender }}</p>
                                        </div>
                                        <div class="rounded-xl bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600">
                                            NIK: {{ $tenagaKerja->nik }}
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3 text-sm text-zinc-600">
                                        <div>
                                            <span class="text-xs uppercase tracking-wide text-zinc-400">Domisili</span>
                                            <p>{{ $tenagaKerja->desa }}</p>
                                            <p class="text-xs text-zinc-500">Kec. {{ $tenagaKerja->kecamatan }}</p>
                                        </div>
                                        <div>
                                            <span class="text-xs uppercase tracking-wide text-zinc-400">Pendidikan</span>
                                            <p>{{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}</p>
                                            @if (optional($tenagaKerja->pendidikan)->level)
                                                <p class="text-xs text-zinc-500">
                                                    Level {{ $tenagaKerja->pendidikan->level }}
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-xs uppercase tracking-wide text-zinc-400">Lowongan</span>
                                            <p>{{ optional($tenagaKerja->lowongan)->nama ?? '-' }}</p>
                                            @if (optional($tenagaKerja->lowongan?->agensi)->nama)
                                                <p class="text-xs text-zinc-500">
                                                    {{ $tenagaKerja->lowongan->agensi->nama }}
                                                </p>
                                            @endif
                                        </div>
                                        @if ($tenagaKerja->email)
                                            <div>
                                                <span class="text-xs uppercase tracking-wide text-zinc-400">Email</span>
                                                <p>{{ $tenagaKerja->email }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap">
                                        <a href="{{ route('sirekap.cpmi.show', $tenagaKerja) }}"
                                            class="inline-flex w-full items-center justify-center rounded-xl border border-transparent bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-200 sm:w-auto">
                                            Detail
                                        </a>
                                        <a href="{{ route('sirekap.cpmi.edit', $tenagaKerja) }}"
                                            class="inline-flex w-full items-center justify-center rounded-xl border border-transparent bg-amber-100 px-3 py-2 text-sm font-medium text-amber-700 transition hover:bg-amber-200 sm:w-auto">
                                            Ubah
                                        </a>
                                        <form action="{{ route('sirekap.cpmi.destroy', $tenagaKerja) }}" method="POST"
                                            onsubmit="return confirm('Hapus data tenaga kerja ini?')"
                                            class="w-full sm:w-auto">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex w-full items-center justify-center rounded-xl border border-transparent bg-rose-100 px-3 py-2 text-sm font-medium text-rose-700 transition hover:bg-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="hidden lg:block">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                    <thead class="bg-zinc-100/80 text-xs uppercase tracking-wide text-zinc-500">
                                        <tr>
                                            <th class="px-4 py-3 b  text-left">
                                                <input type="checkbox"
                                                    class="rounded border-zinc-300 text-amber-500 focus:ring-amber-500">
                                            </th>
                                            <th class="px-4 py-3 text-left">Nama</th>
                                            <th class="px-4 py-3 text-left">Identitas</th>
                                            <th class="px-4 py-3 text-left">Domisili</th>
                                            <th class="px-4 py-3 text-left">Pendidikan</th>
                                            <th class="px-4 py-3 text-left">Lowongan</th>
                                            <th class="px-4 py-3 text-left">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200">
                                        @foreach ($tenagaKerjas as $tenagaKerja)
                                            <tr class="transition hover:bg-zinc-50/80">
                                                <td class="px-4 py-3 align-top">
                                                    <input type="checkbox"
                                                        class="rounded border-zinc-300 text-amber-500 focus:ring-amber-500">
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="font-semibold text-zinc-800">{{ $tenagaKerja->nama }}</div>
                                                    <div class="text-xs text-zinc-500">{{ $tenagaKerja->gender }}</div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-xs text-zinc-500 uppercase">NIK</div>
                                                    <div class="font-mono text-sm text-zinc-700">{{ $tenagaKerja->nik }}
                                                    </div>
                                                    @if ($tenagaKerja->email)
                                                        <div class="mt-1 text-xs text-zinc-500">{{ $tenagaKerja->email }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-600">
                                                    <div>{{ $tenagaKerja->desa }}</div>
                                                    <div class="text-xs text-zinc-500">Kec. {{ $tenagaKerja->kecamatan }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-sm text-zinc-700">
                                                        {{ optional($tenagaKerja->pendidikan)->nama ?? '-' }}
                                                    </div>
                                                    @if (optional($tenagaKerja->pendidikan)->level)
                                                        <div class="text-xs text-zinc-500">
                                                            {{ $tenagaKerja->pendidikan->level }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-sm text-zinc-700">
                                                        {{ optional($tenagaKerja->lowongan)->nama ?? '-' }}
                                                    </div>
                                                    @if (optional($tenagaKerja->lowongan?->agensi)->nama)
                                                        <div class="text-xs text-zinc-500">
                                                            {{ $tenagaKerja->lowongan->agensi->nama }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <a href="{{ route('sirekap.cpmi.show', $tenagaKerja) }}"
                                                            class="inline-flex items-center rounded-xl border border-transparent bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 transition hover:bg-zinc-200">
                                                            Detail
                                                        </a>
                                                        <a href="{{ route('sirekap.cpmi.edit', $tenagaKerja) }}"
                                                            class="inline-flex items-center rounded-xl border border-transparent bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-200">
                                                            Ubah
                                                        </a>
                                                        <form action="{{ route('sirekap.cpmi.destroy', $tenagaKerja) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus data tenaga kerja ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex items-center rounded-xl border border-transparent bg-rose-100 px-3 py-1.5 text-xs font-medium text-rose-700 transition hover:bg-rose-200">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-12 text-center text-sm text-zinc-500">
                            Belum ada data CPMI yang tersimpan.
                            <a href="{{ route('sirekap.cpmi.create') }}"
                                class="ml-1 font-medium text-amber-600 underline underline-offset-4">Tambah sekarang</a>.
                        </div>
                    @endif
                </div>

                @if ($tenagaKerjas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $tenagaKerjas->firstItem() ?? 0 }} - {{ $tenagaKerjas->lastItem() ?? 0 }} dari
                            {{ $tenagaKerjas->total() }} CPMI
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-2 py-1">
                                {{ $tenagaKerjas->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
