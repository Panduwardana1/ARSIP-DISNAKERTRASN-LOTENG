<div class="space-y-6">
    @foreach ($pages as $pageIndex => $rows)
        @php
            $offset = $pages->take($pageIndex)->sum(fn($page) => $page->count());
        @endphp
        <section class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-sm">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/80 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-600">
                <span>Halaman {{ $pageIndex + 1 }}</span>
                <span>Baris {{ $offset + 1 }} - {{ $offset + $rows->count() }}</span>
            </header>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                    <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="w-14 px-3 py-3 text-left">No</th>
                            <th class="px-3 py-3 text-left">Identitas</th>
                            <th class="px-3 py-3 text-left">Gender</th>
                            <th class="px-3 py-3 text-left">Pendidikan</th>
                            <th class="px-3 py-3 text-left">Perusahaan</th>
                            <th class="px-3 py-3 text-left">Agensi</th>
                            <th class="px-3 py-3 text-left">Destinasi</th>
                            <th class="px-3 py-3 text-left">Lowongan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($rows as $rowIndex => $row)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-3 py-3 align-top text-slate-500">{{ $offset + $rowIndex + 1 }}</td>
                                <td class="px-3 py-3 align-top">
                                    <div class="font-semibold text-slate-900">{{ $row['nama'] }}</div>
                                    <div class="text-xs text-slate-500">{{ $row['nik'] }}</div>
                                    <div class="mt-1 text-xs text-slate-400">
                                        {{ Str::limit($row['alamat'] ?? '-', 110, '...') }}
                                    </div>
                                </td>
                                <td class="px-3 py-3 align-top text-slate-600">{{ $row['gender'] ?? '-' }}</td>
                                <td class="px-3 py-3 align-top text-slate-600">{{ $row['pendidikan'] ?? '-' }}</td>
                                <td class="px-3 py-3 align-top text-slate-600">{{ $row['perusahaan'] ?? '-' }}</td>
                                <td class="px-3 py-3 align-top text-slate-600">{{ $row['agensi'] ?? '-' }}</td>
                                <td class="px-3 py-3 align-top text-slate-600">{{ $row['destinasi'] ?? '-' }}</td>
                                <td class="px-3 py-3 align-top text-slate-600">{{ $row['pekerjaan'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach
</div>
