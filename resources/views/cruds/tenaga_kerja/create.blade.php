@extends('layouts.app')

@php
    /** @var \Illuminate\Support\Collection|\App\Models\Perusahaan[] $perusahaans */
    /** @var \Illuminate\Support\Collection|\App\Models\Kecamatan[] $kecamatans */
    /** @var \Illuminate\Support\Collection|\App\Models\Desa[] $desas */
    /** @var \Illuminate\Support\Collection|\App\Models\Pendidikan[] $pendidikans */
    /** @var \Illuminate\Support\Collection|\App\Models\Agency[] $agencies */
    /** @var \Illuminate\Support\Collection|\App\Models\Negara[] $negaras */
    /** @var array $genders */
    $formTitle = 'Tambah Data Tenaga Kerja';
@endphp

@section('pageTitle', $formTitle)
@section('Title', 'Tenaga Kerja')

@section('content')
    <section class="container mx-auto space-y-6 px-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900">{{ $formTitle }}</h1>
                <p class="text-sm text-zinc-600">
                    Lengkapi identitas, domisili, dan relasi penempatan CPMI secara terstruktur.
                </p>
            </div>
        </div>

        @error('app')
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $message }}
            </div>
        @enderror

        @if ($errors->any())
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <p class="font-semibold">Periksa kembali data berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto w-full max-w-6xl">
            <form action="{{ route('sirekap.tenaga-kerja.store') }}" method="POST" class="space-y-2 border">
                @csrf

                @include('cruds.tenaga_kerja._form')
            </form>
        </div>
    </section>
@endsection
