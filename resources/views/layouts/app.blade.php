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

<body class="antialiased bg-slate-100 text-slate-900 min-h-screen">
    <div x-data="{ sidebarOpen: true }" x-cloak class="flex min-h-screen h-screen bg-slate-100 text-slate-900">
        <aside
            class="flex h-screen flex-col border-r border-zinc-200 bg-white shadow-sm transition-all duration-300 ease-in"
            :class="sidebarOpen ? 'w-64' : 'w-16'">
            <x-sidebar />
        </aside>
        {{-- Main --}}
        <div
            class="flex min-h-screen flex-1 flex-col transition-all duration-300 ease-in-out bg-white selection:bg-amber-600 selection:text-white">
            <header class="flex h-[4rem] items-center justify-between border-b border-zinc-200 px-4 py-4 shadow-sm">
                <h1 class="font-inter text-2xl font-semibold text-zinc-800">@yield('titleContent', 'Dashboard Overview')</h1>
                {{-- <div class="flex items-center gap-2 font-inter text-zinc-700">
                    <span
                        class="inline-flex items-center rounded-md bg-amber-400/10 px-2 py-1.5 text-xs font-medium text-amber-700 ring-1 ring-amber-500">{{ date('D-M-Y') }}</span>
                    <div class="flex items-center gap-2 p-1.5">
                        <x-heroicon-o-calendar-days class="h-6 w-6" />
                        <x-heroicon-o-user-circle class="h-6 w-6" />
                    </div>
                </div> --}}
            </header>

            {{-- Konten main --}}
            <main class="flex-1 overflow-y-auto bg-white">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
