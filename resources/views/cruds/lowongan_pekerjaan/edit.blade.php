@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Ubah Lowongan Pekerjaan')

@section('headerActions')
    <div class="flex items-center gap-2">
        <a href="{{ route('disnakertrans.lowongan-pekerjaan.index') }}"
            class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali
        </a>
        <a href="{{ route('disnakertrans.lowongan-pekerjaan.show', $lowonganPekerjaan) }}"
            class="inline-flex items-center gap-2 rounded-md border border-blue-200 px-3 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50">
            <x-heroicon-o-eye class="h-4 w-4" />
            Lihat Detail
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto w-full px-4 py-6">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-zinc-200">
            <h2 class="text-lg font-semibold text-zinc-800">Perbarui Lowongan</h2>
            <p class="mt-1 text-sm text-zinc-500">Perbaharui data lowongan pekerjaan di bawah ini.</p>

            @if (session('success'))
                <div class="mt-4 rounded-md border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('disnakertrans.lowongan-pekerjaan.update', $lowonganPekerjaan) }}" method="POST"
                class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                @include('cruds.lowongan_pekerjaan.partials.form', ['submitLabel' => 'Simpan Perubahan'])
            </form>
        </div>
    </div>
@endsection
