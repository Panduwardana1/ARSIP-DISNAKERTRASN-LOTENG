<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
</head>

<body class="min-h-screen font-inter bg-orange-600 text-zinc-800 font-outfit">
    <div role="main" class="grid min-h-full h-screen place-items-center px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <p class="text-base font-semibold text-white">@yield('code')</p>
            <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-white sm:text-7xl">@yield('message', '404')
            </h1>
            <div class="mt-10 flex items-center justify-center gap-x-6 text-white">
                <p>Kembali kehalaman sebelumnya</p>
            </div>
        </div>
    </div>
</body>
</html>
