@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Ubah Desa')

@section('content')
    <div class="max-w-xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Desa</h1>
            <p class="mt-1 text-sm text-zinc-600">Pastikan nama dan kecamatan induk sudah sesuai.</p>
        </div>

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        <form action="{{ route('sirekap.desa.update', $desa) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                @include('cruds.desa.form', ['desa' => $desa, 'kecamatans' => $kecamatans])
            </div>
        </form>
    </div>
@endsection
