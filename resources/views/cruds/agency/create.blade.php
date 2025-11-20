@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Tambah Agency')

@section('content')
    <div class="max-w-xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Tambah Agency</h1>
        </div>

        <form action="{{ route('sirekap.agency.store') }}" method="POST" class="space-y-6">
            @csrf

            @include('cruds.agency._form')
        </form>
    </div>
@endsection
