@props(['active' => false])

@php
    $classes = $active
        ? ' bg-zinc-200/80 text-zinc-700 rounded-md'
        : ' text-zinc-700 hover:bg-zinc-100 rounded-md hover:text-zinc-800';
@endphp

<a {{ $attributes->class($classes) }}>
    {{ $slot }}
</a>
