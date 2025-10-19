@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Destinasi')
@section('titleContent', 'Negara Tujuan / Destinasi')

@section('content')
    <div class="flex h-full flex-col">
        <div class="border-b bg-white">
            <div
                class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 font-inter sm:flex-row sm:items-center sm:justify-between">
                <div class="flex w-full flex-col gap-3 sm:max-w-xl sm:flex-row sm:items-center sm:gap-4">
                    <x-search-data class="w-full" :action="route('sirekap.destinasi.index')" placeholder="Cari nama atau kode destinasi"
                        name="keyword" :value="$filters['keyword'] ?? ''" />

                    <form action="{{ route('sirekap.destinasi.index') }}" method="GET"
                        class="flex items-center gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-600 transition focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400/20">
                        <input type="hidden" name="keyword" value="{{ $filters['keyword'] ?? '' }}">
                        <label class="flex items-center gap-2">
                            <span class="hidden text-xs font-semibold uppercase text-zinc-400 sm:block">Benua</span>
                            <select name="benua" onchange="this.form.submit()"
                                class="w-full min-w-[8rem] bg-transparent text-sm font-medium text-zinc-700 focus:outline-none">
                                <option value="">Semua</option>
                                @foreach ($availableBenua as $itemBenua)
                                    <option value="{{ $itemBenua }}" @selected(($filters['benua'] ?? '') === $itemBenua)>
                                        {{ $itemBenua }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>

                <x-button href="{{ route('sirekap.destinasi.create') }}" color="teal" class="justify-center items-center">
                    <x-heroicon-o-plus class="h-5 w-5" />
                    Tambah
                </x-button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4 font-inter">
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

                <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">
                    @if ($destinasis->count())
                        <div class="hidden md:block">
                            <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-600">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                                        <th class="px-6 py-4">Negara</th>
                                        <th class="px-6 py-4">Kode</th>
                                        <th class="px-6 py-4">Benua</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    @foreach ($destinasis as $destinasi)
                                        <tr>
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-semibold text-zinc-800">{{ $destinasi->nama }}</div>
                                                <div class="text-xs font-semibold text-zinc-400">Ditambahkan:
                                                    {{ $destinasi->created_at?->format('d M Y') ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                <span class="font-inter text-sm font-semibold uppercase text-zinc-700">
                                                    {{ $destinasi->kode }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 align-top">
                                                {{ $destinasi->benua ?? 'None' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('sirekap.destinasi.show', $destinasi) }}"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-zinc-100 px-3 py-1.5 text-xs font-medium text-zinc-600 transition hover:bg-zinc-200">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('sirekap.destinasi.edit', $destinasi) }}"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:bg-amber-200">
                                                        Ubah
                                                    </a>
                                                    <form action="{{ route('sirekap.destinasi.destroy', $destinasi) }}"
                                                        method="POST" class="inline-flex"
                                                        onsubmit="return confirm('Hapus destinasi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center rounded-md border border-transparent bg-rose-100 px-3 py-1.5 text-xs font-medium text-rose-700 transition hover:bg-rose-200">
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

                        <div class="space-y-4 p-4 md:hidden">
                            @foreach ($destinasis as $destinasi)
                                <article class="rounded-lg border border-zinc-200 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-base font-semibold text-zinc-800">{{ $destinasi->nama }}</p>
                                            <p class="text-xs font-mono uppercase text-zinc-500">{{ $destinasi->kode }}</p>
                                        </div>
                                        <span
                                            class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-600">
                                            {{ $destinasi->benua ?? 'Benua?' }}
                                        </span>
                                    </div>

                                    <div class="mt-3 text-xs text-zinc-500">
                                        Dibuat: {{ $destinasi->created_at?->format('d M Y') ?? '-' }}
                                    </div>

                                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                                        <a href="{{ route('sirekap.destinasi.show', $destinasi) }}"
                                            class="inline-flex items-center rounded-md border border-transparent bg-zinc-100 px-3 py-1.5 font-medium text-zinc-600 transition hover:bg-zinc-200">
                                            Detail
                                        </a>
                                        <a href="{{ route('sirekap.destinasi.edit', $destinasi) }}"
                                            class="inline-flex items-center rounded-md border border-transparent bg-amber-100 px-3 py-1.5 font-medium text-amber-700 transition hover:bg-amber-200">
                                            Ubah
                                        </a>
                                        <form action="{{ route('sirekap.destinasi.destroy', $destinasi) }}" method="POST"
                                            class="inline-flex"
                                            onsubmit="return confirm('Hapus destinasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center rounded-md border border-transparent bg-rose-100 px-3 py-1.5 font-medium text-rose-700 transition hover:bg-rose-200">
                                                Hapus
                                            </button>
                                        </form>
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
                        class="flex flex-col gap-3 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-center sm:text-left">
                            Menampilkan {{ $destinasis->firstItem() ?? 0 }} -
                            {{ $destinasis->lastItem() ?? 0 }}
                            dari {{ $destinasis->total() }} destinasi
                        </div>
                        <div class="flex justify-center sm:justify-end">
                            <div class="rounded-xl border border-zinc-200 bg-white px-3 py-1.5">
                                {{ $destinasis->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
