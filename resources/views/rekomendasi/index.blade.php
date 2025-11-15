@extends('layouts.app')

@section('content')
    <section class="container mx-auto px-4 py-6">
        <h1 class="text-lg font-semibold mb-4">Pilih Tenaga Kerja</h1>

        <form method="GET" class="mb-4 flex gap-2">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIK..."
                class="border rounded px-3 py-2 w-72">
            <button class="px-3 py-2 rounded bg-slate-800 text-white">Cari</button>
        </form>

        <form method="POST" action="{{ route('sirekap.rekomendasi.preview') }}">
            @csrf
            <div class="overflow-x-auto border rounded">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100">
                        <tr>
                            <th class="p-2">
                                <input type="checkbox" x-data
                                    @click="$el.closest('table').querySelectorAll('tbody input[type=checkbox]').forEach(cb=>cb.checked=$el.checked)">
                            </th>
                            <th class="p-2 text-left">Nama</th>
                            <th class="p-2 text-left">NIK</th>
                            <th class="p-2 text-left">Perusahaan</th>
                            <th class="p-2 text-left">Negara Tujuan</th>
                            <th class="p-2 text-left">Tgl Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenagaKerjas as $tk)
                            <tr class="border-t">
                                <td class="p-2"><input type="checkbox" name="selected_ids[]" value="{{ $tk->id }}">
                                </td>
                                <td class="p-2">{{ $tk->nama }}</td>
                                <td class="p-2">{{ $tk->nik }}</td>
                                <td class="p-2">{{ $tk->perusahaan->nama ?? '-' }}</td>
                                <td class="p-2">{{ $tk->negara->nama ?? '-' }}</td>
                                <td class="p-2">
                                    {{ \Illuminate\Support\Carbon::parse($tk->tanggal_lahir)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-zinc-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-zinc-600">Menampilkan {{ $tenagaKerjas->count() }} / {{ $tenagaKerjas->total() }}
                </div>
                <div class="flex items-center gap-3">
                    {{ $tenagaKerjas->links() }}
                    <button class="px-4 py-2 rounded bg-amber-600 text-white">Preview</button>
                </div>
            </div>
        </form>
    </section>
@endsection
