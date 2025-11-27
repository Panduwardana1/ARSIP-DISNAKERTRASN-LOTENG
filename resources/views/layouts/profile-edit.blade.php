@extends('layouts.app')

@section('pageTitle', 'Edit Profil Pengguna')
@section('titlePageContent', 'Edit Profil')

@section('content')
    @php
        $user = $user ?? auth()->user();
        $roles = $user?->roles?->pluck('name')->join(', ') ?: '-';
        $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
        $isActive = in_array($user?->is_active, ['active', 1, '1', true], true);
        $avatar = $user?->gambar ? asset('storage/' . ltrim($user->gambar, '/')) : null;
    @endphp

    <div aria-label="breadcrumb" class="col-span-full pb-4">
        <ol class="flex w-full flex-wrap items-center py-1.5">
            <li
                class="flex cursor-pointer items-center text-sm text-zinc-500 transition-colors duration-300 hover:text-zinc-800">
                <a href="{{ route('sirekap.user.profile.index') }}">Profile</a>
                <span class="pointer-events-none mx-2 text-zinc-800">
                    /
                </span>
            </li>
            <li
                class="flex cursor-pointer items-center text-sm text-zinc-500 transition-colors duration-300 hover:text-zinc-800">
                <a href="{{ route('sirekap.user.profile.edit', $user) }}">Edit profile</a>
            </li>
        </ol>
    </div>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:gap-8">
        <div class="col-span-1 lg:col-span-4 xl:col-span-3 border-[1.5px] h-[8rem] rounded-md p-6 bg-white">
            <div class="grid space-y-4">
                <div class="flex items-center gap-4 pb-4">
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
            </div>
        </div>
        <div class="col-span-1 lg:col-span-8 xl:col-span-9 border-[1.5px] rounded-md bg-white">
            <div class="text-zinc-900 px-8 py-6">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base/7 font-semibold text-zinc-700">Informasi Akun</h3>
                </div>
                <div class="mt-6 border-t border-zinc-300">
                    @if ($errors->any())
                        <div
                            class="rounded-t-2xl border-b border-rose-100 bg-rose-50 px-6 py-3 text-sm text-rose-800 space-y-1">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('sirekap.user.profile.update', $user->id ?? 0) }}" method="POST"
                        enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700" for="name">Nama
                                        Lengkap</label>
                                    <input id="name" name="name" type="text" required
                                        class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                                        value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-zinc-700" for="email">Alamat
                                        Email</label>
                                    <input id="email" name="email" type="email"
                                        class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                                        value="{{ old('email', $user->email) }}" placeholder="opsional">
                                </div>
                            </div>
                            <div class="grid space-y-2">
                                <label class="text-sm font-medium text-zinc-700" for="nip">Nomor Induk Pegawai
                                    (NIP)</label>
                                <input id="nip" name="nip" type="text" inputmode="numeric" minlength="18"
                                    maxlength="18" required
                                    class="w-full max-w-xs border-b bg-zinc-50 border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"
                                    value="{{ old('nip', $user->nip) }}">
                            </div>

                            <div class="grid space-y-2">
                                <label class="text-sm font-medium text-zinc-700" for="gambar">Foto Profil</label>
                                <div class="flex flex-wrap items-center gap-4">
                                    <input id="gambar" name="gambar" type="file" accept=".jpg,.jpeg,.png"
                                        class="w-full max-w-sm rounded-md py-2 file:rounded-full file:border-none file:py-1 file:px-2 text-sm focus:border-blue-500 focus:outline-none">
                                    @if ($avatar)
                                        <div class="flex items-center gap-3">
                                            <div class="h-12 w-12 overflow-hidden rounded-full border">
                                                <img src="{{ $avatar }}" alt="Foto profil saat ini"
                                                    class="h-full w-full object-cover">
                                            </div>
                                            <button type="submit" form="delete-photo-form"
                                                class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100 focus:outline-none">
                                                Hapus foto
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @error('gambar')
                                    <p class="text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @can('manage_users')
                            <div class="space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-zinc-700">
                                    Password</p>
                                <div class="rounded-md bg-orange-50 px-4 py-3 text-xs text-orange-800">
                                    Kosongkan kolom di bawah jika Anda tidak ingin mengubah password saat ini. Password
                                    baru minimal 6 karakter.
                                </div>
                                <div class="grid gap-4 md:grid-cols-2">
                                    {{-- password --}}
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-zinc-700" for="password">Password
                                            Baru</label>
                                        <input id="password" name="password" type="password" minlength="6"
                                            class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                                            placeholder="Password">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-zinc-700" for="password_confirmation">Konfirmasi
                                            Password</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            minlength="6"
                                            class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                                            placeholder="Password">
                                    </div>
                                </div>
                            </div>
                        @endcan

                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('sirekap.user.profile.index') }}"
                                class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                Batalkan
                            </a>
                            <button type="submit"
                                class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none">
                                Simpan
                            </button>
                        </div>
                    </form>

                    @if ($avatar)
                        <form id="delete-photo-form"
                            action="{{ route('sirekap.user.profile.photo.destroy', $user->id ?? 0) }}" method="POST"
                            class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
