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
    class="flex items-center max-w-sm border bg-white font-outfit gap-3 p-3 rounded-xl shadow-md fixed bottom-5 right-5 z-50">

    <div class="p-3 {{ $color }} rounded-md">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-6 w-6" />
    </div>

    <div class="grid">
        <span class="font-semibold text-lg text-slate-800">
            {{ $title ?? ucfirst($type) }}
        </span>
        <p class="text-slate-600">{{ $message }}</p>
    </div>
</div>
