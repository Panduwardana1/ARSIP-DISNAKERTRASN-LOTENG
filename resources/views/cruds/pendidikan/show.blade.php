@extends('layouts.app')

@section('pageTitle', 'Sintaker')
@section('titlePageContent', 'Detail Pendidikan')

@section('headerActions')
    <div class="flex items-center gap-2">
        <a href="{{ route('disnakertrans.pendidikan.index') }}"
            class="inline-flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-100">
            <x-heroicon-o-arrow-left class="h-4 w-4" />
            Kembali
        </a>
        <a href="{{ route('disnakertrans.pendidikan.edit', $pendidikan) }}"
            class="inline-flex items-center gap-2 rounded-md border border-amber-200 px-3 py-2 text-sm font-semibold text-amber-600 hover:bg-amber-50">
            <x-heroicon-o-pencil-square class="h-4 w-4" />
            Ubah Data
        </a>
    </div>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto w-full px-4 py-6">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-zinc-200">
            <div class="border-b border-zinc-200 pb-4">
                <h2 class="text-xl font-semibold text-zinc-800">{{ $pendidikan->nama }}</h2>
                <p class="mt-1 text-sm text-zinc-500">
                    <span class="font-medium">Kode:</span> {{ $pendidikan->kode }}
                </p>
            </div>

            <dl class="mt-6 space-y-4">
                <div>
                    <dt class="text-sm font-semibold text-zinc-600">Level</dt>
                    <dd class="mt-1 text-sm text-zinc-800">{{ $pendidikan->level }}</dd>
                </div>
            </dl>

            <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Dibuat</p>
                    <p class="mt-1 text-sm text-zinc-800">
                        {{ optional($pendidikan->created_at)?->format('d-m-Y H:i') ?? '-' }}
                    </p>
                </div>
                <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                    <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Terakhir Diperbarui</p>
                    <p class="mt-1 text-sm text-zinc-800">
                        {{ optional($pendidikan->updated_at)?->format('d-m-Y H:i') ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
