<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    <title>Sirekap Pasmi | Auth Login</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex flex-col h-full bg-zinc-100 font-inter px-4 py-6 space-y-2 items-center justify-center">
    <main class="grid grid-cols-12 px-[5rem] gap-10">
        <div class="grid col-span-8">
            <div class="">
                <div class="fixed flex items-center top-4 left-14 z-20 my-4 mx-8 w-full">
                    <img src="{{ asset('asset/logo/W-logo.png') }}" alt="Logo" class="h-10 w-auto">
                </div>
                <div class="block text-zinc-800 space-y-2">
                    <h2 class="font-bold text-xl">Sirekap</h2>
                    <h1 class="font-bold text-5xl">Solusi Digital untuk Manajemen Paspor CPMI</h1>
                    <p class="font-semibold text-sm/6 w-[35rem]">Pantau seluruh proses pengajuan paspor CPMI secara
                        realtime, aman, dan terstruktur dalam satu dashboard modern.</p>
                </div>
            </div>
        </div>
        <div class="grid col-span-4 rounded-sm bg-white border-[1.5px] px-6 py-4 shadow-sm max-w-sm">
            <div class="flex flex-col items-center justify-center space-y-2">
                <img src="{{ asset('asset/logo/lombok_tengah2.png') }}" alt="Logo" class="h-12 w-auto">
                <h1 class="text-xl font-medium text-center">Login akun Sirekap</h1>
            </div>
            @if (session('success'))
                <div class="rounded-sm border border-green-500 bg-green-50 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-sm border border-red-500 bg-red-50 p-3 text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="identifier" class="text-sm font-medium text-slate-900">Email / NIP</label>
                    <div class="relative">
                        <input id="identifier" name="identifier" type="text" autocomplete="username" required
                            value="{{ old('identifier') }}"
                            class="w-full py-2 px-2 border rounded-sm focus:outline-none" />
                        <div class="absolute inset-y-0 right-2 flex items-center text-slate-500">
                            <x-heroicon-o-at-symbol class="h-5 w-5" />
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between text-md">
                        <label for="password" class="text-sm font-medium text-slate-900">Password</label>
                    </div>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input id="password" name="password" type="password"
                            x-bind:type="showPassword ? 'text' : 'password'" autocomplete="current-password" required
                            class="w-full py-2 px-2 pr-12 border rounded-sm focus:outline-none" />
                        <button type="button"
                            class="absolute inset-y-0 right-2 flex items-center text-slate-500 focus:outline-none"
                            @click="showPassword = !showPassword" aria-label="Tampilkan password"
                            x-bind:aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">
                            <x-heroicon-o-eye x-show="!showPassword" x-cloak class="h-5 w-5" />
                            <x-heroicon-o-eye-slash x-show="showPassword" x-cloak class="h-5 w-5" />
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="remember" id="remember" value="1"
                            class="h-4 w-4 border-slate-400" hi>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-sm bg-green-500 p-3 font-semibold text-black transition-all hover:bg-green-400 focus:outline-none">
                    Login
                </button>

                <div class="text-sm">
                    Sistem Informasi Rekapitulasi Data dan Manajemen Internal yang terintegrasi.
                    </p>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
