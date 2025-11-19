@extends('layouts.app')

@section('pageTitle', 'Ubah Negara')

@section('content')
    @php
        $statusOptions = ['Aktif' => 'Aktif', 'Banned' => 'Banned'];
        $selectedStatus = old('is_active', $negara->is_active ?? 'Aktif');
    @endphp

    <div class="max-w-3xl mx-auto bg-white border border-zinc-200 shadow-sm rounded-lg p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Negara</h1>
            <p class="text-sm text-zinc-600 mt-1">Perbarui informasi negara kemudian simpan.</p>
        </div>

        <form action="{{ route('sirekap.negara.update', $negara) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-zinc-700">
                    Nama Negara <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $negara->nama) }}" maxlength="100"
                    required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Contoh: INDONESIA">
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kode_iso" class="block text-sm font-medium text-zinc-700">
                    Kode ISO <span class="text-red-500">*</span>
                </label>
                <input type="text" id="kode_iso" name="kode_iso" value="{{ old('kode_iso', $negara->kode_iso) }}"
                    maxlength="5" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 uppercase tracking-wide focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Contoh: IDN">
                @error('kode_iso')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('sirekap.negara.index') }}"
                    class="px-4 py-2 rounded-md border border-zinc-300 text-sm font-medium text-zinc-700 hover:bg-zinc-50">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    Perbarui Negara
                </button>
            </div>
        </form>
    </div>
@endsection
