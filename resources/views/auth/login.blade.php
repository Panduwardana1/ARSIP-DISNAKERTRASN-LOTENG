<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    <title>Sirekap Pasmi | Auth Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col bg-zinc-100 font-inter px-4 py-12 space-y-2 items-center justify-center">
    <main class="w-full max-w-md">
        <div class="rounded-lg bg-white border-[1.5px] p-8 shadow-sm space-y-4">
            <div class="flex flex-col justify-center items-center text-center">
                <img src="{{ asset('asset/logo/Icon.png') }}" alt="Logo" class="h-10 w-auto">
                <h1 class="text-4xl font-medium pt-2">Selamat Datang!</h1>
            </div>

            <form action="" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-md font-medium text-slate-900">E-mail address</label>
                    <div class="relative">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="w-full p-3 border rounded-sm focus:outline-none" />
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between text-md">
                        <label for="password" class="font-medium text-slate-900">Password</label>
                    </div>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full p-3 border rounded-sm focus:outline-none"/>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="felx items-center space-x-1.5">
                        <input type="checkbox" name="" id="">
                        <span>Remember Me</span>
                    </div>
                    <a href="#" class="text-blue-700 font-medium underline">Bantuan?</a>
                </div>

                <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-sm bg-amber-400 p-3 font-semibold text-slate-900 transition-all hover:bg-amber-300 focus:outline-none">
                    Login
                </button>
            </form>
            <span class="text-sm line-clamp-2">
                By signing in, you accept our Terms of Use, our Privacy Policy and that your data is stored in the USA.
            </span>
        </div>
    </main>
     <div class="w-full max-w-md h-10 flex items-center justify-center p-2 border bg-white border-s shadow-sm">
        Or <a href="#" class="font-semibold text-sky-600 px-1">click here</a> to create your account.
    </div>
</body>

</html>
