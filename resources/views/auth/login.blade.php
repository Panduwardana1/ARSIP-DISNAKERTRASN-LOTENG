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

<body class="flex h-full bg-zinc-300 font-inter px-4 py-6 items-center justify-center">
    <main class="space-y-4">
        <div class="grid bg-white border p-8 w-[28rem] rounded-md">
            <div class="flex flex-col items-center justify-center space-y-2">
                <h1 class="font-semibold text-3xl">Selamat Datang</h1>
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
                    <label for="identifier" class="text-sm font-semibold text-slate-900">Email / NIP</label>
                    <div class="relative">
                        <input id="identifier" name="identifier" type="text" required value="{{ old('identifier') }}"
                            inputmode="text" autocomplete="username" pattern="(?:[0-9]{18}|[^@\s]+@[^@\s]+\.[^@\s]+)"
                            title="Masukkan email atau NIP 18 digit"
                            class="w-full py-3 px-4 border-[1.5px] rounded-md focus:outline-none"
                            placeholder="Email atau NIP 18 digit" />
                        <div class="absolute inset-y-0 right-2 flex items-center text-slate-500">
                            <x-heroicon-o-at-symbol class="h-5 w-5" />
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between text-md">
                        <label for="password" class="text-sm font-semibold text-slate-900">Password</label>
                    </div>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input id="password" name="password" type="password"
                            x-bind:type="showPassword ? 'text' : 'password'" autocomplete="current-password" required
                            class="w-full py-3 px-4 pr-12 border-[1.5px] rounded-md focus:outline-none"
                            placeholder="Password" />
                        <button type="button"
                            class="absolute inset-y-0 right-2 flex items-center text-slate-500 focus:outline-none"
                            @click="showPassword = !showPassword" aria-label="Tampilkan password"
                            x-bind:aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">
                            <x-heroicon-o-eye x-show="!showPassword" x-cloak class="h-5 w-5" />
                            <x-heroicon-o-eye-slash x-show="showPassword" x-cloak class="h-5 w-5" />
                        </button>
                    </div>
                    <dic class="flex gap-2">
                        <x-heroicon-s-exclamation-circle class="h-4 w-4 text-zinc-400" />
                        <span class="text-xs font-medium text-zinc-400">Gunakan minimal 6 karakter, dengan kombinasi
                            huruf besar, huruf kecil, dan angka.</span>
                    </dic>
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
            </form>
        </div>
        <div class="flex items-center justify-center gap-4 p-4 border rounded-md bg-white">
            <img src="{{ asset('asset/logo/lombok_tengah2.png') }}" alt="Logo-sirekap" class="h-6 w-auto">
            <img src="{{ asset('asset/logo/kominfo.png') }}" alt="Logo-sirekap" class="h-6 w-auto">
            <img src="{{ asset('asset/logo/primary.png') }}" alt="Logo-sirekap" class="h-6 w-auto">
        </div>
    </main>
</body>

</html>
