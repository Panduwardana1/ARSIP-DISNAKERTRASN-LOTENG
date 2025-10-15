@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Ubah Tenaga Kerja')

@section('headerActions')
    <div class="flex items-center gap-2">
        <a href="{{ route('disnakertrans.pekerja.index') }}"
            class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali
        </a>
        <a href="{{ route('disnakertrans.pekerja.show', $tenagaKerja) }}"
            class="inline-flex items-center gap-2 rounded-md border border-blue-200 px-3 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50">
            <x-heroicon-o-eye class="h-4 w-4" />
            Lihat Detail
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto w-full px-4 py-6">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-zinc-200">
            <h2 class="text-lg font-semibold text-zinc-800">Perbarui Data Tenaga Kerja</h2>
            <p class="mt-1 text-sm text-zinc-500">Sesuaikan informasi berikut kemudian simpan perubahan.</p>

            @if (session('success'))
                <div class="mt-4 rounded-md border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('disnakertrans.pekerja.update', $tenagaKerja) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                @include('cruds.tenaga_kerja.partials.form', ['submitLabel' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
@endsection
