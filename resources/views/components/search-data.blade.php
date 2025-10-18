@props([
    'placeholder' => 'Cari data',
    'action' => request()->url(),
    'name' => 'keyword',
    'value' => request('keyword', ''),
])

<form action="{{ $action }}" method="GET"
    {{ $attributes->class('flex w-full items-center font-inter gap-2 rounded-md border border-zinc-200 bg-white px-3 py-2 transition focus-within:border-amber-500/80 focus-within:ring-1 focus-within:ring-amber-500/20') }}>
    <x-heroicon-o-magnifying-glass class="hidden h-5 w-5 text-zinc-400 sm:block" />
    <input type="search" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}"
        autocomplete="off" maxlength="100"
        class="w-full bg-transparent text-sm font-medium text-zinc-600 placeholder:text-zinc-400 focus:outline-none">

    @foreach (request()->except($name) as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
    @endforeach
</form>
