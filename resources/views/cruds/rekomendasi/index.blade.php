@extends('layouts.app')

@section('content')
    <div class="space-y-4 p-2 font-inter">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-semibold">Pencetakan Rekomendasi Paspor</h1>
                <p class="text-sm text-zinc-600">Pilih minimal 1 dan maksimal 100 data TKI untuk direkap.</p>
            </div>
            <form method="GET" class="flex gap-2">
                <input name="q" value="{{ $q }}" placeholder="Cari nama atau NIK"
                    class="border rounded px-3 py-2 w-64">
                <button class="px-3 py-2 rounded bg-blue-600 text-white">Cari</button>
            </form>
        </div>

        @if ($errors->any())
            <div class="rounded border border-red-200 bg-red-50 text-red-800 px-3 py-2 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('rekomendasi.preview.store') }}" id="form-preview" class="space-y-3">
            @csrf

            <div class="rounded border">
                <table class="min-w-full text-sm">
                    <thead class="bg-zinc-100">
                        <tr>
                            <th class="p-2 w-10">
                                <input id="checkAll" type="checkbox"
                                    onclick="document.querySelectorAll('.rowCheck').forEach(c=>c.checked=this.checked); updateCount();">
                            </th>
                            <th class="p-2 text-left">Nama</th>
                            <th class="p-2 text-left">NIK</th>
                            <th class="p-2 text-left">Alamat Lengkap</th>
                            <th class="p-2 text-left">Perusahaan</th>
                            <th class="p-2 text-left">Agensi</th>
                            <th class="p-2 text-left">Destinasi</th>
                            <th class="p-2 text-left">Lowongan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tkis as $tki)
                            @php
                                $lowongan = $tki->lowongan;
                                $perusahaan = optional($lowongan)->perusahaan;
                                $agensi = optional($lowongan)->agensi;
                                $destinasi = optional($lowongan)->destinasi;
                            @endphp
                            <tr class="border-t">
                                <td class="p-2">
                                    <input name="ids[]" value="{{ $tki->id }}" type="checkbox" class="rowCheck"
                                        onchange="updateCount()">
                                </td>
                                <td class="p-2">{{ $tki->nama }}</td>
                                <td class="p-2">{{ $tki->nik }}</td>
                                <td class="p-2" title="{{ $tki->alamat_lengkap }}">{{ Str::limit($tki->alamat_lengkap, 10, '...') }}</td>
                                <td class="p-2">{{ $perusahaan->nama ?? '-' }}</td>
                                <td class="p-2">{{ $agensi->nama ?? '-' }}</td>
                                <td class="p-2">{{ $destinasi->nama ?? '-' }}</td>
                                <td class="p-2">{{ $lowongan->nama ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-zinc-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm text-zinc-600">
                    Terpilih: <span id="selectedCount">0</span> data
                </div>
                <div class="flex items-center gap-3">
                    {{ $tkis->withQueryString()->links() }}
                    <button class="px-4 py-2 rounded bg-emerald-600 text-white" onclick="return confirmSelected()">
                        Preview
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function updateCount() {
            const n = document.querySelectorAll('.rowCheck:checked').length;
            document.getElementById('selectedCount').textContent = n;
        }

        function confirmSelected() {
            const n = document.querySelectorAll('.rowCheck:checked').length;
            if (n < 1 || n > 100) {
                alert('Pilih minimal 1 dan maksimal 100 data.');
                return false;
            }
            return true;
        }
    </script>
@endsection
