@props([
    'titleSidebar' => 'Sirekap Pasmi',
    'tagLine' => 'Disnakertrans',
])

<div class="flex items-center mb-2 justify-between p-2 font-inter">
    <div class="flex items-center space-x-2">
        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-auto p-1 transition-all duration-300"
            :class="sidebarOpen ? '' : 'mx-auto hidden transition-all ease-out'">
        <div class="flex flex-col leading-tight" x-show="sidebarOpen" x-transition.opacity>
            <span class="font-semibold text-sm text-zinc-700">{{ $titleSidebar }}</span>
            <span class="text-xs font-semibold text-zinc-600">{{ $tagLine }}</span>
        </div>
    </div>

    <button type="button" @click="sidebarOpen = !sidebarOpen"
        class="rounded-md border-zinc-200 bg-white p-1.5 text-zinc-500 transition hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
        <x-heroicon-o-bars-3 class="h-5 w-5" />
    </button>
</div>
