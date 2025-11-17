<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle', 'Sirekap Pasmi - Disnakertrans')</title>
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ sidebarOpen: false }" class="min-h-screen bg-zinc-100 font-inter">
    {{-- ? allert info --}}
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif

    @if (session('warning'))
        <x-alert type="warning" message="{{ session('warning') }}" />
    @endif

    {{-- * header  --}}
    <header
        class="fixed inset-x-0 top-0 z-40 flex h-14 items-center justify-between bg-blue-800 px-4 shadow-sm backdrop-blur">
        <div class="flex items-center gap-3">
            <button type="button" class="rounded-md border border-amber-600/50 p-1 text-amber-50 lg:hidden"
                @click="sidebarOpen = true">
                <x-heroicon-o-bars-3 class="h-6 w-6" />
            </button>
            <img src="{{ asset('asset/logo/W-logo.png') }}" alt="Logo" class="h-9 w-auto">
        </div>
        <div class="flex items-center gap-3 text-xs font-medium text-amber-100/80 sm:text-sm">
            <x-heroicon-o-bell class="h-5 w-5" />
            <span class="hidden sm:inline">Selamat datang kembali</span>
        </div>
    </header>

    <div class="flex pt-14">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-white lg:hidden"
            @click="sidebarOpen = false"></div>

        {{-- todo sidebar --}}
        <aside id="sidebar-multi-level-sidebar"
            class="fixed left-0 top-14 z-40 flex h-[calc(100vh-3.5rem)] w-60 flex-col border-r bg-zinc-100 px-4 py-4 backdrop-blur transition-transform duration-300 lg:translate-x-0"
            aria-label="Sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:-translate-x-0'">

            <div class="flex-1 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <li>
                        <x-nav-link :active="request()->routeIs('sirekap.dashboard.index')" href="{{ route('sirekap.dashboard.index') }}">
                            <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                                <x-heroicon-o-home class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-semibold">Dashboard</span>
                            </div>
                        </x-nav-link>
                    </li>

                    <li x-data>
                        <button type="button"
                            class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand"
                            @click="$store.sidebar.toggle('master')">

                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-folder-open class="h-5 w-5 shrink-0" />
                                <span class="font-semibold">Master</span>
                            </span>

                            <span class="transition-transform duration-200"
                                x-bind:class="$store.sidebar.state.master ? 'rotate-180' : ''">
                                <x-heroicon-s-chevron-down class="w-5 h-5" />
                            </span>
                        </button>

                        <ul x-show="$store.sidebar.state.master" x-collapse x-cloak
                            class="space-y-2 border-l border-zinc-200 pl-4">
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">CPMI</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">P3MI</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.agency.index')" href="{{ route('sirekap.agency.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Agency</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.pendidikan.index')" href="{{ route('sirekap.pendidikan.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Pendidikan</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.negara.index')" href="{{ route('sirekap.negara.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Destinasi</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>

                    {{-- rekomendasi --}}
                    <li x-data>
                        <button @click="$store.sidebar.toggle('rekomendasi')"
                            class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand">

                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-document-text class="h-5 w-5" />
                                <span class="font-semibold">Rekomendasi</span>
                            </span>

                            <span class="transition-transform duration-200"
                                x-bind:class="$store.sidebar.state.rekomendasi ? 'rotate-180' : ''">
                                <x-heroicon-s-chevron-down class="w-5 h-5" />
                            </span>
                        </button>

                        <ul x-show="$store.sidebar.state.rekomendasi" x-collapse x-cloak
                            class="space-y-2 border-l border-zinc-200 pl-4">
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.author.index')" href="{{ route('sirekap.author.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Author</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.rekomendasi.index')" href="{{ route('sirekap.rekomendasi.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Rekom</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>

                    <li x-data>
                        <button @click="$store.sidebar.toggle('wilayah')"
                            class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand">

                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-map-pin class="h-5 w-5" />
                                <span class="font-semibold">Wilayah</span>
                            </span>

                            <span class="transition-transform duration-200"
                                x-bind:class="$store.sidebar.state.wilayah ? 'rotate-180' : ''">
                                <x-heroicon-s-chevron-down class="w-5 h-5" />
                            </span>
                        </button>

                        <ul x-show="$store.sidebar.state.wilayah" x-collapse x-cloak
                            class="space-y-2 border-l border-zinc-200 pl-4">
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.kecamatan.index')" href="{{ route('sirekap.kecamatan.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Kecamatan</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.desa.index')" href="{{ route('sirekap.desa.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Desa</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>

                    {{-- ! logs --}}
                    <li>
                        <x-nav-link :active="request()->routeIs('sirekap.dashboard.index')" href="{{ route('sirekap.dashboard.index') }}">
                            <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                                <x-heroicon-o-trash class="h-5 w-5 shrink-0" />
                                <span class="text-sm font-semibold">Logs</span>
                            </div>
                        </x-nav-link>
                    </li>
                </ul>
                <div class="pt-6">
                    <div class="grid items-center gap-2 border p-2 w-full bg-blue-600 text-white rounded-lg">
                        <span class="flex items-center gap-2">
                            <x-heroicon-o-information-circle class="h-5 w-5" />
                            <p class="font-semibold">Beta Version</p>
                        </span>
                        <p class="text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main
            class="ml-0 h-[calc(100vh-3.5rem)] w-full flex-1 overflow-y-auto border-zinc-200 bg-white py-6 px-4 sm:px-6 lg:ml-60">
            {{-- todo Header action --}}
            <div class="grid w-full pb-4 space-y-4 font-inter">
                <span>
                    <h2 class="text-3xl font-medium">@yield('titlePageContent', '')</h2>
                    <p class="text-sm">@yield('description', '')</p>
                </span>
                <div class="flex items-center justify-between gap-2">
                    @yield('headerAction')
                </div>
            </div>

            <div class="rounded-base">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                state: JSON.parse(localStorage.getItem('sidebar-menus')) || {
                    master: false,
                    rekomendasi: false,
                    wilayah: false,
                },

                toggle(menu) {
                    this.state[menu] = !this.state[menu];
                    localStorage.setItem('sidebar-menus', JSON.stringify(this.state));
                }
            });
        });
    </script>

</body>

</html>
