@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Tambah Desa')

@section('content')
    <div class="max-w-xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Tambah Desa</h1>
        </div>

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        <form action="{{ route('sirekap.desa.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                @include('cruds.desa.form')
            </div>
        </form>
    </div>
@endsection
