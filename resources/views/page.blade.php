<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIREKAP - PASMI | HOME</title>
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-white font-inter">
    <section class="grid">
        <header class="fixed left-0 top-0 z-50 min-w-full py-4 px-6 bg-transparent/5">
            <nav class="flex items-center justify-between  px-6 gap-4 font-medium text-zinc-800">
                <a href="#">
                    <img src="{{ asset('asset/logo/primary.png') }}" alt="Logo" class="h-10 w-auto">
                </a>
                <div class="flex items-center gap-6">
                    <a href="">Home</a>
                    <a href="">Home</a>
                    <a href="">Home</a>
                    <a href="">Home</a>
                    <a href="">Home</a>
                    <a href="">Home</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="#" class="px-3 py-1.5 rounded-md bg-amber-600 text-white">Register</a>
                    <a href="#" class="px-3 py-1.5 rounded-md bg-amber-600 text-white">Login</a>
                </div>
            </nav>
        </header>
        <main class="px-4">
            <div class="h-screen flex flex-col justify-center items-center space-y-3">
                <span class="font-medium">Lorem, ipsum dolor</span>
                <h1 class="font-medium text-5xl text-center">Lorem ipsum dolor sit amet <br> Lorem ipsum dolor sit amet consectetur</h1>
                <p class="text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Alias, architecto! Non neque sunt porro expedita eveniet? Vel corrupti, tempore, <br> voluptatibus consequuntur repellendus culpa magnam nobis possimus quam veritatis voluptatum rem.</p>
                <button class="pt-10 animate-bounce">
                    <x-heroicon-s-arrow-down class="h-12 w-full p-2 rounded-full bg-amber-500 text-zinc-800" />
                </button>
            </div>
        </main>
    </section>
</body>
</html>
