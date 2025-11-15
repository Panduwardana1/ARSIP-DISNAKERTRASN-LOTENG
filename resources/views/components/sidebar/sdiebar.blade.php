<div class="grid gap-[4px] space-y-1">
    <span class="font-medium text-xs text-amber-50/50" x-show="isSidebarOpen" x-transition.opacity x-cloak>Main Menu</span>

    <x-nav-link :active="request()->routeIs('sirekap.dashboard.index')" href="{{ route('sirekap.dashboard.index') }}">
        <div class="flex items-center rounded-md px-2 py-2 transition-all duration-300"
            :class="isSidebarOpen ? 'justify-start gap-2' : 'justify-center'">
            <x-heroicon-o-squares-2x2 class="h-5 w-5 shrink-0" />
            <span class="text-md font-medium transition duration-200" x-show="isSidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-2" x-cloak>Dashboard</span>
        </div>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
        <div class="flex items-center rounded-md px-2 py-2 transition-all duration-300"
            :class="isSidebarOpen ? 'justify-start gap-2' : 'justify-center'">
            <x-heroicon-o-identification class="h-5 w-5 shrink-0" />
            <span class="text-md font-medium transition duration-200" x-show="isSidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-2" x-cloak>CPMI</span>
        </div>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
        <div class="flex items-center rounded-md px-2 py-2 transition-all duration-300">
            <x-heroicon-o-building-library class="h-5 w-5 shrink-0" />
            <span class="text-md font-medium transition duration-200">Perusahaan</span>
        </div>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('sirekap.agency.index')" href="{{ route('sirekap.agency.index') }}">
        <div class="flex items-center rounded-md px-2 py-2 transition-all duration-300"
            :class="isSidebarOpen ? 'justify-start gap-2' : 'justify-center'">
            <x-heroicon-o-building-library class="h-5 w-5 shrink-0" />
            <span class="text-md font-medium transition duration-200" x-show="isSidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-2" x-cloak>Agency</span>
        </div>
    </x-nav-link>

    <details x-data="{ open: false }" x-init="// Ambil status sebelumnya dari localStorage
    const saved = localStorage.getItem('nav.wilayah');
    if (saved !== null) open = JSON.parse(saved);

    $watch('open', value => localStorage.setItem('nav.wilayah', JSON.stringify(value)));" x-bind:open="open" @toggle="open = $el.open"
        class="group space-y-1 [&_summary::-webkit-details-marker]:hidden">
        <summary
            class="flex list-none cursor-pointer select-none items-center rounded-md px-2 py-2 transition"
            :class="isSidebarOpen ? 'justify-between hover:bg-slate-700' : 'justify-center'" role="button"
            aria-controls="submenu-wilayah" :aria-expanded="open.toString()">
            <span class="inline-flex items-center gap-2 text-amber-50">
                <x-heroicon-o-map-pin class="h-5 w-5 shrink-0" />
                <span class="text-sm font-medium" x-show="isSidebarOpen" x-transition.opacity x-cloak>Wilayah</span>
            </span>
            <x-heroicon-o-chevron-right class="h-4 w-4 text-white transition-transform duration-200 group-open:rotate-90"
                x-show="isSidebarOpen" x-transition.opacity x-cloak />
        </summary>

        <div id="submenu-wilayah" class="grid gap-[2px] pl-8" x-show="isSidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1" x-cloak>
            <x-nav-link :active="request()->routeIs('sirekap.kecamatan.*')" href="{{ route('sirekap.kecamatan.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2">
                    <span class="text-sm font-medium">Kecamatan</span>
                </div>
            </x-nav-link>

            <x-nav-link :active="request()->routeIs('sirekap.desa.*')" href="{{ route('sirekap.desa.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2">
                    <span class="text-sm font-medium">Desa</span>
                </div>
            </x-nav-link>
        </div>
    </details>

    <details x-data="{ open: false }" x-init="// Ambil status sebelumnya dari localStorage
    const saved = localStorage.getItem('nav.paspor');
    if (saved !== null) open = JSON.parse(saved);

    $watch('open', value => localStorage.setItem('nav.paspor', JSON.stringify(value)));" x-bind:open="open" @toggle="open = $el.open"
        class="group space-y-1 [&_summary::-webkit-details-marker]:hidden">
        <summary
            class="flex list-none cursor-pointer select-none items-center rounded-md px-2 py-2 text-white transition"
            :class="isSidebarOpen ? 'justify-between' : 'justify-center'" role="button" aria-controls="submenu-paspor"
            :aria-expanded="open.toString()">
            <span class="inline-flex items-center gap-2">
                <x-heroicon-o-document-text class="h-5 w-5 shrink-0" />
                <span class="text-[16px] font-medium text-white" x-show="isSidebarOpen" x-transition.opacity x-cloak>Paspor</span>
            </span>
            <x-heroicon-o-chevron-right class="h-4 w-4 transition-transform duration-200 group-open:rotate-90"
                x-show="isSidebarOpen" x-transition.opacity x-cloak />
        </summary>

        <div id="submenu-paspor" class="grid gap-[2px] pl-8" x-show="isSidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1" x-cloak>
            <x-nav-link :active="request()->routeIs('sirekap.rekomendasi.*')" href="{{ route('sirekap.rekomendasi.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2">
                    <span class="text-[16px] font-medium">Rekomendasi Paspor</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.author.index')" href="{{ route('sirekap.author.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2">
                    <span class="text-[16px] font-medium">Author</span>
                </div>
            </x-nav-link>
            <x-nav-link :active="request()->routeIs('sirekap.negara.index')" href="{{ route('sirekap.negara.index') }}">
                <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                    <span class="text-[16px] font-medium transition duration-200">Arsip</span>
                </div>
            </x-nav-link>
        </div>
    </details>

    <x-nav-link :active="request()->routeIs('sirekap.pendidikan.index')" href="{{ route('sirekap.pendidikan.index') }}">
        <div class="flex items-center rounded-md px-2 py-2 transition-all duration-300"
            :class="isSidebarOpen ? 'justify-start gap-2' : 'justify-center'">
            <x-heroicon-o-academic-cap class="h-5 w-5 shrink-0" />
            <span class="text-md font-medium transition duration-200" x-show="isSidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-2" x-cloak>Pendidikan</span>
        </div>
    </x-nav-link>

    <x-nav-link :active="request()->routeIs('sirekap.negara.index')" href="{{ route('sirekap.negara.index') }}">
        <div class="flex items-center rounded-md px-2 py-2 transition-all duration-300"
            :class="isSidebarOpen ? 'justify-start gap-2' : 'justify-center'">
            <x-heroicon-o-globe-europe-africa class="h-5 w-5 shrink-0" />
            <span class="text-md font-medium transition duration-200" x-show="isSidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-2" x-cloak>Destinasi</span>
        </div>
    </x-nav-link>
</div>
