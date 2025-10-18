@props([
    'title' => 'Tambah',
    'href' => '#',
    'type' => 'link',
    'color' => 'green',
])

@php
    $base = 'px-3 py-1.5 font-inter text-sm font-medium inline-flex items-center gap-1 rounded-md text-white transition';
    $colors = [
        'teal' => 'bg-teal-700 hover:bg-teal-600',
        'red' => 'bg-red-700 hover:bg-red-600',
        'blue' => 'bg-blue-700 hover:bg-blue-600',
        'zinc' => 'bg-zinc-200 hover:bg-zinc-300/90 text-zinc-700 border',
    ];
@endphp

@if ($type === 'link')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base {$colors[$color]}"]) }}>
        {{ $slot ?: $title }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$base {$colors[$color]}"]) }}>
        {{ $slot ?: $title }}
    </button>
@endif
