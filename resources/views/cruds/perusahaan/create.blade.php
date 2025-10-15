@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Tambah P3MI')

@section('headerActions')
    <a href="{{ route('disnakertrans.perusahaan.index') }}"
        class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100">
        <x-heroicon-o-arrow-left class="h-4 w-4" />
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto w-full px-4 py-6">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-zinc-200">
            <h2 class="text-lg font-semibold text-zinc-800">Formulir Perusahaan</h2>
            <p class="mt-1 text-sm text-zinc-500">Masukkan informasi perusahaan untuk menambahkan data baru.</p>

            <form action="{{ route('disnakertrans.perusahaan.store') }}" method="POST" class="mt-6 space-y-6">
                @csrf

                @include('cruds.perusahaan.partials.form', ['submitLabel' => 'Simpan'])
            </form>
        </div>
    </div>
@endsection
