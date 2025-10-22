<aside class="flex p-2 h-full flex-col font-inter transition-all duration-300 ease-in-out">
    <div class="flex-1 items-center overflow-y-auto transition-all ease-out duration-300">
        <div class="flex items-center gap-2 justify-between font-inter p-2">
            <div class="flex items-center gap-2">
                <div class="py-2 px-4 rounded-md font-semibold text-white bg-zinc-800">#</div>
                <div class="grid space-y-0">
                    <span class="font-semibold text-sm">Lorem Ipsum</span>
                    <span class="font-medium text-[9px] text-zinc-500">Lorem ipsum dolor sit.</span>
                </div>
            </div>
            <div class="p-1 border rounded-md bg-zinc-700 text-zinc-50 hover:bg-zinc-800 transition-all ease-out duration-200">
                <x-heroicon-s-chevron-left class="h-4 w-4" />
            </div>
            {{-- <x-title-sidebar /> --}}
        </div>
        <div class="grid gap-[4px] px-2 py-2">
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-home class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Dashboard</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-identification class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">CPMI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-building-library class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">P3MI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.agensi.index')" href="{{ route('sirekap.agensi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-building-office class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Agensi</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.destinasi.index')" href="{{ route('sirekap.destinasi.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-map-pin class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Tujuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-briefcase class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700">Lowongan</span>
                </div>
            </x-nav-link>
            <span class="font-inter text-sm font-medium text-zinc-500/80 py-1.5">Rekap</span>
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md py-2 px-2 transition-all duration-300">
                    <x-heroicon-s-document-text class="h-5 w-5 shrink-0"></x-heroicon-s-document-text>
                    <span class="text-sm font-medium text-zinc-700">Rekom</span>
                </div>
            </x-nav-link>
        </div>
    </div>
</aside>
