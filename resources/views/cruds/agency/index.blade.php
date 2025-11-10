@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Agency')
@section('titlePageContent', 'Daftar Agency')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-semibold text-zinc-900">Daftar Agency Penempatan</h2>
                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">
                    {{ $agencies instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $agencies->total() : $agencies->count() }}
                    data
                </span>
            </div>

            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                <form method="GET" action="{{ route('sirekap.agency.index') }}" class="flex flex-1 items-center gap-2 sm:flex-none">
                    @foreach (request()->except('q', 'page') as $param => $value)
                        @if (is_scalar($value))
                            <input type="hidden" name="{{ $param }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <label for="search-agency" class="relative flex-1 sm:w-64">
                        <span class="sr-only">Cari Agency</span>
                        <input
                            type="search"
                            id="search-agency"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari nama agency atau perusahaan..."
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
                        href="{{ route('sirekap.agency.index') }}"
                        class="text-xs font-medium text-zinc-500 underline underline-offset-4"
                    >
                        Reset
                    </a>
                @endif

                <a
                    href="{{ route('sirekap.agency.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                >
                    <x-heroicon-o-plus class="h-5 w-5" />
                    Tambah
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        @if ($errors->has('destroy'))
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                {{ $errors->first('destroy') }}
            </div>
        @endif

        <div class="flex flex-col">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-lg border border-zinc-200">
                        <table class="min-w-full divide-y divide-zinc-200">
                            <thead class="bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Agency</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Perusahaan</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Lowongan</th>
                                    <th scope="col" class="px-4 py-3.5 text-center text-sm font-semibold text-white">CPMI</th>
                                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-white">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 bg-white">
                                @forelse ($agencies as $agency)
                                    <tr class="hover:bg-zinc-50/70">
                                        <td class="px-4 py-4 text-sm text-zinc-700">
                                            <div class="font-semibold text-zinc-900">{{ $agency->nama }}</div>
                                            <p class="mt-1 text-xs text-zinc-500">
                                                {{ \Illuminate\Support\Str::limit($agency->keterangan ?? 'Belum ada catatan.', 80) }}
                                            </p>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-zinc-700">
                                            {{ $agency->perusahaan->nama ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-zinc-700">
                                            {{ $agency->lowongan ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-center text-sm font-semibold text-indigo-600">
                                            {{ $agency->tenaga_kerjas_count ?? 0 }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a
                                                    href="{{ route('sirekap.agency.show', $agency) }}"
                                                    class="rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 transition hover:border-indigo-400 hover:text-indigo-600"
                                                >
                                                    Detail
                                                </a>
                                                <a
                                                    href="{{ route('sirekap.agency.edit', $agency) }}"
                                                    class="rounded-md border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 transition hover:border-amber-300 hover:bg-amber-100"
                                                >
                                                    Ubah
                                                </a>
                                                <x-modal-delete
                                                    :action="route('sirekap.agency.destroy', $agency)"
                                                    :title="'Hapus ' . $agency->nama"
                                                    :message="'Data agency ' . $agency->nama . ' akan dihapus permanen.'"
                                                >
                                                    <button
                                                        type="button"
                                                        class="rounded-md border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-medium text-rose-600 transition hover:border-rose-300 hover:bg-rose-100"
                                                    >
                                                        Hapus
                                                    </button>
                                                </x-modal-delete>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-zinc-500">
                                            Belum ada data agency. <a href="{{ route('sirekap.agency.create') }}" class="font-medium text-indigo-600 underline">Tambah sekarang</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($agencies instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            <div class="flex flex-col gap-2 border-t border-zinc-200 pt-4 text-sm text-zinc-500 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    Menampilkan {{ $agencies->firstItem() ?? 0 }} - {{ $agencies->lastItem() ?? 0 }} dari {{ $agencies->total() }} agency
                </div>
                <div class="flex justify-center sm:justify-end">
                    {{ $agencies->onEachSide(1)->links('components.pagination.rounded') }}
                </div>
            </div>
        @endif
    </section>
@endsection
