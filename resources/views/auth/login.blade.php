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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex h-full bg-amber-600 font-inter px-4 py-4 items-center justify-center">
    <main class="space-y-4">
        <div class="grid bg-white border p-8 w-[28rem] rounded-sm space-y-2">
            <div class="flex flex-col justify-center items-center">
                <img src="{{ asset('asset/logo/primary.png') }}" alt="Logo" class="h-10 w-auto">
            </div>
            <div class="flex flex-col items-center justify-center space-y-2">
                <h1 class="font-semibold text-3xl">Selamat Datang</h1>
            </div>

            @if (session('success'))
                <x-alert type="success" message="{{ session('success') }}" />
            @endif

            @if (session('error'))
                <x-alert type="error" message="{{ session('error') }}" />
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
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox" name="remember" id="remember" value="1"
                            class="h-4 w-4 border-slate-400" hi>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <div class="mt-4">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>

                    {{-- Error validasi captcha jika tidak dicentang --}}
                    @error('g-recaptcha-response')
                        <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-sm bg-green-500 p-3 font-semibold text-black transition-all hover:bg-green-400 focus:outline-none">
                    Login
                </button>
            </form>
        </div>
    </main>
</body>

</html>
