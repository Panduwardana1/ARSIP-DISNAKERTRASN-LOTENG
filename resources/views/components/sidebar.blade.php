<aside class="flex h-full flex-col font-inter transition-all duration-300 ease-in-out">
    <div class="flex-1 p-2 items-center overflow-y-auto transition-all ease-out duration-300">
        <div class="border rounded-md">
            <x-title-sidebar />
        </div>
        <div class="grid gap-[4px] px-2 py-2">
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-home class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Dashboard</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-identification class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">CPMI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-building-library class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">P3MI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.agensi.index')" href="{{ route('sirekap.agensi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-building-office class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Agensi</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.destinasi.index')" href="{{ route('sirekap.destinasi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-map-pin class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Tujuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-briefcase class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Lowongan</span>
                </div>
            </x-nav-link>
            <span class="font-inter text-sm font-semibold text-zinc-500/80 py-1.5">Rekap</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-o-home class="h-5 w-5 shrink-0"></x-heroicon-o-home>
                    <span class="text-sm font-medium text-zinc-700">Dashboard</span>
                </div>
            </x-nav-link>
        </div>
    </div>
</aside>
