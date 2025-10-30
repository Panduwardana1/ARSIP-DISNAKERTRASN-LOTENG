<aside class="relative flex h-full font-inter transition-all duration-300 ease-in-out">
    <div class="flex-1 overflow-y-auto">
        <div class="flex items-center justify-between gap-2 px-4 py-4 border-b">
            <div class="flex items-center space-x-2">
                <button type="button" class="flex items-center justify-center text-white">
                    <img src="{{ asset('asset/ICON.png') }}" alt="Logo" class="h-8 w-auto">
                </button>
                <div class="flex items-center gap-1">
                    <div class="grid overflow-hidden text-left transition-all duration-300 ease-out">
                        <span class="text-md font-semibold text-zinc-800">Sirekap</span>
                    </div>
                </div>
            </div>
            <button type="button">
                <x-heroicon-o-chevron-up-down class="h-5 w-5 shrink-0" />
            </button>
        </div>

        <nav class="grid gap-[4px] px-4 py-4 space-y-1">
            <span class="items-start font-medium text-zinc-500 text-sm px-2">Menu</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-home class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">Dashboard</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('rekomendasi.index')" href="{{ route('rekomendasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-document-text class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">Rekom</span>
                </div>
            </x-nav-link>
            <div class="border-t"></div>
            <span class="items-start font-medium text-zinc-500 text-sm px-2">Master</span>
            <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-identification class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">CPMI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-building-library class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">P3MI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.agensi.index')" href="{{ route('sirekap.agensi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-building-office class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">Agensi</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.destinasi.index')" href="{{ route('sirekap.destinasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-map-pin class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">Tujuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-briefcase class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">Lowongan</span>
                </div>
            </x-nav-link>
            <div class="border-t"></div>
            <span class="items-start font-medium text-zinc-500 text-sm px-2">Logs</span>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <x-heroicon-o-briefcase class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700 transition duration-200">Lowongan</span>
                </div>
            </x-nav-link>
        </nav>

        <div class="absolute inset-x-0 bottom-0 z-40 border-t border-zinc-200 bg-white px-3 py-3">
            <div class="flex items-center gap-2 transition-all duration-300">
                <div class="flex h-10 w-10 items-center justify-center overflow-hidden">
                    <img src="{{ asset('asset/logo-kominfo.png') }}" alt="Logo Profile"
                        class="h-8 w-auto object-cover" />
                </div>
                <div class="grid overflow-hidden text-left transition-all duration-300 ease-out"
                    :style="compact ? 'width:0; opacity:0; margin-left:-8px;' : 'width:140px; opacity:1; margin-left:0;'">
                    <span class="text-sm font-medium text-zinc-800">Staf</span>
                    <p class="text-xs text-zinc-500">staf@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</aside>
