<aside class="relative flex h-full flex-col bg-white font-inter transition-all duration-300 ease-in-out"
    x-data="{ compact: false }" x-init="$watch('sidebarOpen', value => compact = !value)">
    <div class="flex-1 overflow-y-auto">
        <div class="flex items-center justify-between gap-2 border-b-[1.5px] border-zinc-200 px-4 py-3">
            <button type="button"
                class="flex h-10 w-10 items-center justify-center ml-1 rounded-lg bg-zinc-800 text-white hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-sky-200"
                x-show="!sidebarOpen" x-cloak @click="sidebarOpen = true" aria-label="Open sidebar">
                <x-heroicon-o-bars-3-center-left class="h-5 w-5" />
            </button>
            {{-- Logo --}}
            <div class="flex items-center gap-2 space-y-0 ease-out duration-75 transition" x-show="!compact" x-cloak>
                <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-9 w-auto">
                <div class="grid">
                    <span class="font-semibold text-sm flex-wrap">Company name</span>
                    <p class="text-[12px]">Tagline here</p>
                </div>
            </div>
            {{-- Button sidebar --}}
            <button type="button"
                class="flex h-10 w-10 items-center justify-center rounded-md text-zinc-600 hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-sky-200"
                x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak aria-label="Collapse sidebar">
                <x-heroicon-o-chevron-left class="h-5 w-5" />
            </button>
        </div>

        <nav class="grid gap-[4px] px-4 py-3">
            <x-nav-link :active="request()->routeIs('sirekap.dashboard')" href="{{ route('sirekap.dashboard') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-home class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Dashboard</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-identification class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>CPMI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-building-library class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>P3MI</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.agensi.index')" href="{{ route('sirekap.agensi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-building-office class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Agensi</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.destinasi.index')" href="{{ route('sirekap.destinasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-map-pin class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Tujuan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.lowongan.index')" href="{{ route('sirekap.lowongan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-briefcase class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Lowongan</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('rekomendasi.index')" href="{{ route('rekomendasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-document-text class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Rekom</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('rekomendasi.index')" href="{{ route('rekomendasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-document-text class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Rekom</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('rekomendasi.index')" href="{{ route('rekomendasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300"
                    :class="compact ? 'justify-center' : 'justify-start'">
                    <x-heroicon-o-document-text class="h-5 w-5 shrink-0" />
                    <span class="text-sm font-medium text-zinc-700" x-show="!compact" x-cloak>Rekom</span>
                </div>
            </x-nav-link>
        </nav>
        {{-- Profile --}}
        <div class="absolute inset-x-0 bottom-0 z-40 border-t-[1.5px] border-zinc-200 bg-white px-3 py-3">
            <div class="flex items-center transition-all duration-300"
                :class="compact ? 'justify-center gap-0' : 'justify-start gap-2'">
                <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full border border-zinc-200 bg-slate-100">
                    <img src="{{ asset('asset/logo-kominfo.png') }}" alt="Logo Profile"
                        class="h-full w-full object-cover" />
                </div>
                <div class="grid items-center space-y-0" x-show="!compact" x-cloak>
                    <span class="text-sm font-semibold text-zinc-800">Company name</span>
                    <p class="text-xs text-zinc-500">Tagline here</p>
                </div>
            </div>
        </div>
    </div>
</aside>
