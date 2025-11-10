@extends('layouts.app')

@section('pageTitle', 'SIREKAP - Author | Tambah')
@section('Title', 'Tambah Author')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">Form Tambah Author</h2>
            <p class="text-sm text-zinc-500">Isi data pejabat yang akan digunakan untuk penandatangan rekomendasi.</p>

            <form action="{{ route('sirekap.author.store') }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @include('cruds.author._form', ['author' => null])
            </form>
        </div>
    </div>
@endsection
