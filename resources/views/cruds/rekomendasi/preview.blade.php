@extends('layouts.app')
@section('titlePageContent', 'Preview')

{{-- Content page --}}
@section('content')
    <div class="min-h-screen space-y-6 bg-zinc-100 px-4 py-6 font-inter md:px-6 md:py-8">
        <div class="rounded-xl border border-zinc-200 bg-white p-6">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 pb-4">
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-sm text-zinc-500">
                    <a href="{{ route('rekomendasi.index') }}"
                        class="inline-flex items-center text-zinc-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
                        Rekomendasi
                    </a>
                    <span class="text-zinc-400">/</span>
                    <span class="text-zinc-400" aria-current="page">Preview</span>
                </nav>
                <a href="{{ route('rekomendasi.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-600">
                    Kembali
                </a>
            </div>
            <div class="flex flex-wrap items-start justify-between gap-6 pt-4">
                <div class="space-y-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-zinc-900">Preview Rekomendasi Paspor</h1>
                        <p class="text-sm text-zinc-600">Tinjau kembali identitas CPMI berikut sebelum melanjutkan ke proses
                            ekspor PDF.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">
                        <span class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1">
                            Total dipilih: {{ number_format($count) }} data
                        </span>
                        <span
                            class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-600">
                            Tanggal rekomendasi: {{ $formattedDate }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('rekomendasi.export') }}"
                    class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-end">
                    @csrf
                    @foreach ($ids as $id)
                        <input type="hidden" name="ids[]" value="{{ $id }}">
                    @endforeach

                    {{-- search data --}}
                    <input type="date" name="tanggal_rekom" value="{{ $selectedDate }}"
                        class="mt-2 w-full rounded-md border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600"
                        required>
                    {{-- button export --}}
                    <button
                        class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 sm:self-end">
                        <img src="{{ asset('asset/acrobat-reader-svgrepo-com.png') }}" alt="Export PDF" class="h-5 w-5">
                        <span>Export</span>
                    </button>
                </form>
            </div>
        </div>

        @include('rekomendasi._table_preview', ['pages' => $pages])
    </div>
@endsection
