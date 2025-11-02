<div class="space-y-6">
    @foreach ($pages as $pageIndex => $rows)
        @php
            $offset = $pages->take($pageIndex)->sum(fn($page) => $page->count());
        @endphp
        <section class="overflow-hidden rounded-xl border border-zinc-200 bg-white">
            <header
                class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 bg-zinc-50 px-5 py-3 text-[12px] font-semibold uppercase tracking-wide text-zinc-600">
                <span>Halaman {{ $pageIndex + 1 }}</span>
                <span>Baris {{ $offset + 1 }} - {{ $offset + $rows->count() }}</span>
            </header>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-zinc-200 border-collapse text-sm text-zinc-700">
                    <thead class="bg-zinc-100 text-[12px] font-semibold tracking-wide text-zinc-600">
                        <tr>
                            <th class="w-14 border border-zinc-200 px-3 py-3 text-center">No</th>
                            <th class="border border-zinc-200 px-3 py-3 text-left">Nama & ID PMI</th>
                            <th class="border border-zinc-200 px-3 py-3 text-left">Tempat & Tgl. Lahir</th>
                            <th class="border border-zinc-200 px-3 py-3 text-center">L/P</th>
                            <th class="border border-zinc-200 px-3 py-3 text-left">Alamat PMI</th>
                            <th class="border border-zinc-200 px-3 py-3 text-left">Agency</th>
                            <th class="border border-zinc-200 px-3 py-3 text-left">Jenis Pekerjaan</th>
                            <th class="border border-zinc-200 px-3 py-3 text-left">Pendidikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $rowIndex => $row)
                            <tr class="odd:bg-white even:bg-zinc-50 hover:bg-zinc-100 transition-colors">
                                <td class="border border-zinc-200 px-6 py-3 align-top text-center text-zinc-500">
                                    {{ $offset + $rowIndex + 1 }}
                                </td>
                                <td class="border border-zinc-200 px-3 py-3 align-top">
                                    <div class="font-semibold text-zinc-900">{{ $row['nama'] }}</div>
                                    <div class="text-[12px] text-zinc-500">{{ $row['nik'] }}</div>
                                </td>
                                <td class="border border-zinc-200 px-3 py-3 align-top text-zinc-600">
                                    <div class="text-sm text-zinc-700">{{ $row['tempat_lahir'] ?? '-' }}</div>
                                    <div class="text-[12px] text-zinc-500">{{ $row['tanggal_lahir'] ?? '-' }}</div>
                                </td>
                                <td class="border border-zinc-200 px-3 py-3 align-top text-center text-zinc-600">
                                    {{ $row['gender'] ?? '-' }}
                                </td>
                                <td class="border border-zinc-200 px-3 py-3 align-top text-zinc-600">
                                    <div class="text-[12px] leading-relaxed text-zinc-500">
                                        {{ Str::limit($row['alamat'] ?? '-', 150, '...') }}
                                    </div>
                                </td>
                                <td class="border border-zinc-200 text-xs px-3 py-3 align-top text-zinc-600">
                                    {{ $row['agensi'] ?? '-' }}
                                </td>
                                <td class="border border-zinc-200 text-xs px-3 py-3 align-top text-zinc-600">
                                    {{ $row['pekerjaan'] ?? '-' }}
                                </td>
                                @php
                                    $pendidikan = $row['pendidikan'] ?? null;
                                    $pendidikanLabel = is_array($pendidikan)
                                        ? ($pendidikan['level'] ?? $pendidikan['nama'] ?? '-')
                                        : ($pendidikan ?? '-');
                                @endphp
                                <td class="border border-zinc-200 text-xs px-3 py-3 align-top text-zinc-600">
                                    {{ $pendidikanLabel }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach
</div>
