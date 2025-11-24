@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Tambah Pengguna</h1>
            <p class="text-sm text-zinc-600">Isi data pengguna dan tentukan role serta status aktif.</p>
        </div>

        <form action="{{ route('sirekap.users.store') }}" method="POST" class="space-y-6">
            @csrf

            @include('cruds.users._form')
        </form>
    </div>
@endsection
