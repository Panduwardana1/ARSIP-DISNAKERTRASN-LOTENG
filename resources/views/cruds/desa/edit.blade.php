@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Ubah Desa/Kelurahan')
@section('titlePageContent', 'Ubah Data Desa/Kelurahan')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Desa/Kelurahan</h1>
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

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-medium text-zinc-700">
                        Nama Desa/Kelurahan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        value="{{ old('nama', $desa->nama) }}"
                        maxlength="100"
                        required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('nama')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kecamatan_id" class="block text-sm font-medium text-zinc-700">
                        Kecamatan Induk <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="kecamatan_id"
                        id="kecamatan_id"
                        required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Pilih kecamatan...</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" @selected(old('kecamatan_id', $desa->kecamatan_id) == $kecamatan->id)>
                                {{ $kecamatan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('sirekap.desa.index') }}"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
