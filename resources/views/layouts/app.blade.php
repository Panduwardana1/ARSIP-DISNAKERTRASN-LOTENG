<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle', 'Sirekap Pasmi | DISNAKERTRANS')</title>
    <link rel="icon" href="{{ asset('asset/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')
</head>
<style>
    [x-cloak] {
        display: none !important
    }
</style>

<body class="antialiased bg-slate-100 text-slate-900 min-h-screen" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen h-screen bg-slate-100 text-slate-900">
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-[4.5rem]'"
            class="flex h-screen flex-col w-[14rem] border-zinc-300 bg-white border-r-[1.5px] transition-all duration-300 ease-in lg:translate-x-0">
            <x-sidebar />
        </aside>

        <div
            class="flex min-h-screen flex-1 flex-col transition-all duration-300 ease-in-out bg-white"
            :class="sidebarOpen ? 'lg:pl-0' : 'lg:pl-[10rem]'">
            <header class="flex h-[4rem] items-center justify-between border-b-[1.5px] border-zinc-300 px-4 py-4">
                <div class="flex items-center gap-3">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-200 lg:hidden"
                        @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar">
                        <x-heroicon-s-bars-3 class="h-5 w-5" />
                    </button>
                    <h1 class="font-inter text-2xl font-semibold text-zinc-800">@yield('titleContent', '')</h1>
                </div>
                <div class="flex items-center p-1 rounded-md hover:bg-zinc-100 gap-2">
                    <button type="button"
                        class="hidden lg:inline-flex items-center justify-center rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        @click="sidebarOpen = !sidebarOpen" aria-label="Collapse sidebar">
                        <x-heroicon-s-chevron-left x-show="sidebarOpen" class="h-5 w-5" />
                        <x-heroicon-s-chevron-right x-show="!sidebarOpen" x-cloak class="h-5 w-5" />
                    </button>
                    <div class="p-2 border rounded-md bg-zinc-800 text-white hover:bg-zinc-700 active:ring-1">
                        <x-heroicon-o-cube class="h-5 w-5" />
                    </div>
                    <div class="grid space-y-0 font-inter text-right">
                        <span class="font-semibold text-zinc-800">Udin Santoso</span>
                        <span class="text-xs font-medium">Admin</span>
                    </div>
                </div>
            </header>

            {{-- Konten main --}}
            <main class="h-screen flex-1 overflow-y-auto bg-zinc-100">
                @yield('content')
            </main>
        </div>

        <div class="fixed inset-0 bg-slate-900/40 transition-opacity lg:hidden"
            x-show="sidebarOpen" x-transition.opacity
            @click="sidebarOpen = false" x-cloak></div>
    </div>

    @stack('scripts')
</body>

</html>
