@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Dashboard Admin')
@section('titleContent', 'Dashboard Overview')

@section('content')
    <div class="flex items-center gap-4 flex-col font-inter p-2">
        <header
            class="grid font-inter p-4 h-32 items-center border rounded-md bg-gradient-to-br from-blue-600 to-sky-600 w-full">
            <div class="flex items-center justify-between">
                <div class="grid items-center">
                    <h1 class="font-semibold text-4xl text-zinc-50">Dashboard Overview</h1>
                    <span class="text-zinc-100 font-medium">Kelola data REKAP dan Pembuatan Rekom Paspor secara
                        terpadu</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-zinc-100">{{ date('D-M-Y') }}</span>
                    <x-heroicon-s-calendar class="h-9 w-9 text-white" />
                </div>
            </div>
        </header>
    </div>
@endsection
