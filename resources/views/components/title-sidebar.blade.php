@props([
    'titleSidebar' => 'Sirekap Pasmi',
    'tagLine' => 'Disnakertrans',
])

<div class="flex items-center justify-between p-2 font-inter">
    <div class="flex items-center space-x-2">
        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-auto p-1 transition-all duration-300">
        <div class="flex flex-col leading-tight">
            <span class="font-semibold text-sm text-zinc-700">{{ $titleSidebar }}</span>
            <span class="text-xs font-semibold text-zinc-600">{{ $tagLine }}</span>
        </div>
    </div>

</div>
