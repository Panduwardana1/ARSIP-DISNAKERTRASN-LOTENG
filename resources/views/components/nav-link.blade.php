@props(['active' => false])

@php
    $baseClasses = 'flex w-full items-center rounded-md px-2 py-1.5 text-zinc-900 transition-all duration-200';
    $stateClasses = $active
        ? 'bg-zinc-200'
        : 'hover:bg-zinc-200/70';
@endphp

<a {{ $attributes->class([$baseClasses, $stateClasses]) }}>
    {{ $slot }}
</a>
