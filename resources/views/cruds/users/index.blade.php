@extends('layouts.app')

@section('pageTitle', 'Sirekap Pasmi | Pengguna')
@section('titlePageContent', 'Manajemen Pengguna')
@section('description', 'Kelola akun login, role akses, dan status aktif/nonaktif.')

@section('content')
    @section('headerAction')
        <div>
            <form method="GET" action="{{ route('sirekap.users.index') }}" class="relative w-full max-w-sm font-inter">
                <span class="absolute inset-y-0 left-3 flex items-center text-zinc-400">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </span>

                <input type="search" name="q" value="{{ $search }}"
                    placeholder="Search"
                    class="w-full pl-10 py-1.5 rounded-md bg-white border border-zinc-300 text-zinc-700 placeholder-zinc-400 transition-all duration-200 outline-none" />
            </form>
        </div>

        <div class="flex items-center">
            <a href="{{ route('sirekap.users.create') }}"
                class="flex items-center px-3 gap-2 py-1.5 bg-green-600 text-white rounded-md border hover:bg-green-700">
                <x-heroicon-o-plus class="w-5 h-5" />
                Tambah
            </a>
        </div>
    @endsection

    @if ($errors->has('app'))
        <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first('app') }}
        </div>
    @endif

    <div class="relative flex flex-col w-full h-full rounded-lg overflow-hidden">
        <table class="w-full text-left table-auto min-w-max">
            <thead class="bg-zinc-800 uppercase font-semibold">
                <tr>
                    <th class="p-4 w-12">
                        <p class="text-sm font-normal leading-none text-white">No</p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-white">Nama & NIP</p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-white">Email</p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-white">Role</p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-white">Status</p>
                    </th>
                    <th class="p-4">
                        <p class="text-sm font-normal leading-none text-white">Aksi</p>
                    </th>
                </tr>
            </thead>
            <tbody class="border">
                @forelse ($users as $user)
                    @php
                        $roleNames = $user->roles?->pluck('name')->join(', ') ?: '-';
                        $isActive = $user->is_active === 'active';
                    @endphp
                    <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                        <td class="p-4 align-top">
                            <p class="text-sm text-zinc-800">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </p>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-sm font-semibold text-white">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="grid">
                                    <p class="text-sm font-semibold text-zinc-800">{{ $user->name }}</p>
                                    <p class="text-xs font-medium text-zinc-600">{{ $user->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 align-top">
                            <p class="text-sm text-zinc-800">{{ $user->email }}</p>
                        </td>
                        <td class="p-4 align-top">
                            <p class="text-sm text-zinc-800 capitalize">{{ $roleNames }}</p>
                        </td>
                        <td class="p-4 align-top">
                            <span @class([
                                'rounded-full px-3 py-1 text-xs font-semibold',
                                'bg-emerald-100 text-emerald-700' => $isActive,
                                'bg-rose-100 text-rose-700' => !$isActive,
                            ])>
                                {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap align-top">
                            <div class="flex items-center gap-x-4">
                                <a href="{{ route('sirekap.users.edit', $user) }}"
                                    class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                    <span class="sr-only">Edit</span>
                                    <x-heroicon-o-pencil class="w-5 h-5" />
                                </a>

                                @if (auth()->id() !== $user->id)
                                    <x-modal-delete :action="route('sirekap.users.destroy', $user)" :title="'Hapus Pengguna'"
                                        :message="'Akun ' . $user->name . ' akan dihapus permanen.'"
                                        confirm-field="confirm_delete">
                                        <button type="button" class="text-zinc-600 hover:text-rose-600">
                                            <x-heroicon-o-trash class="h-5 w-5" />
                                        </button>
                                    </x-modal-delete>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-sm text-zinc-500">
                            Belum ada data pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pt-6">
        {{ $users->onEachSide(2)->links() }}
    </div>
@endsection
