@extends('layouts.app')

@section('pageTitle', 'Profil Pengguna')

@section('titlePageContent', 'Profile')

@php
    $user = $user ?? auth()->user();
    $roles = $user?->roles?->pluck('name')->join(', ') ?: '-';
    $isActive = in_array($user?->is_active, ['active', 1, '1', true], true);
    $avatar = $user?->gambar ? asset('storage/' . ltrim($user->gambar, '/')) : null;
@endphp

@section('content')
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:gap-8">
        <div class="col-span-1 lg:col-span-4 xl:col-span-3 border-[1.5px] h-[14rem] rounded-md p-6 bg-white">
            <div class="grid space-y-4">
                <div class="flex items-center gap-4 border-b pb-4">
                    @if ($avatar)
                        <div class="h-16 w-16 overflow-hidden rounded-full border">
                            <img src="{{ $avatar }}" alt="Foto profil" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-full border overflow-hidden">
                            <img src="{{ asset('asset/images/default-profile.jpg') }}" alt="Provile"
                                class="h-full w-full object-cover">
                        </div>
                    @endif

                    <div class="grid space-y-2">
                        <span class="font-semibold text-md">{{ $user->name }}</span>
                        <span class="font-normal text-sm">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="grid space-y-2 items-center">
                    <a href="{{ route('sirekap.user.profile.edit', $user) }}"
                        class="flex justify-center items-center text-center w-full p-1.5 px-2 bg-emerald-600 text-white hover:bg-emerald-500 active:ring-1 font-medium rounded-md gap-2">
                        Edit
                    </a>
                    <form action="{{ route('logout') }}" method="POST"
                        class="text-center bg-red-600 py-1.5 px-2 rounded-md hover:bg-red-500 active:ring-1">
                        @csrf
                        <button type="submit" class="text-center text-white transition" aria-label="Logout">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-span-1 lg:col-span-8 xl:col-span-9 border-[1.5px] rounded-md bg-white">
            <div class="text-zinc-900 px-8 py-6">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base/7 font-semibold text-zinc-700">Informasi Akun</h3>
                </div>
                <div class="mt-6 border-t border-zinc-300">
                    <dl class="divide-y divide-zinc-200">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-zinc-800">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm/6 text-zinc-800 sm:col-span-2 sm:mt-0">{{ $user->name }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-zinc-800">NIP</dt>
                            <dd class="mt-1 text-sm/6 text-zinc-800 sm:col-span-2 sm:mt-0">{{ $user->nip }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-zinc-800">Email</dt>
                            <dd class="mt-1 text-sm/6 text-zinc-800 sm:col-span-2 sm:mt-0">{{ $user->email }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-zinc-800">Role</dt>
                            <dd class="mt-1 text-sm/6 text-zinc-800 sm:col-span-2 sm:mt-0">{{ $roles }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-zinc-800">Aktif</dt>
                            <dd class="mt-1 text-sm/6 text-zinc-800 sm:col-span-2 sm:mt-0">
                                <div class="inline-flex items-center gap-2 text-xs font-medium text-slate-700">
                                    <span
                                        class="h-2 w-2 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
