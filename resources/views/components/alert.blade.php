@props([
    'type' => 'success',
    'title' => null,
    'message' => null,
])

@php

    $colors = [
        'success' => 'bg-green-600 text-white',
        'error' => 'bg-rose-600 text-white',
        'warning' => 'bg-amber-600 text-white',
        'info' => 'bg-sky-600 text-white',
    ];

    $icons = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ];

    $color = $colors[$type] ?? $colors['info'];
    $icon = $icons[$type] ?? $icons['info'];

@endphp

<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
    class="flex items-center bg-white shadow-lg rounded-lg p-4 gap-3 border max-w-xs font-inter fixed bottom-6 right-6 z-50">

    <div class="flex items-center justify-center h-7 w-7 rounded-full {{ $color }} rounded-full">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-6 w-6" />
    </div>

    <div class="flex flex-col">
        <span class="font-semibold text-[15px] text-zinc-800 leading-tight">
            {{ $title ?? ucfirst($type) }}
        </span>
        <p class="text-sm text-zinc-600 leading-snug">{{ $message }}</p>
    </div>
</div>
