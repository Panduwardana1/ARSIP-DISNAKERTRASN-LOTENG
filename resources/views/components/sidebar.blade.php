<aside class="flex h-full flex-col font-inter bg-white transition-all duration-300 ease-in-out"
    :class="sidebarOpen ? 'px-3 ease-out' : 'px-1'">
    <div class="flex-1 items-center overflow-y-auto transition-all ease-out duration-300">
        <x-title-sidebar></x-title-sidebar>
        <div class="grid gap-[4px] px-2">
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-home class="h-5 w-5 shrink-0" />
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">Dashboard</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.cpmi.index')" href="{{ route('sirekap.cpmi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-identification class="h-5 w-5 shrink-0" />
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">CPMI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-building-library class="h-5 w-5 shrink-0" />
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">P3MI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.agensi.index')" href="{{ route('sirekap.agensi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-building-office class="h-5 w-5 shrink-0" />
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">Agensi</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.destinasi.index')" href="{{ route('sirekap.destinasi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-map-pin class="h-5 w-5 shrink-0" />
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">Tujuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-briefcase class="h-5 w-5 shrink-0" />
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">Lowongan</span>
                </div>
            </x-nav-link>
            <span class="font-inter text-sm font-semibold text-zinc-500/80 py-1.5" x-show="sidebarOpen"
                x-transition.opacity>Rekap</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md py-2 transition-all duration-300"
                    :class="sidebarOpen ? 'justify-start px-2' : 'justify-center px-1'">
                    <x-heroicon-s-home class="h-5 w-5 shrink-0"></x-heroicon-s-home>
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="text-sm font-medium text-zinc-700">Dashboard</span>
                </div>
            </x-nav-link>
        </div>
    </div>
</aside>
