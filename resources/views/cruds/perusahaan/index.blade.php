@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI')
@section('Title', 'Perusahaan')


@if ($errors->has('message'))
    <div class="mx-4 mt-2 px-4 py-2 rounded-md bg-red-100 text-red-700 text-sm">
        {{ $errors->first('message') }}
    </div>
@endif

@section('content')
    <section class="container px-4 mx-auto pb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-zinc-800">Daftar Perusahaan</h2>
                <span class="px-3 py-1 text-xs bg-zinc-100 border text-zinc-800 rounded-full">
                    {{ $perusahaans instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $perusahaans->total() : $perusahaans->count() }}
                    perusahaan
                </span>
            </div>

            <div class="flex items-center gap-3">
                <label for="search-perusahaan" class="sm:flex-none sm:w-auto">
                    <span class="sr-only">Cari</span>
                    <input id="search-perusahaan" type="search" name="search" placeholder="Cari perusahaan..."
                        class="w-full px-4 py-2 text-sm text-zinc-600 bg-white rounded-md 0 border-[1.5px] focus:outline-none">
                </label>

                <a href="{{ route('sirekap.perusahaan.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600 rounded-md hover:bg-green-700">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Tambah
                </a>
            </div>
        </div>

        <div class="flex flex-col mt-6">
            <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="border rounded-lg border-zinc-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-zinc-200">
                            <thead class="bg-slate-800">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-zinc-50">
                                        <div class="flex items-center gap-x-3">
                                            <span>Perusahaan</span>
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class=" px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-zinc-50">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-zinc-50">
                                        Alamat
                                    </th>
                                    <th scope="col"
                                        class="flex items-center gap-1 px-4 py-3.5 text-sm font-normal text-center rtl:text-right text-zinc-50">
                                        <x-heroicon-o-exclamation-circle
                                            title="Total CPMI yang berdistribusi pada perusahaan terkait"
                                            class="w-4 h-4 text-zinc-300" />
                                        CPMI
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-zinc-50">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-zinc-50 divide-y divide-zinc-400">
                                @php
                                    use Illuminate\Support\Facades\Storage;
                                @endphp

                                @forelse ($perusahaans as $item)
                                    @php
                                        $hasImage =
                                            filled($item->gambar) && Storage::disk('public')->exists($item->gambar);
                                    @endphp

                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-zinc-700 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <div class="flex items-center gap-x-3">
                                                    <div x-data="{ err: {{ $hasImage ? 'false' : 'true' }} }" class="w-12 h-12 select-none">
                                                        <img x-show="!err"
                                                            src="{{ $hasImage ? asset('storage/' . $item->gambar) : '' }}"
                                                            alt="Logo {{ $item->nama }}"
                                                            class="object-cover w-12 h-12 rounded-md bg-zinc-100"
                                                            x-on:error="err = true">
                                                        <x-heroicon-o-building-office-2 x-show="err"
                                                            class="w-12 h-12 p-1 text-zinc-400/50 bg-zinc-100 rounded-md" />
                                                    </div>

                                                    <div>
                                                        <h2 class="font-medium text-zinc-800">
                                                            {{ $item->nama }}</h2>
                                                        @if ($item->pimpinan)
                                                            <p class="text-sm font-normal text-zinc-600">
                                                                {{ $item->pimpinan }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-12 py-4 text-sm text-blue-500 font-medium whitespace-nowrap">
                                            <a href="mailto:{{ $item->email }}" class="hover:underline">
                                                {{ $item->email }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-zinc-700">
                                            <span
                                                title="{{ $item->alamat }}">{{ Str::limit($item->alamat, 30, '...') }}</span>

                                        </td>
                                        <td class="px-4 py-4 text-sm text-center text-zinc-700">
                                            <span class="font-medium text-sm">499</span>
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex items-center gap-x-6">
                                                <a href="{{ route('sirekap.perusahaan.edit', $item) }}"
                                                    class="text-zinc-500 transition-colors duration-200 hover:text-amber-500">
                                                    <span class="sr-only">Edit</span>
                                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                                </a>

                                                <x-modal-delete :action="route('sirekap.perusahaan.destroy', $item)" :title="'Hapus Data '" :message="'Datas ' . $item->nama . ' akan dihapus permanen.'" confirm-field="confirm_delete">
                                                    <button type="button">
                                                        <x-heroicon-o-trash class="h-5 w-5" />
                                                    </button>
                                                </x-modal-delete>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-4 py-6 text-sm text-center text-zinc-500 dark:text-zinc-300">
                                            Belum ada data perusahaan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- ? pagination --}}
        <div class="pt-6">
            {{ $perusahaans->onEachSide(2)->links() }}
        </div>
    </section>
@endsection
