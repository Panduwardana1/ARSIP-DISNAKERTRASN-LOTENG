@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Tambah Agency')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Tambah Agency Penempatan</h1>
            <p class="mt-1 text-sm text-zinc-600">Hubungkan agency dengan perusahaan mitra dan lengkapi detail peluang.</p>
        </div>

        @if ($errors->has('db'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('db') }}
            </div>
        @endif

        <form action="{{ route('sirekap.agency.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nama" class="block text-sm font-medium text-zinc-700">
                    Nama Agency <span class="text-rose-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama"
                    id="nama"
                    value="{{ old('nama') }}"
                    maxlength="100"
                    required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Contoh: PT Amanah Jaya Agency"
                >
                @error('nama')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="perusahaan_id" class="block text-sm font-medium text-zinc-700">
                    Perusahaan Mitra <span class="text-rose-500">*</span>
                </label>
                <select
                    name="perusahaan_id"
                    id="perusahaan_id"
                    required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Pilih perusahaan...</option>
                    @foreach ($perusahaans as $perusahaan)
                        <option value="{{ $perusahaan->id }}" @selected(old('perusahaan_id') == $perusahaan->id)>
                            {{ $perusahaan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('perusahaan_id')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="lowongan" class="block text-sm font-medium text-zinc-700">
                        Ringkasan Lowongan
                    </label>
                    <input
                        type="text"
                        name="lowongan"
                        id="lowongan"
                        value="{{ old('lowongan') }}"
                        maxlength="100"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Contoh: Caregiver, Manufacturing"
                    >
                    @error('lowongan')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keterangan" class="block text-sm font-medium text-zinc-700">
                        Keterangan Tambahan
                    </label>
                    <textarea
                        name="keterangan"
                        id="keterangan"
                        rows="4"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Masukkan catatan penting mengenai agency.">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('sirekap.agency.index') }}"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
