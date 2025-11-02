@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Tambah Desa/Kelurahan')
@section('titlePageContent', 'Tambah Data Desa/Kelurahan')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('sirekap.desa.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-slate-700">Nama</label>
                    <input type="text" name="nama" id="nama"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kecamatan_id" class="block text-sm font-semibold text-slate-700">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id"
                        class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kecamatan_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" @selected(old('kecamatan_id') == $kecamatan->id)>
                                {{ $kecamatan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="tipe" class="block text-sm font-semibold text-slate-700">Tipe Wilayah</label>
                <select name="tipe" id="tipe"
                    class="mt-1 block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipe') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                    required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="desa" @selected(old('tipe') === 'desa')>Desa</option>
                    <option value="kelurahan" @selected(old('tipe') === 'kelurahan')>Kelurahan</option>
                </select>
                @error('tipe')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('sirekap.desa.index') }}"
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
