@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Daftar P3MI')

@section('content')
    <div class="max-w-full w-full">
        <div class="mx-auto w-full max-w-full space-y-6">
            @if (session('success'))
                <div class="rounded-md border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class=" bg-white p-6 shadow-sm ring-1 ring-zinc-200">

                <div class="flex items-center justify-between">
                    {{-- Pencarion --}}
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <form action="{{ route('disnakertrans.perusahaan.index') }}" method="GET" class="w-full md:w-auto font-inter">
                            <div class="flex items-center gap-2">
                                <input type="search" name="search" placeholder="Cari nama, email, atau pimpinan"
                                    value="{{ request('search') }}"
                                    class="w-full md:w-72 rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                                @if (request()->filled('search'))
                                    <a href="{{ route('disnakertrans.perusahaan.index') }}"
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
                    {{-- button action --}}
                    <div class="flex items-center gap-2">
                        <a href="#"
                            class="flex items-center gap-1 py-1 px-2 font-manrope font-semibold text-md border border-neutral-300 bg-neutral-100 text-neutral-700 hover:bg-neutral-200 hover:border-neutral-400 transition-colors ease-in rounded-md">
                            <x-heroicon-o-document-arrow-up class="h-5 w-5" />
                            import
                        </a>
                        <a href="{{ route('disnakertrans.pekerja.create') }}"
                            class="flex items-center gap-1 py-1 px-2 font-manrope font-semibold text-md border border-neutral-300 bg-neutral-100 text-neutral-700 hover:bg-neutral-200 hover:border-neutral-400 transition-colors ease-in rounded-md">
                            <x-heroicon-o-plus class="h-5 w-5" />
                            Add
                        </a>
                    </div>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table
                        class="in-w-max w-full text-sm font-inter text-zinc-600 border border-zinc-200 overflow-hidden rounded-lg">
                        <thead class="bg-sky-600 text-zinc-50 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Nama Perusahaan</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Nama Pimpinan</th>
                                <th class="px-4 py-3 text-left">Telepon</th>
                                <th class="px-4 py-3 text-left">Alamat</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200">
                            @forelse ($perusahaan as $item)
                                <tr class="hover:bg-zinc-50 border-b">
                                    <td class="px-4 py-3">
                                        {{ $perusahaan->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-zinc-900">
                                        {{ $item->nama_perusahaan }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->email ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->nama_pimpinan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->no_telepon ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $item->alamat ? \Illuminate\Support\Str::limit($item->alamat, 60) : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('disnakertrans.perusahaan.show', $item) }}"
                                                class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-2 py-2 text-xs font-semibold text-white hover:bg-blue-700"
                                                title="Lihat {{ $item->nama_perusahaan }}">
                                                <x-heroicon-o-eye class="h-4 w-4" />
                                            </a>
                                            <a href="{{ route('disnakertrans.perusahaan.edit', $item) }}"
                                                class="inline-flex items-center gap-1 rounded-md bg-amber-500 px-2 py-2 text-xs font-semibold text-white hover:bg-amber-600"
                                                title="Edit {{ $item->nama_perusahaan }}">
                                                <x-heroicon-o-pencil-square class="h-4 w-4" />
                                            </a>
                                            {{-- <x-modal-confirm-delete :action="route('disnakertrans.perusahaan.destroy', $item)">
                                                <button type="button"
                                                    class="inline-flex items-center rounded-md bg-rose-600 px-2 py-2 text-xs font-semibold text-white hover:bg-rose-700"
                                                    title="Hapus {{ $item->nama_perusahaan }}">
                                                    <x-heroicon-o-trash class="h-4 w-4" />
                                                </button>
                                            </x-modal-confirm-delete> --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-sm text-zinc-500">
                                        Belum ada data perusahaan yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($perusahaan->hasPages())
                    <div class="mt-6 flex flex-col items-center justify-between gap-3 text-sm text-zinc-500 md:flex-row">
                        <div>
                            Menampilkan
                            <span class="font-semibold text-zinc-700">{{ $perusahaan->firstItem() }}</span>
                            hingga
                            <span class="font-semibold text-zinc-700">{{ $perusahaan->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-zinc-700">{{ $perusahaan->total() }}</span>
                            data
                        </div>
                        {{ $perusahaan->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
