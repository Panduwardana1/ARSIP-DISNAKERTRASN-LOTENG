@extends('layouts.app')

@section('pageTitle', 'Ubah Negara')

@section('content')
    @php
        $statusOptions = ['Aktif' => 'Aktif', 'Banned' => 'Banned'];
        $selectedStatus = old('is_active', $negara->is_active ?? 'Aktif');
    @endphp

    <div class="max-w-xl mx-auto bg-white border border-zinc-200 shadow-sm rounded-lg p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Negara</h1>
        </div>

        <form action="{{ route('sirekap.negara.update', $negara) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                @include('cruds.negara.form', ['negara' => $negara])
            </div>
        </form>
    </div>
@endsection
