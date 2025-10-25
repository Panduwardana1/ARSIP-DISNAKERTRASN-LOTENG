@extends('layouts.app')

@section('content')
    <div class="space-y-4 font-inter p-2">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold">Preview Rekap Rekomendasi Paspor</h1>
                <p class="text-sm text-zinc-600">Total dipilih: {{ $count }} | Tanggal: {{ $formattedDate }}</p>
            </div>
            <form method="POST" action="{{ route('rekomendasi.export') }}" class="flex items-center gap-2">
                @csrf
                @foreach ($ids as $id)
                    <input type="hidden" name="ids[]" value="{{ $id }}">
                @endforeach
                <input type="date" name="tanggal_rekom" value="{{ $selectedDate }}" class="border rounded px-2 py-1"
                    required>
                <button class="flex items-center gap-2 rounded bg-zinc-300 text-white px-4 py-2 hover:bg-zinc-400/50">
                    <img src="{{ asset('asset/acrobat-reader-svgrepo-com.png') }}" alt="Excel-icon" class="h-5 w-5">
                    <span class="font-medium text-zinc-700 ">Export</span>
                </button>
            </form>
        </div>

        @include('rekomendasi._table_preview', ['pages' => $pages])
    </div>
@endsection
