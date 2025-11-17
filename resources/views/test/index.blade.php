<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>TESTING</title>
</head>

<body class="">

    {{-- <div class="flex items-start bg-white shadow-lg rounded-lg p-4 gap-3 border max-w-xs font-inter">

        <div class="flex items-center justify-center h-7 w-7 rounded-full bg-green-600 text-white">
            <x-heroicon-o-check-circle class="h-6 w-6" />
        </div>

        <div class="flex flex-col">
            <span class="font-semibold text-[15px] text-gray-800 leading-tight">
                Success
            </span>

            <p class="text-sm text-gray-600 leading-snug">
                Berhasil ditambahkan
            </p>
        </div>

    </div> --}}

    <div class="flex items-center max-w-2xl justify-center gap-4 font-inter">
        <div>
            <img src="{{ asset('asset/images/lombok_tengah2.png') }}" alt="Logo" class="h-20 w-auto">
        </div>
        <div class="text-center space-y-0 m-0">
            <span class="font-normal text-xl leading-none tracking-tight">PEMERINTAH KABUPATEN LOMBOK TENGAH</span>
            <h1 class="text-2xl font-semibold leading-none tracking-tight">DINAS TENAGA KERJA DAN TRANSMIGRASI</h1>
            <p class="leading-snug tracking-tighter">Alamat : Jl. S. Parman No. 5 Telepon (0370) 653130, Praya 83511</p>
        </div>
    </div>
</body>

</html>
