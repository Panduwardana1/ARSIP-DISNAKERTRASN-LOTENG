<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('pageTitle', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('head')
</head>

<body class="antialiase">
    <x-layouts :title="trim($__env->yieldContent('pageTitle')) ?: null" :subtitle="trim($__env->yieldContent('pageSubtitle')) ?: null">
        @hasSection('headerLeft')
            <x-slot name="headerLeft">@yield('headerLeft')</x-slot>
        @endif

        @hasSection('titlePageContent')
            <x-slot name="titlePageContent">@yield('titlePageContent')</x-slot>
        @endif

        @hasSection('headerActions')
            <x-slot name="headerActions">@yield('headerActions')</x-slot>
        @endif

        @yield('content')
    </x-layouts>

    @stack('scripts')
    @vite('resources/js/app.js')
</body>

</html>
