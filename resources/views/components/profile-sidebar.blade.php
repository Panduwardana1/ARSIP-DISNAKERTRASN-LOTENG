@props([
    'username' => 'Pimpinan',
    'role' => null,
])

<div class="p-3 font-inter">
    <div class="flex items-center space-x-3">
        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-8 w-auto object-cover">
        <div class="flex flex-col leading-tight">
            <span class="font-semibold text-zinc-800 text-sm">{{ $username }}</span>
            <span class="text-xs text-zinc-500">Role: <span
                    class="font-medium text-zinc-700">{{ $role }}</span></span>
        </div>
    </div>
</div>
