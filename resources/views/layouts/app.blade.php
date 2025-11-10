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

<body class="h-screen w-[100%] bg-white font-outfit text-zinc-900 antialiased">

    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif

    @if (session('warning'))
        <x-alert type="warning" message="{{ session('warning') }}" />
    @endif

    <section class="flex grid-cols-[18rem_1fr]">
        <div class="h-[100vh] fixed left-0 top-0 z-50 w-60 border-r-[1.5px] border-r-zinc-200 bg-slate-900 py-2 px-4">
            <x-sidebar.sdiebar />
        </div>
        <main class="w-full ml-64 max-w-full min-h-screen flex-wrap bg-white space-y-2 overflow-y-auto scroll-smooth">
            <div
                class="flex items-center justify-between p-2 h-16 px-4 flex-wrap fixed right-0 top-0 z-40 border-l pl-[16rem] border-b-[1.5px] border-zinc-200 bg-zinc-50 w-full">
                <h2 class="font-semibold text-3xl text-zinc-800">@yield('Title')</h2>
                <a href="{{ route('sirekap.profile.index') }}"
                    class="bg-slate-900 text-white p-2 rounded-full font-semibold border ring-1">
                    OK
                </a>
            </div>
            <div class="pt-[5rem] px-2">
                @yield('content')
            </div>
        </main>
    </section>
    @stack('scripts')
</body>

</html>
