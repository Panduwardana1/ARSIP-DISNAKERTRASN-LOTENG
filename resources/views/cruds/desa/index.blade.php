@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Desa/Kelurahan')
@section('titlePageContent', 'Daftar Desa/Kelurahan')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-semibold text-zinc-900">Referensi Desa/Kelurahan</h2>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-600">
                    {{ $desas instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $desas->total() : $desas->count() }}
                    data
                </span>
            </div>

            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                <form method="GET" action="{{ route('sirekap.desa.index') }}" class="flex flex-1 items-center gap-2 sm:flex-none">
                    @foreach (request()->except('q', 'page') as $param => $value)
                        @if (is_scalar($value))
                            <input type="hidden" name="{{ $param }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <label for="search-desa" class="relative flex-1 sm:w-64">
                        <span class="sr-only">Cari Desa/Kelurahan</span>
                        <input
                            type="search"
                            id="search-desa"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari nama desa/kecamatan..."
                            class="w-full rounded-md border border-zinc-300 px-4 py-2 text-sm text-zinc-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        >
                        <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-zinc-400">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                        </span>
                    </label>

                    <button
                        type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                    >
                        Cari
                    </button>
                </form>

                @if (filled(request('q')))
                    <a
                        href="{{ route('sirekap.desa.index') }}"
                        class="text-xs font-medium text-zinc-500 underline underline-offset-4"
                    >
                        Reset
                    </a>
                @endif

                <a
                    href="{{ route('sirekap.desa.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                >
                    <x-heroicon-o-plus class="h-5 w-5" />
                    Tambah Desa
                </a>
            </div>
        </div>

        @if (session('success'))
            <x-alert type="success" message="{{ session('success') }}" />
        @endif

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        @if ($errors->has('app'))
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                {{ $errors->first('app') }}
            </div>
        @endif

        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-lg border border-zinc-200">
                        <table class="min-w-full divide-y divide-zinc-200">
                            <thead class="bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Desa/Kelurahan</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Kecamatan</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-white">PMI</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 bg-white">
                                @forelse ($desas as $desa)
                                    <tr class="hover:bg-zinc-50/70">
                                        <td class="px-4 py-4 text-sm text-zinc-700">
                                            <div class="font-semibold text-zinc-900">{{ $desa->nama }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-zinc-700">
                                            {{ $desa->kecamatan?->nama ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-center text-sm font-semibold text-indigo-600">
                                            {{ $desa->tenaga_kerja_count ?? 0 }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a
                                                    href="{{ route('sirekap.desa.edit', $desa) }}"
                                                    class="rounded-md border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:border-amber-300 hover:bg-amber-100"
                                                >
                                                    Ubah
                                                </a>
                                                <x-modal-delete
                                                    :action="route('sirekap.desa.destroy', $desa)"
                                                    :title="'Hapus Data '"
                                                    :message="'Data desa ' . $desa->nama . ' akan dihapus permanen.'"
                                                >
                                                    <button type="button">
                                                        <x-heroicon-o-trash class="h-5 w-5" />
                                                    </button>
                                                </x-modal-delete>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500">
                                            Belum ada data desa/kelurahan. <a href="{{ route('sirekap.desa.create') }}" class="font-medium text-indigo-600 underline">Tambah sekarang</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-6">
            {{ $desas->onEachSide(2)->links() }}
        </div>
    </section>
@endsection
