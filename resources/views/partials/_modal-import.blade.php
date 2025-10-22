<div class="mx-auto max-w-lg fixed space-y-4 p-4 font-inter">
    <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
        <div class="border-b border-zinc-200 px-6 py-4">
            <h1 class="text-xl font-semibold text-zinc-800">Import Data TKI (Excel)</h1>
            <p class="mt-1 text-sm text-zinc-500">Unggah file Excel sesuai format berikut untuk menambah atau memperbarui
                data CPMI.</p>
        </div>
        <div class="space-y-5 px-6 py-5">
            @php
                $alerts = [
                    'success' => 'border-green-200 bg-green-50 text-green-800',
                    'info' => 'border-blue-200 bg-blue-50 text-blue-800',
                    'warning' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
                    'error' => 'border-red-200 bg-red-50 text-red-800',
                ];
            @endphp

            <div class="space-y-3">
                @foreach ($alerts as $type => $classes)
                    @if (session($type))
                        <div class="rounded-lg border px-4 py-3 text-sm leading-relaxed {{ $classes }}">
                            {{ session($type) }}
                        </div>
                    @endif
                @endforeach

                @if ($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <div class="font-semibold">Terjadi kesalahan pada file yang diunggah:</div>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <form action="{{ route('sirekap.pekerja.import') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-zinc-700">File Excel (.xlsx/.xls)</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required
                        class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    <p class="text-xs text-zinc-500">
                        Gunakan header: <code>nama, nik, gender, tempat_lahir, tanggal_lahir, email, desa, kecamatan,
                            alamat_lengkap, pendidikan, agensi, perusahaan, destinasi, lowongan</code>
                    </p>
                    <p class="text-xs text-zinc-400">
                        Kolom destinasi dapat diisi nama negara (mis. Jepang) atau kode 3 huruf (mis. JPN).
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-zinc-700">Mode simpan</label>
                        <select name="mode"
                            class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                            <option value="upsert" selected>Upsert by NIK (rekomendasi)</option>
                            <option value="insert">Insert only (skip jika NIK sudah ada)</option>
                        </select>
                    </div>

                    <label class="mt-7 flex items-center gap-2 text-sm text-zinc-600 sm:mt-9">
                        <input type="checkbox" name="dry_run" value="1"
                            class="h-4 w-4 rounded border border-zinc-300 text-emerald-600 focus:ring-emerald-500"
                            checked>
                        <span>Preview saja (cek dulu, tidak menyimpan ke database)</span>
                    </label>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button
                        class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                        Jalankan
                    </button>
                    {{-- <a href="{{ route('tki.template') }}"
                                class="inline-flex items-center rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Download Template
                            </a> --}}
                </div>
            </form>
        </div>
    </div>

    @php
        $failures = collect(session('failures'));
    @endphp
    @if ($failures->isNotEmpty())
        <div class="rounded-2xl border border-red-200 bg-red-50/40 shadow-sm">
            <div class="border-b border-red-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-red-800">Detail kesalahan import</h2>
                <p class="mt-1 text-sm text-red-600">Perbaiki baris berikut kemudian jalankan import ulang.</p>
            </div>
            <div class="overflow-x-auto px-2 pb-4 pt-2">
                <table class="min-w-full overflow-hidden rounded-xl border border-red-100 bg-white text-sm">
                    <thead class="bg-red-100 text-left text-xs font-semibold uppercase tracking-wide text-red-700">
                        <tr>
                            <th class="px-4 py-3">Baris</th>
                            <th class="px-4 py-3">Pesan</th>
                            <th class="px-4 py-3">Cuplikan nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-red-100">
                        @foreach ($failures as $failure)
                            @php
                                $values = $failure->values();
                                $previewKeys = [
                                    'nama',
                                    'nik',
                                    'gender',
                                    'pendidikan',
                                    'agensi',
                                    'perusahaan',
                                    'destinasi',
                                    'lowongan',
                                ];
                                $preview = [];
                                foreach ($previewKeys as $key) {
                                    if (isset($values[$key]) && $values[$key] !== null && $values[$key] !== '') {
                                        $preview[] = $key . ': ' . $values[$key];
                                    }
                                }
                            @endphp
                            <tr class="align-top text-red-700">
                                <td class="px-4 py-3 font-mono text-xs text-red-600">#{{ $failure->row() }}</td>
                                <td class="px-4 py-3">
                                    <ul class="list-disc space-y-1 pl-5 text-sm">
                                        @foreach ($failure->errors() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-3 text-xs text-red-600">
                                    {{ implode(' | ', $preview) ?: '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
