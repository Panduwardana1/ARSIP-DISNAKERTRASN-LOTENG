@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Tambah Data CPMI Baru')

@section('content')
    <div class="max-w-full mx-auto w-full">
        <div class="bg-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold font-inter text-zinc-800">Formulir CPMI</h2>
                    <p class="mt-1 text-sm font-inter text-zinc-500">Lengkapi data berikut untuk menambahkan tenaga kerja
                        baru.</p>
                </div>
                <a href="{{ route('disnakertrans.pekerja.index') }}"
                    class="flex items-center gap-1 py-1 px-2 font-inter font-semibold text-md border border-neutral-300 bg-neutral-100 text-neutral-700 hover:bg-neutral-200 hover:border-neutral-400 transition-colors ease-in rounded-md">
                    <x-heroicon-o-arrow-left class="h-4 w-4" />
                    Kembali
                </a>
            </div>
            <form action="{{ route('disnakertrans.pekerja.store') }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @include('cruds.tenaga_kerja.partials.form', ['submitLabel' => 'Simpan'])
            </form>
        </div>
    </div>
@endsection
