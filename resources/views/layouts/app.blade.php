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

<body class="antialiased bg-slate-100 text-slate-900 min-h-screen" x-data="{ sidebarOpen: true }" x-init="sidebarOpen = window.matchMedia('(min-width: 1250px)').matches">
    <div class="flex min-h-screen h-screen bg-slate-100 text-slate-900">
        <aside
            class="fixed inset-y-0 left-0 z-40 flex h-full flex-col border-r-[1.5px] w-60 border-zinc-200 bg-white transition-[transform,width] duration-300 ease-in-out lg:static lg:h-screen lg:flex-shrink-0 lg:translate-x-0">
            <x-sidebar />
        </aside>

        <div
            class="flex min-h-screen w-full flex-col bg-white transition-all duration-300 ease-in-out min-w-0 lg:ml-0 lg:pl-0">
            {{-- header --}}
            <header class="border-b-[1.5px] border-zinc-200 font-inter">
                <div class="flex items-center p-[14px]">
                    <h4 class="font-semibold text-3xl">@yield('titlePageContent', 'Title Page Content')</h4>
                </div>
            </header>
            {{-- Konten main --}}
            <main class="h-screen flex-1 overflow-y-auto bg-white font-inter">
                @yield('content')
            </main>
        </div>

        <div class="fixed inset-0 z-30 bg-slate-900/40 transition-opacity lg:hidden"></div>
    </div>

    @stack('scripts')
</body>

</html>
