@php
    /** @var \App\Models\Author|null $author */
    $author = $author ?? null;
@endphp

<div class="space-y-6">
    <div>
        <label for="nama" class="block text-sm font-medium text-zinc-700">
            Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', optional($author)->nama) }}"
            class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
            maxlength="150" required>
        @error('nama')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-1">
        <div>
            <label for="nip" class="block text-sm font-medium text-zinc-700">
                NIP <span class="text-rose-500">*</span>
            </label>
            <input type="text" id="nip" name="nip" value="{{ old('nip', optional($author)->nip) }}"
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
                maxlength="20" required>
            @error('nip')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jabatan" class="block text-sm font-medium text-zinc-700">
                Jabatan <span class="text-rose-500">*</span>
            </label>
            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', optional($author)->jabatan) }}"
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:outline-none focus:border-blue-300"
                required>
            @error('jabatan')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <label for="avatar" class="block text-sm font-medium text-zinc-700">
                Avatar (opsional)
            </label>
            <p class="text-xs text-zinc-500">PNG/JPG maks 2MB.</p>
        </div>
        <input type="file" id="avatar" name="avatar" accept="image/*"
            class="block w-full text-sm text-zinc-700 file:mr-3 file:rounded-md file:border file:bg-zinc-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-zinc-700 hover:file:bg-zinc-100">
        @error('avatar')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror

        @if (!empty($author?->avatar))
            <div class="flex items-center gap-3 rounded-md border border-zinc-200 bg-zinc-50 p-3">
                <img src="{{ asset('storage/' . $author->avatar) }}" alt="Avatar {{ $author->nama }}"
                    class="h-12 w-12 rounded-full object-cover border"
                    onerror="this.style.display='none'">
                <div>
                    <p class="text-sm font-medium text-zinc-800">{{ $author->nama }}</p>
                    <p class="text-xs text-zinc-500">Avatar saat ini</p>
                </div>
            </div>
        @endif
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('sirekap.author.index') }}"
            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
            Batal
        </a>
        <button type="submit"
            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
            {{ isset($author) ? 'Update' : 'Simpan' }}
        </button>
    </div>
</div>
