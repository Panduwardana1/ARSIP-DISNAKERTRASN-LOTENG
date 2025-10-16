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

<body class="antialiased bg-slate-100 text-slate-900 min-h-screen">
    {{-- Sidebar --}}
    <div class="fixed top-0 left-0 w-[15rem]">
        <x-sidebar />
    </div>
    {{-- Main --}}
    <main class="ml-[15rem] h-screen max-h-screen w-auto bg-white selection:bg-amber-600 selection:text-white">
        <div class="flex items-center justify-between px-4 py-6 bg-neutral-200/90 h-[4rem]">
            <h1 class="font-semibold font-inter text-2xl text-zinc-800">@yield('titleContent', 'Dashboard Overview')</h1>
            <div class="flex space-x-2 items-center font-inter">
                <span
                    class="inline-flex items-center rounded-md bg-amber-400/10 px-2 py-1.5 text-xs font-medium text-amber-700 inset-ring ring-amber-500 ring-1 inset-ring-red-400/20">Pimpinan</span>
                <div class="p-1.5 rounded-full bg-zinc-800 text-zinc-50">
                    <x-heroicon-o-user-circle class="h-7 w-7" />
                </div>
            </div>
        </div>
        {{-- Konten main --}}
        <div class="bg-white p-2 border h-screen">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>

</html>
