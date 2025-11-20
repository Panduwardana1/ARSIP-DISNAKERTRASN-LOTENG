@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Ubah Pendidikan')
@section('Title', 'Pendidikan')

@section('content')
    <div class="max-w-xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Pendidikan</h1>
        </div>

        @if ($errors->has('app'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('app') }}
            </div>
        @endif

        <form action="{{ route('sirekap.pendidikan.update', $pendidikan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                @include('cruds.pendidikan._form', ['pendidikan' => $pendidikan])
            </div>

        </form>
    </div>
@endsection
