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
        <div class="flex items-center gap-3 w-full sm:w-auto" x-data>
            <button type="button" @click="$dispatch('user-modal:create')"
                class="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-all shadow-sm w-full sm:w-auto">
                <x-heroicon-o-plus class="w-5 h-5" />
                Tambah
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php
        $oldFormData = [
            'mode' => old('form_mode'),
            'id' => old('user_id'),
            'name' => old('name'),
            'email' => old('email'),
            'nip' => old('nip'),
            'role' => old('role'),
            'is_active' => old('is_active', 'active'),
        ];

        $modalUsers = $users
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'nip' => $user->nip,
                    'role' => $user->roles?->first()?->name,
                    'is_active' => $user->is_active,
                ];
            })
            ->values();
    @endphp

    <div x-data="userModal({ items: @js($modalUsers), oldForm: @js($oldFormData) })" x-init="init()"
        x-on:user-modal:create.window="openCreate()" class="space-y-4">
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
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&color=fff';
                                $roleColor = $primaryRole === 'admin' ? 'emerald' : ($primaryRole === 'staf' ? 'blue' : 'zinc');
                                $payload = [
                                    'id' => $user->id,
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'nip' => $user->nip,
                                    'role' => $user->roles?->first()?->name,
                                    'is_active' => $user->is_active,
                                ];
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
                                        <button type="button" @click="openEdit(@js($payload))"
                                            class="p-1.5 text-zinc-500 hover:text-amber-700 transition-colors"
                                            title="Edit">
                                            <x-heroicon-o-pencil class="w-5 h-5" />
                                        </button>

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

        {{-- Modal Create/Update --}}
        <div x-cloak x-show="open" x-transition.opacity.duration.200ms x-on:keydown.escape.window="close()"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-6">
            <div x-show="open" x-transition.scale.duration.200ms
                class="w-full max-w-4xl rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                <div class="flex items-start justify-between border-b px-5 py-4">
                    <div class="space-y-0.5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600"
                            x-text="mode === 'create' ? 'Tambah' : 'Perbarui'"></p>
                        <h2 class="text-lg font-semibold text-zinc-900"
                            x-text="mode === 'create' ? 'Tambah Pengguna' : 'Ubah Data Pengguna'"></h2>
                        <p class="text-sm text-zinc-500">Kelola akun login langsung di halaman ini.</p>
                    </div>
                    <button type="button" @click="close()"
                        class="rounded-full bg-zinc-100 p-2 text-zinc-500 transition hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        aria-label="Tutup">
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>

                <form :action="formAction" method="POST" class="space-y-5 p-5">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <input type="hidden" name="form_mode" :value="mode">
                    <input type="hidden" name="user_id" :value="form.id">

                    @if ($errors->has('app'))
                        <div
                            class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 flex items-center gap-2">
                            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                            {{ $errors->first('app') }}
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-zinc-700">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" x-model="form.name" maxlength="100" required
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-zinc-700">
                                    Email <span class="text-rose-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" x-model="form.email" maxlength="255" required
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none"
                                    placeholder="nama@disnaker.go.id">
                                @error('email')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="nip" class="block text-sm font-medium text-zinc-700">
                                    Nomor Induk Pegawai (NIP) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" inputmode="numeric" name="nip" id="nip" x-model="form.nip" minlength="18"
                                    maxlength="18" required
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none"
                                    placeholder="18 digit NIP">
                                @error('nip')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-sm font-medium text-zinc-700">
                                    Role Akses <span class="text-rose-500">*</span>
                                </label>
                                <select name="role" id="role" x-model="form.role" required
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none">
                                    <option value="">Pilih role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" :selected="form.role === '{{ $role }}'">
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="is_active" class="block text-sm font-medium text-zinc-700">
                                    Status Akun <span class="text-rose-500">*</span>
                                </label>
                                <select name="is_active" id="is_active" x-model="form.is_active" required
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none">
                                    <option value="active">Aktif</option>
                                    <option value="nonactive">Nonaktif</option>
                                </select>
                                @error('is_active')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-2 rounded-lg border border-indigo-100 bg-indigo-50 px-4 py-3 text-xs text-indigo-800">
                            <span x-show="mode === 'edit'">Kosongkan password bila tidak ingin mengubahnya. Minimal 6 karakter.</span>
                            <span x-show="mode === 'create'">Password wajib diisi saat membuat pengguna baru. Minimal 6 karakter.</span>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-medium text-zinc-700">
                                    Password <span x-show="mode === 'create'">(wajib)</span>
                                </label>
                                <input type="password" name="password" id="password" minlength="6"
                                    :required="mode === 'create'" x-model="form.password"
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none"
                                    placeholder="Minimal 6 karakter">
                                @error('password')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">
                                    Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" minlength="6"
                                    :required="mode === 'create'" x-model="form.password_confirmation"
                                    class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-emerald-500 bg-zinc-50 focus:outline-none"
                                    placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-zinc-100">
                        <button type="button" @click="close()"
                            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                            <span x-text="mode === 'create' ? 'Simpan' : 'Update'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function userModal(config) {
            return {
                open: false,
                mode: 'create',
                form: {
                    id: null,
                    name: '',
                    email: '',
                    nip: '',
                    role: '',
                    is_active: 'active',
                    password: '',
                    password_confirmation: '',
                },
                items: config?.items || [],
                oldForm: config?.oldForm || {},
                updateBase: '{{ url('/sirekap/users') }}',
                get formAction() {
                    return this.mode === 'create'
                        ? '{{ route('sirekap.users.store') }}'
                        : `${this.updateBase}/${this.form.id}`;
                },
                openCreate() {
                    this.mode = 'create';
                    this.resetForm();
                    this.open = true;
                },
                openEdit(item) {
                    this.mode = 'edit';
                    this.resetForm();
                    this.form = { ...this.form, ...item };
                    this.open = true;
                },
                close() {
                    this.open = false;
                    this.resetForm();
                },
                resetForm() {
                    this.form = {
                        id: null,
                        name: '',
                        email: '',
                        nip: '',
                        role: '',
                        is_active: 'active',
                        password: '',
                        password_confirmation: '',
                    };
                },
                init() {
                    if (this.oldForm?.mode === 'create') {
                        this.mode = 'create';
                        this.form = { ...this.form, ...this.oldForm };
                        this.open = true;
                    }

                    if (this.oldForm?.mode === 'edit' && this.oldForm?.id) {
                        const fallback = this.items.find((item) => String(item.id) === String(this.oldForm.id)) || {
                            id: this.oldForm.id
                        };
                        this.mode = 'edit';
                        this.form = { ...this.form, ...fallback, ...this.oldForm };
                        this.open = true;
                    }
                },
            };
        }
    </script>
@endpush
