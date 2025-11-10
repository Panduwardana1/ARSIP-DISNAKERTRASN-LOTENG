@php
    $isEdit = isset($author) && $author?->exists;
@endphp

<div class="space-y-4">
    <div>
        <label for="nama" class="text-sm font-semibold text-zinc-700">Nama Lengkap</label>
        <input
            type="text"
            id="nama"
            name="nama"
            value="{{ old('nama', optional($author)->nama) }}"
            class="mt-1 w-full rounded-lg border border-zinc-200 px-4 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900"
            placeholder="Contoh: I Gusti Ngurah Adi"
            required
        >
        @error('nama')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="nip" class="text-sm font-semibold text-zinc-700">NIP</label>
            <input
                type="text"
                id="nip"
                name="nip"
                value="{{ old('nip', optional($author)->nip) }}"
                class="mt-1 w-full rounded-lg border border-zinc-200 px-4 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900"
                placeholder="Contoh: 199001012023021001"
                maxlength="20"
                required
            >
            @error('nip')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jabatan" class="text-sm font-semibold text-zinc-700">Jabatan</label>
            <input
                type="text"
                id="jabatan"
                name="jabatan"
                value="{{ old('jabatan', optional($author)->jabatan) }}"
                class="mt-1 w-full rounded-lg border border-zinc-200 px-4 py-2 text-sm focus:border-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900"
                placeholder="Contoh: Kepala Dinas"
                required
            >
            @error('jabatan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-zinc-100 pt-4">
        <a
            href="{{ route('sirekap.author.index') }}"
            class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-semibold text-zinc-600 hover:bg-zinc-50"
        >
            Batal
        </a>
        <button
            type="submit"
            class="rounded-lg bg-slate-900 px-5 py-2 text-sm font-semibold text-white hover:bg-slate-800"
        >
            {{ $isEdit ? 'Update Author' : 'Simpan Author' }}
        </button>
    </div>
</div>
