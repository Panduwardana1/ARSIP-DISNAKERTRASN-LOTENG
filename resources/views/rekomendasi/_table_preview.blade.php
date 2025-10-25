<div class="space-y-6">
    @foreach ($pages as $pageIndex => $rows)
        @php
            $offset = $pages->take($pageIndex)->sum(fn($page) => $page->count());
        @endphp
        <div class="border rounded overflow-hidden">
            <div class="flex items-center justify-between bg-zinc-100 px-3 py-2 text-xs uppercase tracking-wide text-zinc-600">
                <span>Halaman {{ $pageIndex + 1 }}</span>
                <span>{{ $rows->count() }} baris</span>
            </div>
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50">
                    <tr>
                        <th class="p-2 text-left w-10">No</th>
                        <th class="p-2 text-left">Nama</th>
                        <th class="p-2 text-left">Gender</th>
                        <th class="p-2 text-left">Pendidikan</th>
                        <th class="p-2 text-left">Perusahaan</th>
                        <th class="p-2 text-left">Agensi</th>
                        <th class="p-2 text-left">Destinasi</th>
                        <th class="p-2 text-left">Lowongan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $rowIndex => $row)
                        <tr class="border-t">
                            <td class="p-2">{{ $offset + $rowIndex + 1 }}</td>
                            <td class="p-2">{{ $row['nama'] }}</td>
                            <td class="p-2">{{ $row['nik'] }}</td>
                            {{-- <td class="p-2">{{ $row['gender'] }}</td> --}}
                            <td class="p-2">{{ $row['pendidikan'] ?? '-' }}</td>
                            <td class="p-2">{{ $row['perusahaan'] ?? '-' }}</td>
                            <td class="p-2">{{ $row['agensi'] ?? '-' }}</td>
                            {{-- <td class="p-2">{{ $row['destinasi'] ?? '-' }}</td> --}}
                            <td class="p-2">{{ $row['pekerjaan'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
