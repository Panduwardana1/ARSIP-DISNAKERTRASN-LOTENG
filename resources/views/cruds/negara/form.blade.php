@php
    /** @var \App\Models\Negara|null $negara */
@endphp

<div class="space-y-6">
    <div class="grid gap-6">
        <div>
            <label for="nama" class="block text-sm font-medium text-zinc-700">
                Nama Negara <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $negara->nama ?? '') }}"
                maxlength="100" required
                class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 focus:outline-none focus:border-blue-300"
                placeholder="Contoh: INDONESIA">
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- todo button --}}
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('sirekap.negara.index') }}"
            class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
            Batal
        </a>
        <button type="submit"
            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
            {{ isset($negara) ? 'Update' : 'Simpan' }}
        </button>
    </div>
</div>
