@extends('layouts.app')

@section('pageTitle', 'Tambah Negara')

@section('content')
    @php
        $statusOptions = ['Aktif' => 'Aktif', 'Banned' => 'Banned'];
        $selectedStatus = old('is_active', 'Aktif');
    @endphp

    <div class="max-w-xl mx-auto bg-white border border-zinc-200 shadow-sm rounded-lg p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Tambah Negara</h1>
        </div>

        <form action="{{ route('sirekap.negara.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- todo form craete --}}
            <div>
                @include('cruds.negara.form')
            </div>
        </form>
    </div>
@endsection
