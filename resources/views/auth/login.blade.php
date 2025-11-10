<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sirekap Pasmi | Auth Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex flex-col bg-zinc-100 font-outfit px-4 py-12 items-center justify-center">
    <main class="w-full max-w-md shadow-sm">
        <div class="rounded-lg bg-white border-[1.5px] p-8 backdrop-blur">
            <div class="mb-8 flex flex-col items-center justify-center space-y-3">
                <div class="space-y-0 text-center">
                    <h1 class="text-4xl font-medium">Welcome Back!</h1>
                </div>
            </div>

            <form action="" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-slate-900">E-mail address</label>
                    <div class="relative">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="w-full p-3 border rounded-sm focus:outline-none" />
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
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
                    class="flex w-full items-center justify-center gap-2 rounded-sm bg-amber-500 p-3 font-semibold text-slate-900 transition-all hover:bg-amber-600 focus:outline-none">
                    Login
                </button>
            </form>
        </div>
    </main>
</body>

</html>
