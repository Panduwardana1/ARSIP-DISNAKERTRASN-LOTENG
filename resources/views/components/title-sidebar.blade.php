@props([
    'titleSidebar' => 'Sirekap Pasmi',
    'tagLine' => 'Disnakertrans',
])

<div class="flex items-center mb-2 justify-between p-2 font-inter">
    <!-- Logo dan teks -->
    <div class="flex items-center space-x-2">
        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-auto p-1">
        <div class="flex flex-col leading-tight">
            <span class="font-semibold text-sm text-zinc-700">{{ $titleSidebar }}</span>
            <span class="text-xs font-semibold text-zinc-600">{{ $tagLine }}</span>
        </div>
    </div>

    <!-- Icon toggle -->
    <x-heroicon-o-chevron-up-down class="h-5 w-5 text-zinc-600 hover:text-zinc-800 transition" />
</div>
