@extends('layouts.app')

@section('pageTitle', 'Profil Pengguna')

@section('content')
    @php
        $user = $user ?? auth()->user();
        $roles = $user?->roles?->pluck('name')->join(', ') ?: '-';
        $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
        $isActive = in_array($user?->is_active, ['active', 1, '1', true], true);
        $avatar = $user?->gambar ? asset('storage/' . ltrim($user->gambar, '/')) : null;
    @endphp

    <section class="min-h-screen">
        <div class="mx-auto max-w-6xl px-4">
            <div>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <h1 class="text-2xl font-semibold text-zinc-900">Pengaturan Akun</h1>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-1">
                        <div class="overflow-hidden rounded-md border border-zinc-200 bg-white">
                            <div class="px-6 pb-6 pt-12">
                                <div class="flex items-center gap-2">
                                    <div class="h-20 w-20 overflow-hidden rounded-md">
                                        @if ($avatar)
                                            <img src="{{ $avatar }}" alt="Foto profil"
                                                class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="grid space-y-1">
                                        <div>
                                            <div class="text-lg font-semibold text-zinc-900">{{ $user->name ?? '-' }}</div>
                                            <div class="text-sm text-zinc-500">{{ $user->email ?? '-' }}</div>
                                        </div>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span
                                                class="inline-flex items-center rounded-sm bg-zinc-800 px-2 py-1 text-xs font-medium text-yellow-500 ring-1 ring-inset ring-yellow-400/20">{{ ucfirst($roles) }}</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-5 space-y-2 text-sm text-zinc-600">
                                    <p class="text-xs font-semibold text-zinc-500">NOMOR INDUK PEGAWAI</p>
                                    <div
                                        class="flex items-center gap-2 rounded-md border border-zinc-100 bg-zinc-50 px-3 py-3 font-mono">
                                        <span>{{ $user->nip ?? '-' }}</span>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-md border px-4 py-3 text-sm font-semibold text-white transition bg-red-500">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-4">
                        @if (session('success'))
                            <div
                                class="rounded-md border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="rounded-md border border-zinc-200 bg-white">
                            <div class="flex items-start justify-between gap-4 border-b border-zinc-100 px-6 py-5">
                                <div>
                                    <h2 class="text-xl font-semibold text-zinc-900">Informasi Pengguna</h2>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('sirekap.user.profile.edit', $user->id ?? 0) }}"
                                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-green-500 focus:outline-none">
                                        <x-heroicon-o-pencil class="h-4 w-4" />
                                        Edit Profil
                                    </a>
                                </div>
                            </div>
                            <div class="grid gap-4 px-6 py-6 md:grid-cols-2">
                                <div class="space-y-1">
                                    <p class="text-xs font-semibold text-zinc-500">Nama Lengkap</p>
                                    <p class="border-b border-zinc-300 px-3 py-2 text-sm text-zinc-800">
                                        {{ $user->name ?? '-' }}
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-semibold text-zinc-500">Email</p>
                                    <p class="border-b border-zinc-300 px-3 py-2 text-sm text-zinc-800">
                                        {{ $user->email ?? '-' }}
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-semibold text-zinc-500">NIP</p>
                                    <p class="border-b border-zinc-300 px-3 py-2 text-sm text-zinc-800">
                                        {{ $user->nip ?? '-' }}
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-semibold text-zinc-500">Role</p>
                                    <p class="border-b border-zinc-300 px-3 py-2 text-sm text-zinc-800">
                                        {{ $roles }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
