<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle', 'Sirekap Pasmi - Disnakertrans')</title>
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')
</head>

@if (session('success'))
    <x-alert type="success" message="{{ session('success') }}" />
@endif

@if (session('error'))
    <x-alert type="error" message="{{ session('error') }}" />
@endif

@if (session('warning'))
    <x-alert type="warning" message="{{ session('warning') }}" />
@endif

<body class="bg-gray-100 font-inter">

    <div x-data="{ open: true }" class="flex">

        <aside
            class="fixed inset-y-0 left-0 z-30 flex flex-col bg-white border-r flex-shrink-0 overflow-hidden
           transform transition-all duration-300 ease-in-out
           md:static md:inset-auto"
            :class="open
                ?
                'translate-x-0 w-64 md:w-64' :
                '-translate-x-full w-64 md:translate-x-0 md:w-[5.5rem]'">
            {{-- HEADER --}}
            <div class="flex items-center h-16 flex-shrink-0"
                :class="open ? 'px-4 justify-between' : 'px-2 justify-center'">
                {{-- Logo hanya muncul saat open --}}
                <div class="flex items-center gap-2" x-show="open" x-transition.opacity.duration.200 x-cloak>
                    <img src="{{ asset('asset/logo/primary.png') }}" alt="" class="h-8 w-auto">
                </div>

                {{-- Toggle --}}
                <button @click="open = !open"
                    class="flex items-center justify-center h-9 w-9
                   rounded-md hover:bg-gray-100 transition-colors duration-200"
                    aria-label="Toggle sidebar">
                    <x-heroicon-o-bars-3 class="h-5 w-5" />
                </button>
            </div>

            {{-- NAV --}}
            <nav class="flex-1 px-2 py-3 space-y-2 overflow-y-auto">

                {{-- ITEM: Perusahaan (contoh) --}}
                <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                    <div class="flex items-center rounded-md px-2 py-2 gap-2 transition-all duration-300"
                        :class="open ? 'justify-start' : 'justify-center'">
                        {{-- ICON dalam kotak, selalu kelihatan --}}
                        <div class="flex items-center justify-center h-9 w-9 rounded-md bg-gray-100 flex-shrink-0">
                            <x-heroicon-o-building-library class="h-5 w-5" />
                        </div>

                        {{-- LABEL hanya saat open --}}
                        <span x-show="open" x-transition:enter="transform opacity-0 -translate-x-2"
                            x-transition:enter-end="transform opacity-100 translate-x-0"
                            x-transition:leave="transform opacity-100 translate-x-0"
                            x-transition:leave-end="transform opacity-0 -translate-x-2" x-cloak
                            class="text-sm font-medium">
                            Perusahaan
                        </span>
                    </div>
                </x-nav-link>

                {{-- Duplikat item lain tinggal ganti route + label + icon --}}
                <x-nav-link :active="request()->routeIs('sirekap.kecamatan.index')" href="{{ route('sirekap.kecamatan.index') }}">
                    <div class="flex items-center rounded-md px-2 py-2 gap-2 transition-all duration-300"
                        :class="open ? 'justify-start' : 'justify-center'">
                        <div class="flex items-center justify-center h-9 w-9 rounded-md bg-gray-100 flex-shrink-0">
                            <x-heroicon-o-map class="h-5 w-5" />
                        </div>
                        <span x-show="open" x-transition x-cloak class="text-sm font-medium">
                            Kecamatan
                        </span>
                    </div>
                </x-nav-link>

                {{-- dst... --}}
            </nav>

            {{-- FOOTER / PROFILE --}}
            <div class="p-3 border-t">
                <div class="flex items-center" :class="open ? 'justify-start' : 'justify-center'">
                    <img class="w-8 h-8 rounded-full flex-shrink-0"
                        src="https://ui-avatars.com/api/?name=Sandra+Marx&background=random" alt="Sandra Marx">

                    <div x-show="open" x-transition.opacity.duration.200 x-cloak class="ml-2 whitespace-nowrap">
                        <h4 class="text-sm font-medium">Sandra Marx</h4>
                        <p class="text-xs text-gray-500">sandra@gmail.com</p>
                    </div>

                    <button x-show="open" x-transition.opacity.duration.200 x-cloak class="ml-auto p-1">
                        <x-heroicon-o-chevron-down class="w-5 h-5 text-gray-500" />
                    </button>
                </div>
            </div>
        </aside>

        {{-- backdrop untuk mobile (opsional tapi enak dipakai) --}}
        <div class="fixed inset-0 bg-black/30 z-20 md:hidden" x-show="open" x-transition.opacity @click="open = false"
            x-cloak></div>


        <main class="flex-1 p-8 h-screen overflow-y-auto">

            <button @click="open = !open"
                class="mb-4 p-2 bg-white rounded-lg shadow border hover:bg-gray-50 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <span x-show="open">Collapse</span>
                <span x-show="!open">Expand</span>
            </button>
            <div>
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
