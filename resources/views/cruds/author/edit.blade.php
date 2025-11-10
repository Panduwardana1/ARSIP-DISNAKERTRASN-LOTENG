@extends('layouts.app')

@section('pageTitle', 'SIREKAP - Author | Ubah')
@section('Title', 'Ubah Author')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-zinc-900">Perbarui Data Author</h2>
            <p class="text-sm text-zinc-500">Pastikan data sesuai dengan SK terbaru.</p>

            <form action="{{ route('sirekap.author.update', $author) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @method('PUT')
                @include('cruds.author._form', ['author' => $author])
            </form>
        </div>
    </div>
@endsection
