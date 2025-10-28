@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Destinasi')
@section('titlePageContent', 'Daftar Destinasi')

{{-- Content page --}}
@section('content')
    <div class="flex h-full flex-col font-inter">
        {{-- Body --}}
        <main class="flex-1 px-4 py-6">
            <div class="flex items-center justify-between pb-4 w-full">
                {{-- search --}}
                <form method="GET" action="{{ route('sirekap.destinasi.index') }}" class="relative w-full max-w-md"
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

                    <input id="search" name="keyword" type="search" placeholder="Cari nama atau kode destinasi"
                        value="{{ old('keyword', $keyword ?? '') }}"
                        class="peer w-full rounded-md border border-zinc-300 bg-zinc-100 py-2 pl-9 pr-9 text-sm text-zinc-700 placeholder:text-zinc-400 hover:border-zinc-400 active:outline-none focus:outline-none" />

                    @if (!empty($keyword))
                        <a href="{{ route('sirekap.destinasi.index', request()->except('keyword', 'page')) }}"
                            class="absolute inset-y-0 right-2 my-auto inline-flex items-center rounded-full px-2 text-xs text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white"
                            aria-label="Bersihkan">
                            Clear
                        </a>
                    @endif
                </form>

                {{-- button add --}}
                <a href="{{ route('sirekap.destinasi.create') }}"
                    class="flex items-center gap-2 rounded-md bg-green-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                    <x-heroicon-s-plus class="h-5 w-5" />
                    Tambah
                </a>
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

                <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">
                    @if ($destinasis->count())
                        <div class="hidden md:block">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Negara</th>
                                        <th class="px-6 py-4">Kode</th>
                                        <th class="px-6 py-4">Benua</th>
                                        <th class="px-6 py-4">Ditambahkan</th>
                                        <th class="px-6 py-4 text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($destinasis as $destinasi)
                                        <tr class="transition hover:bg-zinc-50/70">
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $destinasi->nama }}</div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <span
                                                    class="rounded-md bg-sky-100 px-3 py-1 text-xs font-semibold uppercase text-sky-700">
                                                    {{ $destinasi->kode ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-700">
                                                {{ $destinasi->benua ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 align-top text-sm text-zinc-600">
                                                {{ $destinasi->created_at?->translatedFormat('d M Y') ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 align-top text-right">
                                                <div class="inline-flex items-center justify-end gap-2">
                                                    <a href="{{ route('sirekap.destinasi.show', $destinasi) }}"
                                                        class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.destinasi.edit', $destinasi) }}"
                                                        class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                                        Ubah
                                                    </a>
                                                    <x-modal-delete :action="route('sirekap.destinasi.destroy', $destinasi)" title="Hapus Destinasi">
                                                    </x-modal-delete>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="space-y-4 p-4 md:hidden">
                            @foreach ($destinasis as $destinasi)
                                <article class="rounded-xl border border-zinc-200 p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-zinc-800">{{ $destinasi->nama }}</h3>
                                            <p class="text-xs text-zinc-500">Kode: <span
                                                    class="font-semibold uppercase text-zinc-700">{{ $destinasi->kode ?? '-' }}</span>
                                            </p>
                                        </div>
                                        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                            {{ $destinasi->benua ?? '-' }}
                                        </span>
                                    </div>

                                    <dl class="mt-4 space-y-3 text-xs text-zinc-500">
                                        <div>
                                            <dt class="text-[11px] uppercase tracking-wide text-zinc-400">Ditambahkan</dt>
                                            <dd class="mt-1 text-sm font-medium text-zinc-700">
                                                {{ $destinasi->created_at?->translatedFormat('d M Y') ?? '-' }}
                                            </dd>
                                        </div>
                                    </dl>

                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <a href="{{ route('sirekap.destinasi.show', $destinasi) }}"
                                            class="inline-flex items-center rounded-md bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-200">
                                            Detail
                                        </a>
                                        <a href="{{ route('sirekap.destinasi.edit', $destinasi) }}"
                                            class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-200">
                                            Ubah
                                        </a>
                                        <x-modal-delete :action="route('sirekap.destinasi.destroy', $destinasi)" title="Hapus Destinasi">
                                        </x-modal-delete>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="px-6 py-12 text-center text-sm text-zinc-500">
                            Belum ada data destinasi yang tersimpan.
                            <a href="{{ route('sirekap.destinasi.create') }}"
                                class="ml-1 font-medium text-emerald-600 underline underline-offset-4">
                                Tambah sekarang
                            </a>
                        </div>
                    @endif
                </div>

                @if ($destinasis instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div
                        class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $destinasis->firstItem() ?? 0 }} - {{ $destinasis->lastItem() ?? 0 }} dari
                            {{ $destinasis->total() }} destinasi
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            {{ $destinasis->withQueryString()->links('components.pagination.simple') }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
