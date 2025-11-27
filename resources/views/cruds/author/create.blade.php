@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Tambah Author')
@section('Title', 'Author')

@section('content')
    <div class="max-w-xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Tambah Author Penandatangan</h1>
            <p class="mt-1 text-sm text-zinc-600">Masukkan data pejabat yang berwenang menandatangani surat rekomendasi.</p>
        </div>

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        <form action="{{ route('sirekap.author.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @include('cruds.author._form')

        </form>
    </div>
@endsection
