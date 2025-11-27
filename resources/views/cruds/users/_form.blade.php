@php
    /** @var \App\Models\User|null $user */
    /** @var \Illuminate\Support\Collection|string[] $roles */
    $user = $user ?? null;
    $selectedRole = old('role', $user?->roles?->first()?->name);
    $selectedStatus = old('is_active', $user->is_active ?? 'active');
@endphp

<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-zinc-700">
            Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $user?->name) }}" maxlength="100" required
            class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
            placeholder="Masukkan nama lengkap">
        @error('name')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="email" class="block text-sm font-medium text-zinc-700">
                Email <span class="text-rose-500">*</span>
            </label>
            <input type="email" name="email" id="email" value="{{ old('email', $user?->email) }}" maxlength="255"
                required
                class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                placeholder="nama@disnaker.go.id">
            @error('email')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nip" class="block text-sm font-medium text-zinc-700">
                Nomor Induk Pegawai (NIP) <span class="text-rose-500">*</span>
            </label>
            <input type="text" inputmode="numeric" name="nip" id="nip"
                value="{{ old('nip', $user?->nip) }}" minlength="18" maxlength="18" required
                class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                placeholder="18 digit NIP">
            @error('nip')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="role" class="block text-sm font-medium text-zinc-700">
                Role Akses <span class="text-rose-500">*</span>
            </label>
            <select name="role" id="role" required
                class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none">
                <option value="">Pilih role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected($selectedRole === $role)>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="is_active" class="block text-sm font-medium text-zinc-700">
                Status Akun <span class="text-rose-500">*</span>
            </label>
            <select name="is_active" id="is_active" required
                class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none">
                <option value="active" @selected($selectedStatus === 'active')>Aktif</option>
                <option value="nonactive" @selected($selectedStatus === 'nonactive')>Nonaktif</option>
            </select>
            @error('is_active')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2 rounded-lg border border-indigo-100 bg-indigo-50 px-4 py-3 text-xs text-indigo-800">
        @if ($user)
            Kosongkan kolom password bila tidak ingin mengubahnya. Password minimal 6 karakter.
        @else
            Password wajib diisi saat membuat pengguna baru. Minimal 6 karakter.
        @endif
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="password" class="block text-sm font-medium text-zinc-700">
                Password {{ $user ? '(opsional)' : '' }}
            </label>
            <input type="password" name="password" id="password" minlength="6"
                @unless ($user) required @endunless
                class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                placeholder="{{ $user ? 'Biarkan kosong jika tidak diubah' : 'Minimal 6 karakter' }}">
            @error('password')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">
                Konfirmasi Password {{ $user ? '(opsional)' : '' }}
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" minlength="6"
                @unless ($user) required @endunless
                class="w-full border-b border-zinc-300 px-4 py-2.5 text-sm focus:border-green-500 bg-zinc-50 focus:outline-none"
                placeholder="{{ $user ? 'Ulangi jika mengganti password' : 'Ulangi password' }}">
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('sirekap.users.index') }}"
            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
            Batal
        </a>
        <button type="submit"
            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
            {{ $user ? 'Simpan' : 'Simpan' }}
        </button>
    </div>
</div>
