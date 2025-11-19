<div class="space-y-6">
    <div>
        <label for="nama" class="block text-sm font-medium text-zinc-700">
            Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <input
            type="text"
            id="nama"
            name="nama"
            value="{{ old('nama', optional($author)->nama) }}"
            class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="Contoh: I Gusti Ngurah Adi"
            maxlength="150"
            required
        >
        @error('nama')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="nip" class="block text-sm font-medium text-zinc-700">
                NIP <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="nip"
                name="nip"
                value="{{ old('nip', optional($author)->nip) }}"
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Contoh: 199001012023021001"
                maxlength="20"
                required
            >
            @error('nip')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jabatan" class="block text-sm font-medium text-zinc-700">
                Jabatan <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="jabatan"
                name="jabatan"
                value="{{ old('jabatan', optional($author)->jabatan) }}"
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-800 focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Contoh: Kepala Dinas"
                maxlength="100"
                required
            >
            @error('jabatan')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
