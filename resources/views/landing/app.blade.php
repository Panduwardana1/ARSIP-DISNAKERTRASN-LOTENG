<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Arsip Disnaker</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen font-inter text-neutral-800 antialiased">
    <nav class="fixed top-0 left-0 w-full max-h-full z-50 justify-center py-4 px-4 border-b">
        <h1 class="ml-12 font-semibold font-manrope text-2xl">Logo Disini</h1>
    </nav>
    <main class="grid min-h-screen lg:grid-cols-2">
        <section class="relative flex items-center justify-center overflow-hidden bg-white px-6 py-16 lg:px-16">
            <div class="flex max-w-xl flex-col gap-10">
                <div class="space-y-5">
                    <h2 class="text-4xl font-semibold text-neutral-800 lg:text-[2.75rem] lg:leading-[1.2]">
                        Sinkronisasi <span class="text-emerald-600">Arsip</span> dan rekomendasi <span
                            class="text-sky-600">Paspor</span>
                    </h2>
                    <p class="text-base text-neutral-500">
                        Distribusikan dokumen Disnakertrans ke banyak platform internal sekaligus, dengan pelacakan
                        real-time dan keamanan terjamin.
                    </p>
                </div>

                <div class="relative flex flex-col gap-6 lg:gap-8">
                    <div class="relative w-full max-w-full rounded-3xl border bg-white p-6 -rotate-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-600">SS</span>
                                <div>
                                    <p class="text-sm font-semibold text-neutral-900">Salman Shaikh</p>
                                    <p class="text-xs text-neutral-400">Des 4 &middot; 2 menit lalu</p>
                                </div>
                            </div>
                            <x-heroicon-o-ellipsis-vertical class="h-5 w-5 text-neutral-300" />
                        </div>
                        <div class="mt-6 space-y-3">
                            <h3 class="text-xl font-semibold text-neutral-900">Digitalisasi Arsip Disnaker</h3>
                            <p class="text-sm leading-relaxed text-neutral-500">
                                Mulai dari verifikasi dokumen, distribusi antar unit sampai tracking status otomatis
                                dengan insight yang mudah dipahami.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center justify-between text-xs text-neutral-400">
                            <span class="flex items-center gap-2">
                                <x-heroicon-o-eye class="h-4 w-4" />
                                Terlihat 128x
                            </span>
                            <span class="flex items-center gap-2">
                                <x-heroicon-o-arrow-up-right class="h-4 w-4" />
                                Bagikan
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="flex flex-col items-center justify-center px-6 py-12 lg:px-16">
            <div class="w-full max-w-[26rem] space-y-6">
                <div class="rounded-lg bg-neutral-50 border p-8">
                    <div class="space-y-3 text-center">
                        <div class="flex flex-col items-center justify-center space-y-1">
                            <img src="{{ asset('asset/logo.png') }}" alt="logo" class="h-16 w-auto p-2">
                            <h1 class="text-2xl font-semibold text-neutral-900">Masuk ke Arsip Disnaker</h1>
                        </div>
                    </div>
                    <form action="" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-3">
                            <label for="email" class="text-sm font-medium text-neutral-700">Email</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="w-full rounded-md border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-700 outline-none transition focus:bg-white focus:ring-2 focus:ring-blue-200"
                                placeholder="nama@disnakertrans.go.id" />
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <label for="password" class="font-medium text-neutral-700">Kata Sandi</label>
                                <a href="#"
                                    class="font-medium text-blue-500 transition hover:text-blue-400">Lupa kata
                                    sandi?</a>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                required
                                class="w-full rounded-md border border-neutral-200 bg-neutral-50 px-4 py-3 text-sm text-neutral-700 outline-none transition focus:bg-white focus:ring-2 focus:ring-blue-200"
                                placeholder="Minimal 8 karakter" />
                        </div>
                        <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-200">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
