@props(['active' => false])

@php
    $classes = $active
        ? 'bg-sky-600 text-white rounded-md font-inter font-medium'
        : 'font-inter font-medium rounded-md hover:bg-sky-50 hover:text-zinc-800';
@endphp

<a {{ $attributes->class(['block']) }}>
    <div class="{{ $classes }}">
        {{ $slot }}
    </div>
</a>
