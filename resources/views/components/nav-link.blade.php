@props(['active' => false])

@php
    $classes = $active
        ? ' text-amber-500 bg-red-200 rounded-md'
        : ' text-amber-50 hover:text-amber-500 rounded-md';
@endphp

<a {{ $attributes->class($classes) }}>
    {{ $slot }}
</a>
