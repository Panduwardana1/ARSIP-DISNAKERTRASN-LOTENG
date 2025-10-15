@php
    /** @var \App\Models\PerusahaanAgensi|null $perusahaanAgensi */
    $perusahaanAgensi = $perusahaanAgensi ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="space-y-2">
        <label for="perusahaan_id" class="block text-sm font-semibold text-zinc-700">Perusahaan</label>
        <select id="perusahaan_id" name="perusahaan_id" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih perusahaan</option>
            @foreach ($perusahaans as $id => $namaPerusahaan)
                <option value="{{ $id }}"
                    @selected((string) old('perusahaan_id', optional($perusahaanAgensi)->perusahaan_id) === (string) $id)>
                    {{ $namaPerusahaan }}
                </option>
            @endforeach
        </select>
        @error('perusahaan_id')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="agensi_id" class="block text-sm font-semibold text-zinc-700">Agensi</label>
        <select id="agensi_id" name="agensi_id" required
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
            <option value="">Pilih agensi</option>
            @foreach ($agensis as $id => $namaAgensi)
                <option value="{{ $id }}"
                    @selected((string) old('agensi_id', optional($perusahaanAgensi)->agensi_id) === (string) $id)>
                    {{ $namaAgensi }}
                </option>
            @endforeach
        </select>
        @error('agensi_id')
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
                    @selected(old('status', optional($perusahaanAgensi)->status) === $status)>
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
        <input id="tanggal_mulai" name="tanggal_mulai" type="date"
            value="{{ old('tanggal_mulai', optional($perusahaanAgensi?->tanggal_mulai)->format('Y-m-d')) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
        @error('tanggal_mulai')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="tanggal_selesai" class="block text-sm font-semibold text-zinc-700">Tanggal Selesai</label>
        <input id="tanggal_selesai" name="tanggal_selesai" type="date"
            value="{{ old('tanggal_selesai', optional($perusahaanAgensi?->tanggal_selesai)->format('Y-m-d')) }}"
            class="block w-full rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm text-zinc-700 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
        @error('tanggal_selesai')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 pt-6">
    <a href="{{ route('disnakertrans.perusahaan-agensi.index') }}"
        class="inline-flex items-center gap-2 rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center gap-2 rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
        {{ $submitLabel ?? 'Simpan' }}
    </button>
</div>
