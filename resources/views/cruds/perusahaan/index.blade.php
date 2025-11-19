@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI')

@if ($errors->has('message'))
    <div class="mx-4 mt-2 px-4 py-2 rounded-md bg-red-100 text-red-700 text-sm">
        {{ $errors->first('message') }}
    </div>
@endif

@section('content')
    {{-- title page content --}}
@section('titlePageContent', 'P3MI')

{{-- header action (search dan button) --}}
@section('headerAction')
    {{-- search --}}
    <div>
        <form method="GET" action="{{ route('sirekap.perusahaan.index') }}" class="relative w-full max-w-sm font-inter">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>

            <input type="search" name="search" placeholder="Cari nama perusahaan..." value="{{ $search ?? '' }}"
                class="w-full pl-10 py-1.5 rounded-md bg-white border border-zinc-300
               text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none" />
        </form>
    </div>
    {{-- button --}}
    <div class="flex items-center">
        <a href="{{ route('sirekap.perusahaan.create') }}"
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
                        ID
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        P3MI
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Email
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Alamat
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Kontribusi
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
            @forelse ($perusahaans as $items)
                <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $items->id }}
                        </p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('sirekap.perusahaan.show', $items) }}" class="flex items-center">
                                @php
                                    $imagePath = $items->gambar ? 'storage/' . ltrim($items->gambar, '/') : null;
                                @endphp

                                @if ($imagePath && file_exists(public_path($imagePath)))
                                    <img src="{{ asset($imagePath) }}" alt="Logo {{ $items->nama }}"
                                        class="h-9 w-9 rounded-full object-cover">
                                @else
                                    <x-heroicon-o-building-office class="h-9 w-9 text-gray-400" />
                                @endif
                            </a>
                            <div class="grid space-y-0">
                                <p class="text-[16px] font-medium text-zinc-800">{{ $items->nama }}</p>
                                <p class="text-xs font-medium text-zinc-800">{{ $items->pimpinan }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $items->email }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800" title="{{ $items->alamat }}">
                            {{ Str::limit($items->alamat, 20) ?? '-' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $items->tki ?? '90' }}
                        </p>
                    </td>
                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                        <div class="flex items-center gap-x-6">
                            <a href="{{ route('sirekap.perusahaan.edit', $items) }}"
                                class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                <span class="sr-only">Edit</span>
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <x-modal-delete :action="route('sirekap.perusahaan.destroy', $items)" :title="'Hapus Data '" :message="'Datas ' . $items->nama . ' akan dihapus permanen.'"
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
                        Belum ada data P3MI
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ? pagination --}}
<div class="pt-6">
    {{ $perusahaans->onEachSide(2)->links() }}
</div>
</section>
@endsection
