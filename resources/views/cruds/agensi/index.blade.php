@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Daftar Agensi')

@section('headerActions')
    <a href="{{ route('disnakertrans.agensi.create') }}"
        class="inline-flex items-center gap-2 rounded-md border border-teal-200 bg-teal-600 px-3 py-2 text-sm font-semibold text-white hover:bg-teal-500">
        <x-heroicon-o-plus class="h-5 w-5" />
        Tambah
    </a>
@endsection

@section('content')
    <div class="max-w-full w-full px-4 py-6">
        <div class="mx-auto w-full max-w-4xl space-y-6">
            @if (session('success'))
                <div class="rounded-md border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-zinc-200">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <form action="{{ route('disnakertrans.agensi.index') }}" method="GET" class="w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <input type="search" name="search" placeholder="Cari nama atau lokasi"
                                value="{{ request('search') }}"
                                class="w-full md:w-64 rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                            @if (request()->filled('search'))
                                <a href="{{ route('disnakertrans.agensi.index') }}"
                                    class="rounded-md border border-zinc-200 px-3 py-2 text-sm text-zinc-600 hover:bg-zinc-100">
                                    Reset
                                </a>
                            @endif
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-3 py-2 text-sm font-semibold text-white hover:bg-teal-500 focus:outline-none">
                                <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto w-auto">
                    <table class="min-w-max w-full text-sm text-zinc-600 border border-zinc-200 overflow-hidden rounded-lg">
                        <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Nama Agensi</th>
                                <th class="px-4 py-3 text-left">Lokasi</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200">
                            @forelse ($agensi as $item)
                                <tr class="hover:bg-zinc-50">
                                    <td class="px-4 py-3">
                                        {{ $agensi->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-zinc-900">
                                        {{ $item->nama_agensi }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->lokasi ? \Illuminate\Support\Str::limit($item->lokasi, 80) : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('disnakertrans.agensi.show', $item) }}"
                                                class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-2 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                                                title="Lihat {{ $item->nama_agensi }}">
                                                <x-heroicon-o-eye class="h-4 w-4" />
                                            </a>
                                            <a href="{{ route('disnakertrans.agensi.edit', $item) }}"
                                                class="inline-flex items-center gap-1 rounded-md bg-amber-500 px-2 py-2 text-xs font-semibold text-white hover:bg-amber-600"
                                                title="Edit {{ $item->nama_agensi }}">
                                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                                            </a>
                                            {{-- <x-modal-confirm-delete :action="route('disnakertrans.agensi.destroy', $item)">
                                                <button type="button"
                                                    class="inline-flex items-center rounded-md bg-rose-600 px-2 py-2 text-xs font-semibold text-white hover:bg-rose-700"
                                                    title="Hapus {{ $item->nama_agensi }}">
                                                    <x-heroicon-o-trash class="h-4 w-4" />
                                                </button>
                                            </x-modal-confirm-delete> --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500">
                                        Belum ada data agensi yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($agensi->hasPages())
                    <div class="mt-6 flex flex-col items-center justify-between gap-3 text-sm text-zinc-500 md:flex-row">
                        <div>
                            Menampilkan
                            <span class="font-semibold text-zinc-700">{{ $agensi->firstItem() }}</span>
                            hingga
                            <span class="font-semibold text-zinc-700">{{ $agensi->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-zinc-700">{{ $agensi->total() }}</span>
                            data
                        </div>
                        {{ $agensi->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
