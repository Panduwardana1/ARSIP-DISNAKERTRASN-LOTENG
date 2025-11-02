@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Detail Kecamatan')
@section('titlePageContent', 'Detail Kecamatan')

@section('content')
    <div class="space-y-6">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-6 md:grid-cols-2">
                <div>
                    <dt class="text-sm font-semibold text-slate-500">Nama Kecamatan</dt>
                    <dd class="mt-1 text-base font-medium text-slate-800">{{ $kecamatan->nama }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-500">Kode Kecamatan</dt>
                    <dd class="mt-1 text-base font-medium text-slate-800">{{ $kecamatan->kode }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-500">Dibuat</dt>
                    <dd class="mt-1 text-base text-slate-700">{{ optional($kecamatan->created_at)->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-semibold text-slate-500">Diperbarui</dt>
                    <dd class="mt-1 text-base text-slate-700">{{ optional($kecamatan->updated_at)->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('sirekap.kecamatan.index') }}"
                class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                Kembali
            </a>
            <a href="{{ route('sirekap.kecamatan.edit', $kecamatan) }}"
                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Edit Data
            </a>
        </div>
    </div>
@endsection
