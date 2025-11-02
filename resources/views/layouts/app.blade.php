<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle', 'Sirekap Pasmi - Disnakertrans')</title>
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')
</head>

<body class="antialiased bg-white text-zinc-900 min-h-screen">
    <section class="flex min-h-screen h-screen bg-zinc-100 text-zinc-900">
        <aside
            class="fixed inset-y-0 left-0 z-40 flex h-full flex-col w-60 border-zinc-200 bg-white transition-[transform,width] duration-300 ease-in-out lg:static lg:h-screen lg:flex-shrink-0 lg:tranzinc-x-0">
            <div class="relative flex h-full font-inter border-r transition-all duration-300 ease-in-out">
                <div class="flex-1 overflow-y-auto">
                    <div class="flex items-center justify-between gap-2 px-4 py-4 border-b">
                        <div class="flex items-center space-x-2">
                            <button type="button" class="flex items-center justify-center text-white">
                                <img src="{{ asset('asset/logo/primary.png') }}" alt="Logo" class="h-8 w-auto">
                            </button>
                        </div>
                        <button type="button"
                            class="absolute -right-3 px-0.5 hover:bg-zinc-300 bg-zinc-200 transition-all duration-300">
                            <x-heroicon-s-chevron-up-down class="h-5 w-5 shrink-0 rotate-90" />
                        </button>
                    </div>
                    <nav class="grid gap-[4px] px-4 py-4 space-y-1">
                        <span class="items-start font-medium text-zinc-500 text-sm px-2">Menu</span>
                        <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-squares-2x2 class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">Dashboard</span>
                            </div>
                        </x-nav-link>
                        <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-document-text class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">Rekom</span>
                            </div>
                        </x-nav-link>
                        <div class="border-t"></div>
                        <span class="items-start font-medium text-zinc-500 text-sm px-2">Master</span>
                        <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-identification class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">CPMI</span>
                            </div>
                        </x-nav-link>
                        <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-building-library class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">Perusahaan</span>
                            </div>
                        </x-nav-link>
                        <x-nav-link :active="request()->routeIs('sirekap.agency.index')" href="{{ route('sirekap.agency.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-building-office class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">Agency</span>
                            </div>
                        </x-nav-link>
                        @php
                            $wilayahActive =
                                request()->routeIs('sirekap.kecamatan.*') || request()->routeIs('sirekap.desa.*');
                        @endphp

                        {{-- WILAYAH (accordion native <details>) --}}
                        <details {{ $wilayahActive ? 'open' : '' }} {{-- fallback tanpa JS: terbuka saat aktif --}} x-data="{ open: false }"
                            x-init="const saved = localStorage.getItem('nav.wilayah');
                            open = {{ $wilayahActive ? 'true' : 'false' }} || (saved ? JSON.parse(saved) : false);
                            $watch('open', v => localStorage.setItem('nav.wilayah', JSON.stringify(v)));" x-bind:open="open" @toggle="open = $el.open"
                            {{-- sinkronkan klik <summary> ke state Alpine --}} class="group space-y-1 [&_summary::-webkit-details-marker]:hidden">
                            <summary
                                class="list-none flex items-center justify-between rounded-md px-2 py-2 hover:bg-zinc-100 cursor-pointer select-none"
                                role="button" aria-controls="submenu-wilayah" :aria-expanded="open.toString()">
                                <span class="inline-flex items-center gap-2">
                                    <x-heroicon-s-map-pin class="h-5 w-5 shrink-0" />
                                    <span class="text-sm font-medium text-zinc-700">Wilayah</span>
                                </span>
                                <x-heroicon-s-chevron-right
                                    class="h-4 w-4 transition-transform duration-200 group-open:rotate-90" />
                            </summary>

                            <div id="submenu-wilayah" class="pl-8 grid gap-[2px]">
                                <x-nav-link :active="request()->routeIs('sirekap.kecamatan.*')" href="{{ route('sirekap.kecamatan.index') }}">
                                    <div class="flex items-center gap-2 rounded-md px-2 py-2 hover:bg-zinc-50">
                                        <x-heroicon-s-map class="h-4 w-4 shrink-0" />
                                        <span class="text-sm text-zinc-700">Kecamatan</span>
                                    </div>
                                </x-nav-link>

                                <x-nav-link :active="request()->routeIs('sirekap.desa.*')" href="{{ route('sirekap.desa.index') }}">
                                    <div class="flex items-center gap-2 rounded-md px-2 py-2 hover:bg-zinc-50">
                                        <x-heroicon-s-map class="h-4 w-4 shrink-0" />
                                        <span class="text-sm text-zinc-700">Desa</span>
                                    </div>
                                </x-nav-link>
                            </div>
                        </details>
                        <x-nav-link :active="request()->routeIs('sirekap.pendidikan.index')" href="{{ route('sirekap.pendidikan.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-academic-cap class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">Pendidikan</span>
                            </div>
                        </x-nav-link>
                        <div class="border-t"></div>
                        <span class="items-start font-medium text-zinc-500 text-sm px-2">Logs</span>
                        <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                            <div class="flex items-center gap-2 rounded-md px-2 py-2 transition-all duration-300">
                                <x-heroicon-s-briefcase class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-medium text-zinc-700 transition duration-200">Lowongan</span>
                            </div>
                        </x-nav-link>
                    </nav>
                </div>
            </div>
        </aside>
        <main class="h-screen bg-white w-full px-4">
            @yield('content')
        </main>
    </section>
    @stack('scripts')
</body>

</html>
