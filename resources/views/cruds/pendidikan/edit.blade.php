@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Ubah Pendidikan')
@section('Title', 'Pendidikan')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900">Perbarui Data Pendidikan</h1>
            <p class="mt-1 text-sm text-zinc-600">
                Sesuaikan kode singkat dan label pendidikan agar mengikuti ketentuan terbaru di seluruh modul.
            </p>
        </div>

        @if ($errors->has('app'))
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first('app') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                <p class="font-semibold">Periksa kembali data berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sirekap.pendidikan.update', $pendidikan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-medium text-zinc-700">
                        Kode Pendidikan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $pendidikan->nama) }}"
                        maxlength="10"
                        required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm uppercase tracking-wide focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('nama')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="label" class="block text-sm font-medium text-zinc-700">
                        Label Pendidikan <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="label"
                        name="label"
                        value="{{ old('label', $pendidikan->label) }}"
                        maxlength="100"
                        required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    @error('label')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a
                    href="{{ route('sirekap.pendidikan.show', $pendidikan) }}"
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
