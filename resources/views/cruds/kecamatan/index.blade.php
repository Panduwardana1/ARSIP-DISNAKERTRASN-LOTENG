@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Kecamatan')
@section('titlePageContent', 'Kecamatan')

@section('content')
    @if (session('success'))
        <div class="rounded-md border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @error('app')
        <div class="rounded-md border border-rose-200 bg-rose-50 px-5 py-3 text-sm text-rose-700">
            {{ $message }}
        </div>
    @enderror

    {{-- header action (search dan button) --}}
@section('headerAction')
    {{-- search --}}
    <div>
        <form method="GET" action="{{ route('sirekap.kecamatan.index') }}" class="relative w-full max-w-sm font-inter">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>

            <input type="search" name="q" placeholder="Cari kecamatan atau kode..." value="{{ $search ?? '' }}"
                class="w-full pl-10 py-1.5 rounded-md bg-white border border-zinc-300
               text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none" />
        </form>
    </div>
    {{-- button --}}
    <div class="flex items-center">
        <a href="{{ route('sirekap.kecamatan.create') }}"
            class="flex items-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
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
                        Kecamatan
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Kode
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Total Desa
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Ditambahkan
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
            @forelse ($kecamatans as $items)
                <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $loop->iteration }}
                        </p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="h-7 w-7 text-zinc-700" />
                            <div class="grid space-y-0">
                                <p class="text-[16p] font-semibold text-zinc-800">
                                    {{ $items->nama }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="text-sm font-semibold text-zinc-800">
                            {{ $items->kode ?? '-' }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ number_format($items->desas_count) }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ optional($items->created_at)->translatedFormat('d F Y') }}
                        </p>
                    </td>
                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                        <div class="flex items-center gap-x-6">
                            <a href="{{ route('sirekap.kecamatan.edit', $items) }}"
                                class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                <span class="sr-only">Edit</span>
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <x-modal-delete :action="route('sirekap.kecamatan.destroy', $items)" :title="'Hapus Data '" :message="'Data ' . $items->nama . ' akan dihapus permanen.'"
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
                        Belum ada data kecamatan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ? pagination --}}
<div class="pt-6">
    {{ $kecamatans->onEachSide(2)->links() }}
</div>
</section>
@endsection
