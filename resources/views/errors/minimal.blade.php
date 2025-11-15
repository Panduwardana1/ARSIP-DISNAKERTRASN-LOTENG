<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
</head>

<body
    class="min-h-screen bg-gradient-to-b from-zinc-50 to-white text-zinc-800 font-outfit">
    <main role="main" class="grid min-h-screen place-items-center p-6">
        <section aria-labelledby="error-title" aria-describedby="error-desc" class="w-full max-w-5xl">
            <div class="grid items-center gap-10 lg:grid-cols-[1fr_auto]">

                <!-- Teks -->
                <div class="space-y-6 text-center lg:text-left">
                    <p class="text-xl font-semibold uppercase tracking-[0.6em] text-amber-500/90">
                        Oops!
                    </p>

                    <div class="text-6xl sm:text-7xl md:text-8xl lg:text-9xl font-extrabold leading-none">
                        <span
                            class="bg-gradient-to-b from-amber-500 to-orange-600 bg-clip-text text-transparent drop-shadow">
                            @yield('code', '404')
                        </span>
                    </div>

                    <h1 id="error-title" class="text-2xl font-semibold sm:text-3xl">
                        @yield('message', 'Halaman tidak ditemukan')
                    </h1>

                    <p id="error-desc" class="text-sm text-zinc-500 dark:text-zinc-400">
                        Coba kembali ke halaman sebelumnya atau menuju beranda.
                    </p>
                </div>

                <!-- Ilustrasi -->
                <div class="mx-auto lg:mx-0">
                    <img src="{{ asset('asset/images/Feeling sorry-cuate.png') }}" alt="Ilustrasi halaman error"
                        class="h-[38rem] w-auto select-none pointer-events-none" loading="lazy">
                </div>
            </div>
        </section>
    </main>
</body>


</html>
