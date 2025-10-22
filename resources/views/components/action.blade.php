@props([
    'showUrl' => '#',
    'editUrl' => '#',
    'deleteUrl' => '#',
])

<div x-data="{ open: false }" class="relative inline-block text-left">
    {{-- button triger --}}
    <button @click="open = !open" @click.away="open = false" class="px-[4px] rounded-md bg-zinc-100">
        <x-heroicon-s-ellipsis-horizontal class="h-5 w-5"></x-heroicon-s-ellipsis-horizontal>
    </button>

    {{-- Drop down menu --}}
    <div x-show="open" x-transition class="absolute right-0 mt-2 w-auto">
        <div class="bg-red-50">
            <a href="{{ $showUrl }}">Detail</a>
            <a href="{{ $editUrl }}">Edit</a>
            <form method="POST" action="{{ $deleteUrl }}"
                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

{{-- pemakaian di blade --}}
{{-- <td class="text-center">
    <x-dropdown-action
        :show-url="route('tki.show', $tki->id)"
        :edit-url="route('tki.edit', $tki->id)"
        :delete-url="route('tki.destroy', $tki->id)"
    />
</td> --}}
