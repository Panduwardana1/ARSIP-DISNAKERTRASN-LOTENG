@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Agency')

@section('titlePageContent', 'Agency')

@section('content')

    {{-- header action (search dan button) --}}
@section('headerAction')
    {{-- search --}}
    <div>
        <form method="GET" action="{{ route('sirekap.agency.index') }}" class="relative w-full max-w-sm font-inter">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>

            <input type="search" name="q" placeholder="Cari" value="{{ $search ?? '' }}"
                class="w-full pl-10 py-1.5 rounded-md bg-white border border-zinc-300
                text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none" />
        </form>
    </div>
    {{-- button --}}
    <div class="flex items-center">
        <a href="{{ route('sirekap.agency.create') }}"
            class="flex items-center px-3 gap-2 py-1.5 bg-blue-600 text-white rounded-md border hover:bg-blue-700">
            <x-heroicon-o-plus class="w-5 h-5" />
            Tambah
        </a>
    </div>
@endsection

<div class="relative flex flex-col w-full h-full rounded-lg overflow-hidden">
    <table class="w-full text-left table-auto min-w-max">
        <thead class="bg-blue-800 uppercase font-semibold">
            <tr>
                <th class="p-4 w-12">
                    <p class="text-sm font-normal leading-none text-white">
                        No
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Agency
                    </p>
                </th>
                <th class="p-4">
                    <p class="flex items-center gap-1 text-sm font-normal leading-none text-white">
                        <x-heroicon-o-information-circle class="w-4 h-4"
                            title="Distribusi P3MI yang terhubung dengan Agency" />
                        Perusahaan
                    </p>
                </th>
                <th class="p-4">
                    <p class="flex items-center gap-1 text-sm font-normal leading-none text-white">
                        <x-heroicon-o-information-circle class="w-4 h-4"
                            title="Distribusi PMI yang terhubung dengan Agency" />
                        PMI
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Terdata
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Aksi
                    </p>
                </th>
            </tr>
        </thead>
        <tbody class="border">
            @forelse ($agencies as $items)
                <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $items->id }}
                        </p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <div>
                                <a href="{{ route('sirekap.agency.show', $items) }}" >
                                    <x-heroicon-o-building-library class="w-9 h-9 text-zinc-500" />
                                </a>
                            </div>
                            <div class="grid items-center space-y-0">
                                <p class="text-[16px] font-medium text-zinc-800">
                                    {{ $items->nama }}
                                </p>
                                <p class="text-sm text-zinc-500">
                                    {{ $items->lowongan ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $items->perusahaan->nama ?? '-' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-center text-zinc-800">
                            {{ number_format($items->tenaga_kerjas_count) }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ optional($items->created_at)->translatedFormat('d F Y') }}
                        </p>
                    </td>
                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                        <div class="flex items-center gap-x-6">
                            <a href="{{ route('sirekap.agency.edit', $items) }}"
                                class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                <span class="sr-only">Edit</span>
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <x-modal-delete :action="route('sirekap.agency.destroy', $items)" :title="'Hapus Data '" :message="'Data ' . $items->nama . ' akan dihapus permanen.'"
                                confirm-field="confirm_delete">
                                <button type="button" class="text-zinc-600 hover:text-rose-600">
                                    <x-heroicon-o-trash class="h-5 w-5" />
                                </button>
                            </x-modal-delete>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-sm text-zinc-500">
                        Belum ada data agency.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ? pagination --}}
<div class="pt-6">
    {{ $agencies->onEachSide(2)->links() }}
</div>
</section>
@endsection
