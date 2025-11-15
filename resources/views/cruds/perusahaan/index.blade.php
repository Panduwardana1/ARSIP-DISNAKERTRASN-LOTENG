@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI')
@section('Title', 'Perusahaan')


@if ($errors->has('message'))
    <div class="mx-4 mt-2 px-4 py-2 rounded-md bg-red-100 text-red-700 text-sm">
        {{ $errors->first('message') }}
    </div>
@endif

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

    <div class="relative flex flex-col w-full h-full rounded-lg overflow-hidden">
        <table class="w-full text-left table-auto min-w-max">
            <thead class="bg-slate-800 uppercase">
                <tr>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-slate-300">
                            Kode
                        </p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-slate-300">
                            Label
                        </p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-slate-300">
                            Kontribusi
                        </p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-slate-300">
                            Ditambahkan
                        </p>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-slate-300">
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
                                {{ $items->nama }}
                            </p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-zinc-800">
                                {{ $items->label }}
                            </p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-zinc-800">
                                {{ $items->tki ?? 'none' }}
                            </p>
                        </td>
                        <td class="p-4">
                            <p class="text-sm text-zinc-800">
                                {{-- {{ $items->created_at->translatedFormat('d F Y') }} --}}
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
                    <div>
                        <span>Belum ada data</span>
                    </div>
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
