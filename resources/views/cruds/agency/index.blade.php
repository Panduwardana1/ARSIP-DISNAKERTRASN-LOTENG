@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Agency')
@section('titlePageContent', 'Daftar Agency Penempatan')

@section('content')
    <div class="flex h-full flex-col font-inter">
        <main class="flex-1 px-4 py-4">
            <header class="flex items-center justify-start pb-6">
                <h2 class="font-semibold text-3xl">Agency</h2>
            </header>
            <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
                <form method="GET" action="{{ route('sirekap.agency.index') }}" class="relative w-full max-w-md"
                    role="search">
                    @foreach (request()->except('q', 'page') as $queryName => $queryValue)
                        @if (is_scalar($queryValue))
                            <input type="hidden" name="{{ $queryName }}" value="{{ $queryValue }}">
                        @endif
                    @endforeach

                    <span class="pointer-events-none absolute inset-y-0 left-3 inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.9 14.32a7 7 0 111.414-1.414l3.39 3.39a1 1 0 01-1.414 1.415l-3.39-3.39zM14 9a5 5 0 11-10 0 5 5 0 0110 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>

                    <input id="search" name="q" type="search" placeholder="Cari nama, negara, atau kota agency"
                        value="{{ request('q') }}"
                        class="peer w-full rounded-md border border-zinc-300 bg-zinc-100 py-2 pl-9 pr-9 text-sm text-zinc-700 placeholder:text-zinc-400 hover:border-zinc-400 focus:border-emerald-500 focus:outline-none focus:ring-0" />

                    @if (filled(request('q')))
                        <a href="{{ route('sirekap.agency.index', request()->except('q', 'page')) }}"
                            class="absolute inset-y-0 right-2 my-auto inline-flex items-center rounded-full px-2 text-xs text-zinc-500 hover:text-zinc-800"
                            aria-label="Bersihkan pencarian">
                            Clear
                        </a>
                    @endif
                </form>

                <a href="{{ route('sirekap.agency.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    <x-heroicon-s-plus class="h-5 w-5" />
                    Tambah Agency
                </a>
            </div>

            <div class="mx-auto max-w-full space-y-6">
                @if (session('success'))
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('db'))
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ $errors->first('db') }}
                    </div>
                @endif

                @if ($errors->has('app'))
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-700">
                        {{ $errors->first('app') }}
                    </div>
                @endif

                @if ($errors->has('destroy'))
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
                        {{ $errors->first('destroy') }}
                    </div>
                @endif

                <div class="rounded-md border border-zinc-200 bg-white">
                    @if ($agencies->count())
                        <div class="hidden overflow-x-auto md:block">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                <thead>
                                    <tr
                                        class="bg-zinc-100 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Agency</th>
                                        <th class="px-6 py-4">Lokasi Penempatan</th>
                                        <th class="px-6 py-4">Lowongan</th>
                                        <th class="px-6 py-4">Relasi</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($agencies as $agency)
                                        <tr class="transition hover:bg-zinc-50/70">
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $agency->nama }}</div>
                                                <div class="mt-1 text-xs text-zinc-500">
                                                    Ditambahkan {{ $agency->created_at?->diffForHumans() ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="text-sm font-medium text-zinc-800">{{ $agency->country }}</div>
                                                <div class="text-xs text-zinc-500">Kota {{ $agency->kota }}</div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="text-xs text-zinc-500">
                                                    {{ $agency->lowongan }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="space-y-1 text-xs text-zinc-500">
                                                    <div>
                                                        <span class="font-semibold text-zinc-700">Perusahaan:</span>
                                                        {{ $agency->perusahaans_count }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold text-zinc-700">CPMI:</span>
                                                        {{ $agency->tenaga_kerjas_count ?? 0 }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('sirekap.agency.show', $agency) }}"
                                                        class="inline-flex items-center justify-center rounded-md bg-blue-500 px-2 py-1.5 text-xs font-medium text-blue-50 transition hover:bg-blue-600"
                                                        aria-label="Lihat detail {{ $agency->nama }}">
                                                        <x-heroicon-o-eye class="h-4 w-4" />
                                                    </a>
                                                    <a href="{{ route('sirekap.agency.edit', $agency) }}"
                                                        class="inline-flex items-center justify-center rounded-md bg-amber-500 px-2 py-1.5 text-xs font-medium text-amber-50 transition hover:bg-amber-600"
                                                        aria-label="Ubah data {{ $agency->nama }}">
                                                        <x-heroicon-o-pencil-square class="h-4 w-4" />
                                                    </a>
                                                    <x-modal-delete :action="route('sirekap.agency.destroy', $agency)" title="Hapus Agency"
                                                        message="Data agency akan dihapus. Pastikan tidak terhubung dengan data lain.">
                                                    </x-modal-delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-4 px-4 py-5 md:hidden">
                            @foreach ($agencies as $agency)
                                <article class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
                                    <header class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-zinc-900">{{ $agency->nama }}</h3>
                                            <p class="text-xs text-zinc-500">
                                                {{ $agency->country }} • {{ $agency->kota }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('sirekap.agency.show', $agency) }}"
                                                class="inline-flex items-center justify-center rounded-md bg-blue-500 p-1.5 text-xs font-medium text-blue-50 transition hover:bg-blue-600"
                                                aria-label="Detail {{ $agency->nama }}">
                                                <x-heroicon-o-eye class="h-4 w-4" />
                                            </a>
                                            <a href="{{ route('sirekap.agency.edit', $agency) }}"
                                                class="inline-flex items-center justify-center rounded-md bg-amber-500 p-1.5 text-xs font-medium text-amber-50 transition hover:bg-amber-600"
                                                aria-label="Ubah {{ $agency->nama }}">
                                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                                            </a>
                                        </div>
                                    </header>

                                    <dl class="mt-4 space-y-3 text-xs text-zinc-500">
                                        <div>
                                            <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Lowongan</dt>
                                            <dd class="mt-1 text-sm text-zinc-700">{{ $agency->lowongan }}</dd>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Perusahaan
                                                </dt>
                                                <dd class="mt-1 text-sm text-zinc-700">{{ $agency->perusahaans_count }}
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-[11px] uppercase tracking-wide text-zinc-400">CPMI</dt>
                                                <dd class="mt-1 text-sm text-zinc-700">
                                                    {{ $agency->tenaga_kerjas_count ?? 0 }}
                                                </dd>
                                            </div>
                                        </div>
                                        <div>
                                            <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Ditambahkan</dt>
                                            <dd class="mt-1 text-sm text-zinc-700">
                                                {{ $agency->created_at?->translatedFormat('d M Y') ?? '-' }}
                                            </dd>
                                        </div>
                                    </dl>

                                    <div class="mt-4">
                                        <x-modal-delete :action="route('sirekap.agency.destroy', $agency)" title="Hapus Agency"
                                            message="Data agency akan dihapus. Pastikan tidak terhubung dengan data lain.">
                                        </x-modal-delete>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data agency penempatan.
                            <a href="{{ route('sirekap.agency.create') }}"
                                class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @endif
                </div>

                @if ($agencies instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $agencies->firstItem() ?? 0 }} - {{ $agencies->lastItem() ?? 0 }} dari
                            {{ $agencies->total() }} agency
                        </div>
                        {{-- <div class="flex justify-center sm:justify-end">
                            {{ $agencies->withQueryString()->links('components.pagination.simple') }}
                        </div> --}}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
