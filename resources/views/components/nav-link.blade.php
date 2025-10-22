@props(['active' => false])

@php
    $classes = $active
        ? ' bg-zinc-200 text-zinc-800 rounded-md'
        : ' text-zinc-800 hover:bg-zinc-200 rounded-md hover:text-zinc-800';
@endphp

<a {{ $attributes->class($classes) }}>
    {{ $slot }}
</a>
