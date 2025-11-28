@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Pengguna')
@section('titlePageContent', 'Manajemen Pengguna')
@section('description', 'Kelola akun login, role akses, dan status aktif/nonaktif.')

@section('headerAction')
    <div class="flex flex-col sm:flex-row gap-3 items-center justify-between w-full">
        {{-- Search Bar --}}
        <form method="GET" action="{{ route('sirekap.users.index') }}" class="relative w-full sm:max-w-xs font-inter group">
            <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400 group-focus-within:text-blue-600">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </span>
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau email..."
                class="w-full pl-10 py-2 rounded-lg border border-zinc-200 bg-white text-zinc-700 placeholder-zinc-400 focus:ring-2 focus:ring-blue-100 transition-all duration-200 outline-none text-sm" />
        </form>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('sirekap.users.create') }}"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-all shadow-sm w-full sm:w-auto">
                <x-heroicon-o-plus class="w-5 h-5" />
                Tambah
            </a>
        </div>
    </div>
@endsection

@section('content')

    @if ($errors->has('app'))
        <div
            class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 flex items-center gap-2">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            {{ $errors->first('app') }}
        </div>
    @endif

    {{-- Main Table Card --}}
    <div class="bg-white border border-zinc-200 rounded-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-zinc-600 border-b border-zinc-200">
                    <tr>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Nama Anggota
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="py-4 px-4 text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="py-4 px-4 text-end text-xs font-semibold text-zinc-100 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($users as $user)
                        @php
                            $roleNames = trim($user->roles?->pluck('name')->join(', ') ?? '');
                            $primaryRole = strtolower($user->roles?->pluck('name')->first() ?? '');
                            $hasRoles = $roleNames !== '';
                            $isActive = in_array($user->is_active, ['active', 1, '1', true], true);
                            $avatar = $user->gambar
                                ? asset('storage/' . ltrim($user->gambar, '/'))
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode($user->name) .
                                    '&background=random&color=fff';
                            $roleColor =
                                $primaryRole === 'admin' ? 'emerald' : ($primaryRole === 'staf' ? 'blue' : 'zinc');
                        @endphp
                        <tr class="group hover:bg-zinc-50/80 transition-colors duration-200">
                            {{-- Nama & Email --}}
                            <td class="p-4 align-top">
                                <div class="flex gap-3">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover border border-zinc-200"
                                            src="{{ $avatar }}" alt="">
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-semibold text-zinc-900 transition-colors">{{ $user->name }}</span>
                                        <span class="text-sm text-zinc-600">{{ $user->nip }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="p-4 align-top">
                                <span class="text-sm text-zinc-600">{{ $user->email ?? 'NIP tidak tersedia' }}</span>
                            </td>

                            <td class="p-4 align-top">
                                <span @class([
                                    'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium',
                                    "bg-{$roleColor}-600 text-white" => $hasRoles,
                                    'bg-blue-700 text-black' => !$hasRoles,
                                ])>
                                    {{ $hasRoles ? $roleNames : 'Belum ada role' }}
                                </span>
                            </td>

                            <td class="p-4 align-top">
                                <span @class([
                                    'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium border',
                                    'bg-green-700 text-white border' => $isActive,
                                    'bg-zinc-50 text-zinc-600 border-zinc-200' => !$isActive,
                                ])>
                                    {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 align-top text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('sirekap.users.edit', $user) }}"
                                        class="p-1.5 text-zinc-500 hover:text-amber-700 transition-colors" title="Edit">
                                        <x-heroicon-o-pencil class="w-5 h-5" />
                                    </a>

                                    @if (auth()->id() !== $user->id)
                                        <x-modal-delete :action="route('sirekap.users.destroy', $user)" :title="'Hapus Data'" :message="'Data akan dihapus permanen.'"
                                            confirm-field="confirm_delete">
                                            <button type="button"
                                                class="p-1.5 text-zinc-500 hover:text-rose-600 transition-colors"
                                                title="Hapus">
                                                <x-heroicon-o-trash class="h-5 w-5" />
                                            </button>
                                        </x-modal-delete>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center text-zinc-500">
                                    <x-heroicon-o-users class="w-12 h-12 text-zinc-300 mb-3" />
                                    <p class="text-base font-medium">Belum ada data pengguna</p>
                                    <p class="text-sm">Silakan tambahkan anggota baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        @if ($users->hasPages())
            <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3 sm:px-6">
                {{ $users->onEachSide(2)->links() }}
            </div>
        @endif
    </div>
@endsection
