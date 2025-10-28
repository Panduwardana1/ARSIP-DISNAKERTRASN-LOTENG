<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sirekap Pasmi | Auth Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen font-inter text-neutral-700 bg- antialiased">
    <main class="flex min-h-screen items-center justify-center">
        <div class="relative w-full overflow-hidden bg-white">
            <div class="grid gap-0 lg:grid-cols-2">
                <section
                    class="relative col-span-1 flex h-screen flex-col justify-between overflow-hidden bg-gradient-to-t from-sky-600 from-20% via-sky-400 via-20% to-sky-500 px-8 py-10 sm:px-12 lg:px-14">
                    <div class="space-y-4 text-white">
                        <span class="text-xs font-semibold uppercase tracking-wide text-sky-200">Sirekap Pasmi</span>
                        <h2 class="text-2xl font-semibold">Portal Arsip dan Pencatatan</h2>

                    </div>
                    <div class="space-y-2 text-white">
                        <h3 class="text-2xl font-bold leading-snug sm:text-3xl">Kelola Data Arsip CPMI Dengan Efisien.
                        </h3>
                        <p class="max-w-md text-sm leading-relaxed text-sky-100">Sistem ini membantu tim Disnakertrans
                            menjaga kelengkapan data pencatatan tenaga kerja, memastikan arsip digital tersusun rapi dan
                            mudah ditemukan kapan pun dibutuhkan.</p>
                        <img src="{{ asset('asset/Resume folder-cuate.png') }}" alt="illustration"
                            class="w-full max-w-lg">
                    </div>
                </section>
                <section
                    class="relative flex flex-col items-center justify-center min-h-screen sm:px-24 lg:px-16 bg-neutral-50">
                    <div class="w-full space-y-6 max-w-sm">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('asset/logo.png') }}" alt="logo" class="h-16 w-auto flex flex-col">
                        </div>
                        <h1 class="text-xl font-semibold text-center text-neutral-900 sm:text-2xl">Selamat Datang
                            Kembali</h1>
                        <form action="" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-neutral-600">Email</label>
                                <div class="relative">
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                        class="w-full rounded-md border border-neutral-200 bg-neutral-50 px-4 py-2 text-sm text-neutral-700 outline-none transition focus:border-blue-300 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                        placeholder="nama@disnakertrans.go.id" />
                                    <x-heroicon-o-envelope
                                        class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-300" />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <label for="password" class="font-medium text-neutral-600">Password</label>
                                </div>
                                <div class="relative">
                                    <input id="password" name="password" type="password"
                                        autocomplete="current-password" required
                                        class="w-full rounded-md border border-neutral-200 bg-neutral-50 px-4 py-2 text-sm text-neutral-700 outline-none transition focus:border-blue-300 focus:bg-white focus:ring-4 focus:ring-blue-100"
                                        placeholder="Minimal 8 karakter" />
                                    <x-heroicon-o-lock-closed
                                        class="pointer-events-none absolute right-4 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-300" />
                                </div>
                            </div>

                            <button type="submit"
                                class="flex w-full py-2 px-2 font-inter font-semibold text-white items-center justify-center gap-2 rounded-md bg-sky-500 hover:bg-sky-600 active:outline-none ease-out transition-all ">
                                Login
                            </button>
                        </form>
                    </div>

                    <div class="mt-12 flex flex-wrap items-center justify-between gap-4 text-xs text-neutral-400">
                        <p>© {{ date('Y') }} Disnakertrans. Hak cipta dilindungi.</p>
                        <div class="flex items-center gap-4">
                            <a href="#" class="transition hover:text-blue-500">Kebijakan Privasi</a>
                            <a href="#" class="transition hover:text-blue-500">Syarat Layanan</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>

</html>
