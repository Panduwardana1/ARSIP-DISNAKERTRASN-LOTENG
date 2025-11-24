@extends('layouts.app')

@section('pageTitle', 'Edit Profil Pengguna')

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
            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-1">
                    <div class="overflow-hidden rounded-md border border-zinc-200 bg-white">
                        <div class="px-6 pb-6 pt-12">
                            <div class="flex items-center gap-2">
                                <div class="h-20 w-20 overflow-hidden rounded-md border border-zinc-100 bg-blue-500 text-xl font-semibold text-white">
                                    @if ($avatar)
                                        <img src="{{ $avatar }}" alt="Foto profil" class="h-full w-full object-cover">
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
                                            class="rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                                            {{ ucfirst($roles) }}
                                        </span>
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

                <div class="lg:col-span-2">
                    <div class="rounded-md border border-zinc-200 bg-white">
                        @if ($errors->any())
                            <div
                                class="rounded-t-2xl border-b border-rose-100 bg-rose-50 px-6 py-3 text-sm text-rose-800 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="px-6 py-6">
                            <div class="flex items-start justify-between gap-3">
                                <h2 class="text-xl font-semibold text-zinc-900">Edit Informasi Akun</h2>
                            </div>

                            <form action="{{ route('sirekap.user.profile.update', $user->id ?? 0) }}" method="POST"
                                enctype="multipart/form-data" class="mt-6 space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Data Pribadi</p>
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-zinc-700" for="name">Nama Lengkap</label>
                                            <input id="name" name="name" type="text" required
                                                class="w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"
                                                value="{{ old('name', $user->name) }}">
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-zinc-700" for="email">Alamat Email</label>
                                            <input id="email" name="email" type="email"
                                                class="w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"
                                                value="{{ old('email', $user->email) }}" placeholder="opsional">
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-zinc-700" for="nip">Nomor Induk Pegawai (NIP)</label>
                                        <input id="nip" name="nip" type="text" inputmode="numeric" minlength="18" maxlength="18" required
                                            class="w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"
                                            value="{{ old('nip', $user->nip) }}">
                                        <p class="text-xs text-zinc-500">Pastikan NIP sesuai dengan data kepegawaian.</p>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-zinc-700" for="gambar">Foto Profil</label>
                                        <input id="gambar" name="gambar" type="file" accept=".jpg,.jpeg,.png"
                                            class="w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                                        <p class="text-xs text-zinc-500">Maks 2 MB. Biarkan kosong jika tidak diganti.</p>
                                        @error('gambar')
                                            <p class="text-xs text-rose-600">{{ $message }}</p>
                                        @enderror
                                        @if ($avatar)
                                            <div class="mt-2 flex items-center gap-3">
                                                <img src="{{ $avatar }}" alt="Foto profil saat ini"
                                                    class="h-12 w-12 rounded-lg object-cover border border-zinc-200">
                                                <span class="text-xs text-zinc-500">Foto saat ini</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @can('manage_users')
                                    <div class="space-y-4">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Keamanan & Password</p>
                                        <div
                                            class="rounded-md border border-blue-100 bg-blue-50 px-4 py-3 text-xs text-blue-800">
                                            Kosongkan kolom di bawah jika Anda tidak ingin mengubah password saat ini. Password baru minimal 6 karakter.
                                        </div>
                                        <div class="grid gap-4 md:grid-cols-2">
                                            <div class="space-y-1">
                                                <label class="text-sm font-medium text-zinc-700" for="password">Password Baru</label>
                                                <input id="password" name="password" type="password" minlength="6"
                                                    class="w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"
                                                    placeholder="Biarkan kosong jika tidak diubah">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-sm font-medium text-zinc-700" for="password_confirmation">Konfirmasi Password</label>
                                                <input id="password_confirmation" name="password_confirmation" type="password" minlength="6"
                                                    class="w-full rounded-lg border border-zinc-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"
                                                    placeholder="Ulangi password baru">
                                            </div>
                                        </div>
                                    </div>
                                @endcan

                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('sirekap.user.profile.index') }}"
                                        class="rounded-lg border border-zinc-200 px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                                        Batalkan
                                    </a>
                                    <button type="submit"
                                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500 focus:outline-none">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
