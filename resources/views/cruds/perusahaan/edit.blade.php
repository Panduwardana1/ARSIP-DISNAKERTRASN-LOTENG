@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | P3MI | Ubah')

@section('content')
    <div class="max-w-xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Perusahaan</h1>
        </div>

        @if ($errors->has('message'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('message') }}
            </div>
        @endif

        <form action="{{ route('sirekap.perusahaan.update', $perusahaan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            @include('cruds.perusahaan._form', ['perusahaan' => $perusahaan])
        </form>
    </div>
@endsection
