@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Ubah Author')
@section('Title', 'Author')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Author</h1>
            <p class="mt-1 text-sm text-zinc-600">Pastikan identitas pejabat sesuai SK dan siap dipakai untuk dokumen sistem.
            </p>
        </div>

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        <form action="{{ route('sirekap.author.update', $author) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                @include('cruds.author._form', ['author' => $author])
            </div>
        </form>
    </div>
@endsection
