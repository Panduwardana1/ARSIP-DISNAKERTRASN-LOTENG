<aside class="relative flex h-full flex-col bg-white font-inter transition-all duration-300 ease-in-out"
    x-data="{ compact: false }" x-init="$watch('sidebarOpen', value => compact = !value)">
    <div class="flex-1 overflow-y-auto">
        <div class="flex items-center gap-2 border-zinc-200 px-3 py-4">
            <button type="button"
                class="flex h-10 w-10 items-center justify-center ml-1 rounded-lg bg-zinc-800 text-white hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-sky-200"
                x-show="!sidebarOpen" x-cloak @click="sidebarOpen = true" aria-label="Open sidebar">
                <x-heroicon-s-bars-3-center-left class="h-5 w-5" />
            </button>
            <div class="grid flex-1 space-y-0" x-show="!compact" x-cloak>
                <span class="text-sm font-semibold">SIREKAP PASMI</span>
                <span class="text-[10px] font-medium text-zinc-500">DISNAKERTRANS Sumsel</span>
            </div>
            <button type="button"
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 text-zinc-600 hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-sky-200"
                x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak aria-label="Collapse sidebar">
                <x-heroicon-s-chevron-left class="h-5 w-5" />
            </button>
        </div>

        <nav class="grid gap-[4px] px-2 py-3">
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-home class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Dashboard</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-identification class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>CPMI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-building-library class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>P3MI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.agensi.index')" href="{{ route('sirekap.agensi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-building-office class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Agensi</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.destinasi.index')" href="{{ route('sirekap.destinasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-map-pin class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Tujuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-briefcase class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Lowongan</span>
                </div>
            </x-nav-link>
            <span class="py-1.5 text-sm font-medium text-zinc-500/80" x-show="!compact" x-cloak>Rekap</span>
            <x-nav-link :active="request()->routeIs('rekomendasi.index')" href="{{ route('rekomendasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-s-document-text class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Rekom</span>
                </div>
            </x-nav-link>
        </nav>
    </div>

</aside>
