@php
    /** @var \App\Models\AgensiLowongan|null $agensiLowongan */
    $agensiLowongan = $agensiLowongan ?? null;

    $selectedLowongan = old('lowongan_pekerjaan_id', optional($agensiLowongan)->lowongan_pekerjaan_id);
    $selectedNegara = old('negara_id', optional($agensiLowongan)->negara_id);
    $selectedKemitraan = old('perusahaan_agensi_id', optional($agensiLowongan)->perusahaan_agensi_id);
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="space-y-2">
        <label for="lowongan_pekerjaan_id" class="block text-sm font-semibold text-zinc-700">Lowongan</label>
        <select id="lowongan_pekerjaan_id" name="lowongan_pekerjaan_id" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih lowongan</option>
            @foreach ($lowongan as $id => $nama)
                <option value="{{ $id }}" @selected((string) $selectedLowongan === (string) $id)>{{ $nama }}</option>
            @endforeach
        </select>
        @error('lowongan_pekerjaan_id')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="negara_id" class="block text-sm font-semibold text-zinc-700">Negara Tujuan</label>
        <select id="negara_id" name="negara_id" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih negara</option>
            @foreach ($negaras as $id => $namaNegara)
                <option value="{{ $id }}" @selected((string) $selectedNegara === (string) $id)>{{ $namaNegara }}</option>
            @endforeach
        </select>
        @error('negara_id')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="perusahaan_agensi_id" class="block text-sm font-semibold text-zinc-700">Kemitraan Perusahaan & Agensi</label>
        <select id="perusahaan_agensi_id" name="perusahaan_agensi_id" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih kemitraan</option>
            @foreach ($kemitraan as $item)
                @php
                    $label = collect([
                        optional($item->perusahaan)->nama_perusahaan,
                        optional($item->agensi)->nama_agensi,
                    ])
                        ->filter()
                        ->implode(' — ');
                    $label = $label ?: 'Kemitraan #' . $item->id;

                    if ($item->tanggal_mulai) {
                        $label .= ' (Mulai ' . $item->tanggal_mulai->format('d M Y') . ')';
                    }
                @endphp
                <option value="{{ $item->id }}" @selected((string) $selectedKemitraan === (string) $item->id)>{{ $label }}</option>
            @endforeach
        </select>
        @error('perusahaan_agensi_id')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="status" class="block text-sm font-semibold text-zinc-700">Status</label>
        <select id="status" name="status" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih status</option>
            @foreach ($statusOptions as $status)
                <option value="{{ $status }}"
                    @selected(old('status', optional($agensiLowongan)->status) === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="tanggal_mulai" class="block text-sm font-semibold text-zinc-700">Tanggal Mulai</label>
        <input id="tanggal_mulai" name="tanggal_mulai" type="date" required
            value="{{ old('tanggal_mulai', optional($agensiLowongan?->tanggal_mulai)->format('Y-m-d')) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
        @error('tanggal_mulai')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('disnakertrans.agensi-lowongan.index') }}"
        class="inline-flex items-center gap-2 rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
