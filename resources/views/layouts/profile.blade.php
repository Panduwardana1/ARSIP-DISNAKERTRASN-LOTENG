@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Profil Saya')

@php
    $user = auth()->user();
    $role = $user && method_exists($user, 'getRoleNames') ? $user->getRoleNames()->first() : null;
    $joinedAt = optional($user?->created_at)->translatedFormat('d F Y');
@endphp

@section('content')
    <section class="p-6">
        <div class="mx-auto max-w-3xl rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-start">
                <img
                    src="{{ asset('asset/user/default.png') }}"
                    alt="Foto Profil"
                    class="h-28 w-28 rounded-full object-cover ring-4 ring-zinc-100"
                >

                <div class="text-center sm:text-left">
                    <h1 class="text-2xl font-semibold text-zinc-900">{{ $user?->name ?? 'Pengguna' }}</h1>
                    <p class="text-sm text-zinc-600">
                        <span class="font-medium text-emerald-600">{{ $role ?? 'Akun' }}</span>
                        <span class="mx-2 text-zinc-400">•</span>
                        Bergabung {{ $joinedAt ?? '—' }}
                    </p>

                    <div class="mt-4 flex flex-wrap justify-center gap-3 sm:justify-start">
                        <button
                            type="button"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500"
                        >
                            Edit Profil
                        </button>
                        <button
                            type="button"
                            class="rounded-md border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50"
                        >
                            Ubah Password
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">Nama Lengkap</p>
                    <p class="mt-1 text-base font-medium text-zinc-900">{{ $user?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">Email</p>
                    <p class="mt-1 text-base font-medium text-zinc-900">{{ $user?->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">Nomor Telepon</p>
                    <p class="mt-1 text-base font-medium text-zinc-900">{{ $user?->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-zinc-500">Alamat</p>
                    <p class="mt-1 text-base font-medium text-zinc-900">{{ $user?->alamat ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-8 rounded-lg border border-dashed border-zinc-200 p-4 text-sm text-zinc-600">
                <p>
                    Data profil ditarik langsung dari akun Anda. Hubungi administrator jika ada informasi yang ingin
                    diperbarui atau perlu penyesuaian tambahan.
                </p>
            </div>
        </div>
    </section>
@endsection
