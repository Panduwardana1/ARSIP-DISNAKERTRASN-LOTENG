@extends('layouts.app')

@section('content')
    <div class="min-h-screen space-y-6 bg-slate-50 p-4 font-inter md:p-6">
        <div class="rounded-3xl border border-slate-200/60 bg-white px-6 py-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-3">
                    <span class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-700">
                        Step 2 &bull; Review data sebelum cetak
                    </span>
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900">Preview Rekap Rekomendasi Paspor</h1>
                        <p class="text-sm text-slate-600">Tinjau kembali identitas CPMI berikut sebelum melanjutkan ke proses ekspor PDF.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <span class="rounded-full border border-slate-200/70 bg-slate-100 px-3 py-1">
                            Total dipilih: {{ number_format($count) }} data
                        </span>
                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-600">
                            Tanggal rekomendasi: {{ $formattedDate }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('rekomendasi.export') }}"
                    class="flex w-full flex-col gap-3 rounded-2xl border border-slate-200/70 bg-slate-50 px-4 py-3 shadow-sm sm:w-auto sm:flex-row sm:items-center sm:rounded-2xl sm:bg-white">
                    @csrf
                    @foreach ($ids as $id)
                        <input type="hidden" name="ids[]" value="{{ $id }}">
                    @endforeach
                    <label class="flex flex-col text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Tanggal Rekomendasi
                        <input type="date" name="tanggal_rekom" value="{{ $selectedDate }}"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100"
                            required>
                    </label>
                    <button
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:ring-offset-1 sm:self-end">
                        <img src="{{ asset('asset/acrobat-reader-svgrepo-com.png') }}" alt="Export PDF"
                            class="h-5 w-5">
                        <span>Export PDF</span>
                    </button>
                </form>
            </div>
        </div>

        @include('rekomendasi._table_preview', ['pages' => $pages])
    </div>
@endsection
