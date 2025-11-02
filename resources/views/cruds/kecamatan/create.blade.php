@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Tambah Kecamatan')
@section('titlePageContent', 'Tambah Data Kecamatan')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('sirekap.kecamatan.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700">Nama Kecamatan</label>
                    <input type="text" name="nama" id="nama"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kode" class="block text-sm font-semibold text-slate-700">Kode Kecamatan</label>
                    <input type="text" name="kode" id="kode" maxlength="10"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm uppercase shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kode') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('kode') }}" required>
                    @error('kode')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('sirekap.kecamatan.index') }}"
                    class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
