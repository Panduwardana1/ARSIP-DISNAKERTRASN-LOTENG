@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Ubah Author')
@section('Title', 'Author')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Author</h1>
            <p class="mt-1 text-sm text-zinc-600">Pastikan identitas pejabat sesuai SK dan siap dipakai untuk dokumen sistem.</p>
        </div>

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        <form action="{{ route('sirekap.author.update', $author) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @include('cruds.author._form', ['author' => $author])

            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('sirekap.author.index') }}"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
