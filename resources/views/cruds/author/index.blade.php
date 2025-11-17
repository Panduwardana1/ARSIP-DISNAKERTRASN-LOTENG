@extends('layouts.app')

@section('pageTitle', 'SIREKAP - Author')
@section('titlePageContent', 'Author')

@section('content')
    {{-- header action (search dan button) --}}
@section('headerAction')
    {{-- search --}}
    <div>
        <form method="GET" action="{{ route('sirekap.author.index') }}" class="relative w-full max-w-sm font-inter">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>

            <input type="search" name="q" placeholder="Cari"{{ $search ?? '' }}"
                class="w-full pl-10 py-1.5 rounded-md bg-white border border-zinc-300
               text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none" />
        </form>
    </div>
    {{-- button --}}
    <div class="flex items-center">
        <a href="{{ route('sirekap.author.create') }}"
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
                        Author
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Jabatan
                    </p>
                </th>
                <th class="p-4">
                    <p class="text-sm font-normal leading-none text-white">
                        Dibuat
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
            @forelse ($authors as $author)
                <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ $loop->iteration }}
                        </p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('asset/images/default-profile.jpg') }}" alt="Profile"
                                class="h-12 w-auto rounded-full border-[1.5px]">
                            <span class="grid items-center">
                                <p class="text-sm font-semibold text-zinc-800">{{ $author->nama }}</p>
                                <p class="text-xs font-medium text-zinc-600">{{ $author->nip }}</p>
                            </span>
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800" title="{{ $author->jabatan }}">
                            {{ Str::limit($author->jabatan, 60) }}
                        </p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-zinc-800">
                            {{ optional($author->created_at)->translatedFormat('d F Y') }}
                        </p>
                    </td>
                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                        <div class="flex items-center gap-x-6">
                            <a href="{{ route('sirekap.author.edit', $author) }}"
                                class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                <span class="sr-only">Edit</span>
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <x-modal-delete :action="route('sirekap.author.destroy', $author)" :title="'Hapus Data '" :message="'Data ' . $author->nama . ' akan dihapus permanen.'"
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
                        Belum ada data author.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pt-6">
    {{ $authors->onEachSide(2)->links() }}
</div>
</section>
@endsection
