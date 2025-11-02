<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sirekap Pasmi | Auth Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-zinc-50 px-4 py-12 flex items-center justify-center">
    <main class="w-full max-w-sm font-inter">
        <div class="rounded-lg border border-zinc-300 p-8 backdrop-blur">
            <div class="mb-8 flex flex-col items-center justify-center space-y-3">
                <img src="{{ asset('asset/logo/icon.png') }}" alt="Logo" class="h-10 w-10">
                <div class="space-y-0 text-center">
                    <h3 class="text-md font-medium text-zinc-600">Selamat datang di</h3>
                    <h1 class="text-3xl font-medium">SIREKAP PASMI</h1>
                    <p class="mt-2 text-xs text-zinc-600">Masuk untuk mengelola layanan Disnakertrans</p>
                </div>
            </div>

            <form action="" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-zinc-600">Email</label>
                    <div class="relative">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="w-full px-2 py-2 bg-zinc-100 border rounded-lg focus:outline-none"
                            placeholder="nama@disnakertrans.go.id" />
                        <x-heroicon-o-envelope
                            class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-300" />
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <label for="password" class="font-medium text-zinc-600">Password</label>
                    </div>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full px-2 py-2 bg-zinc-100 border rounded-lg focus:outline-none"
                            placeholder="Minimal 8 karakter" />
                        <x-heroicon-o-lock-closed
                            class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-300" />
                    </div>
                </div>

                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 font-inter font-semibold text-white transition-all hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-200 active:bg-amber-700">
                    Login
                </button>
            </form>
        </div>
    </main>
</body>

</html>
