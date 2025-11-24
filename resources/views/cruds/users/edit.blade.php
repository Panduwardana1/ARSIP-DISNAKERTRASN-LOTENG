@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Edit Pengguna')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Edit Pengguna</h1>
            <p class="text-sm text-zinc-600">Perbarui informasi pengguna, status, dan password.</p>
        </div>

        <form action="{{ route('sirekap.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @include('cruds.users._form', ['user' => $user])
        </form>
    </div>
@endsection
