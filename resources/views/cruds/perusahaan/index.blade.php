@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI')
@section('titleContent', 'P3MI')
@section('titlePageContent', 'Daftar P3MI')

@section('content')
    <div class="flex h-full flex-col font-inter">
        {{-- Body --}}
        <main class="flex-1 px-4 py-6">
            {{-- search --}}
            <div class="flex items-center justify-between pb-4 w-full">
                <form method="GET" action="{{ route('sirekap.perusahaan.index') }}" class="relative w-full max-w-md"
                    role="search">
                    @foreach (request()->except('keyword', 'page') as $queryName => $queryValue)
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

                    <input id="search" name="keyword" type="search" placeholder="Cari nama P3MI atau pimpinan"
                        value="{{ old('keyword', $keyword ?? '') }}"
                        class="peer w-full rounded-md border border-zinc-300 bg-zinc-100 py-2 pl-9 pr-9 text-sm text-zinc-700 placeholder:text-zinc-400 hover:border-zinc-400 active:outline-none focus:outline-none" />

                    @if (!empty($keyword))
                        <a href="{{ route('sirekap.perusahaan.index', request()->except('keyword', 'page')) }}"
                            class="absolute inset-y-0 right-2 my-auto inline-flex items-center rounded-full px-2 text-xs text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white"
                            aria-label="Bersihkan">
                            Clear
                        </a>
                    @endif
                </form>

                {{-- button add --}}
                <div>
                    <a href="{{ route('sirekap.perusahaan.create') }}"
                        class="flex items-center gap-2 rounded-md bg-green-600 px-4 py-1.5 text-sm font-semibold text-white shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                        <x-heroicon-s-plus class="h-5 w-5" />
                        P3MI
                    </a>
                </div>
            </div>

            <div class="mx-auto max-w-full space-y-6">
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

                <div class="rounded-md border border-zinc-200 bg-white">
                    @if ($perusahaans->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Nama P3MI</th>
                                        <th class="px-6 py-4">Kontak</th>
                                        <th class="px-6 py-4">Alamat</th>
                                        <th class="px-6 py-4">Identitas Digital</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($perusahaans as $perusahaan)
                                        <tr class="transition hover:bg-zinc-50/70">
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $perusahaan->nama }}</div>
                                                <div class="text-xs text-zinc-500">
                                                    {{ $perusahaan->nama_pimpinan ?? 'Pimpinan belum diisi' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-medium text-zinc-700">{{ $perusahaan->email ?? '-' }}
                                                </div>
                                                <div class="text-xs text-zinc-500">{{ $perusahaan->nomor_hp ?? '-' }}</div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                @if ($perusahaan->alamat)
                                                    <div class="max-w-xs whitespace-pre-line text-sm text-zinc-600">
                                                        {{ \Illuminate\Support\Str::limit($perusahaan->alamat, 140) }}
                                                    </div>
                                                @else
                                                    <span class="text-xs text-zinc-400">Alamat belum diisi</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <div class="space-y-2 text-xs text-zinc-500">
                                                    @if ($perusahaan->gambar)
                                                        <img src="{{ Storage::url($perusahaan->gambar) }}"
                                                            alt="Logo {{ $perusahaan->nama }}"
                                                            class="h-10 w-10 rounded-md border border-zinc-200 object-cover"
                                                            onerror="this.style.display='none'">
                                                    @else
                                                        <span class="text-zinc-400">Logo belum tersedia</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top text-right">
                                                <div class="inline-flex items-center justify-end gap-2">
                                                    <a href="{{ route('sirekap.perusahaan.show', $perusahaan) }}"
                                                        class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                                                        class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                                        Ubah
                                                    </a>
                                                    <x-modal-delete :action="route('sirekap.perusahaan.destroy', $perusahaan)" title="Hapus P3MI">
                                                    </x-modal-delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-4 p-4 md:hidden">
                            @foreach ($perusahaans as $perusahaan)
                                <article class="rounded-xl border border-zinc-200 p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-zinc-800">{{ $perusahaan->nama }}</h3>
                                            <p class="text-xs text-zinc-500">
                                                {{ $perusahaan->nama_pimpinan ?? 'Pimpinan belum diisi' }}</p>
                                        </div>
                                    </div>

                                    <dl class="mt-3 space-y-3 text-xs text-zinc-500">
                                        <div>
                                            <dt class="uppercase tracking-wide text-[11px] text-zinc-400">Kontak</dt>
                                            <dd class="mt-1 text-sm font-medium text-zinc-700">
                                                {{ $perusahaan->email ?? '-' }}<br>
                                                <span
                                                    class="text-xs text-zinc-500">{{ $perusahaan->nomor_hp ?? '-' }}</span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="uppercase tracking-wide text-[11px] text-zinc-400">Alamat</dt>
                                            <dd class="mt-1 text-sm text-zinc-700">
                                                {{ $perusahaan->alamat ? \Illuminate\Support\Str::limit($perusahaan->alamat, 160) : 'Belum diisi' }}
                                            </dd>
                                        </div>
                                        <div class="space-y-2">
                                            <dt class="uppercase tracking-wide text-[11px] text-zinc-400">Identitas Digital
                                            </dt>
                                            <dd class="space-y-2">
                                                @if ($perusahaan->gambar)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ Storage::url($perusahaan->gambar) }}"
                                                            alt="Logo {{ $perusahaan->nama }}"
                                                            class="h-10 w-10 rounded-md border border-zinc-200 object-cover"
                                                            onerror="this.style.display='none'">
                                                        <span class="text-xs text-zinc-500">Logo</span>
                                                    </div>
                                                @endif
                                                @if ($perusahaan->icon_url)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ $perusahaan->icon_url }}"
                                                            alt="Icon {{ $perusahaan->nama }}"
                                                            class="h-10 w-10 rounded-md border border-zinc-200 object-cover"
                                                            onerror="this.style.display='none'">
                                                        <span
                                                            class="break-all text-xs text-zinc-500">{{ $perusahaan->icon }}</span>
                                                    </div>
                                                @endif
                                                @if (!$perusahaan->gambar && !$perusahaan->icon_url)
                                                    <span class="text-xs text-zinc-400">Belum ada identitas digital</span>
                                                @endif
                                            </dd>
                                        </div>
                                    </dl>

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <a href="{{ route('sirekap.perusahaan.show', $perusahaan) }}"
                                            class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                            Detail
                                        </a>
                                        <a href="{{ route('sirekap.perusahaan.edit', $perusahaan) }}"
                                            class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                            Ubah
                                        </a>
                                        <x-modal-delete :action="route('sirekap.perusahaan.destroy', $perusahaan)" title="Hapus P3MI">
                                        </x-modal-delete>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data perusahaan yang tersimpan.
                            <a href="{{ route('sirekap.perusahaan.create') }}"
                                class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @endif
                </div>

                @if ($perusahaans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $perusahaans->firstItem() ?? 0 }} - {{ $perusahaans->lastItem() ?? 0 }} dari
                            {{ $perusahaans->total() }} perusahaan
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $perusahaans->withQueryString()->links('components.pagination.simple') }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
