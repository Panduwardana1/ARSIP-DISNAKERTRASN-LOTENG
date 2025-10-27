@extends('layouts.app')

@section('content')
    <div class="min-h-screen space-y-6 bg-slate-50 p-4 font-inter md:p-6">
        <div class="rounded-3xl border border-slate-200/60 bg-white px-6 py-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div class="space-y-2">
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900">Rekap & Cetak Rekomendasi Paspor</h1>
                        <p class="text-sm text-slate-600">Pilih minimal 1 dan maksimal 100 CPMI untuk disertakan pada
                            rekap dan PDF.</p>
                    </div>
                    <div class="flex flex-wrap gap-3 text-xs font-medium uppercase tracking-wide text-slate-500">
                        <span class="rounded-full border border-slate-200/70 bg-slate-100 px-3 py-1">
                            Total data tersedia: {{ number_format($tkis->total()) }}
                        </span>
                        <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">
                            Batas per cetak: 100 baris
                        </span>
                    </div>
                </div>
                <form method="GET" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                    <input name="q" value="{{ $q }}" placeholder="Cari nama atau NIK"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100 sm:w-64">
                    <button
                        class="inline-flex items-center justify-center rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-200 focus:ring-offset-1">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('rekomendasi.preview.store') }}" id="form-preview" class="space-y-4">
            @csrf

            <div class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200/80 bg-slate-50 px-5 py-3">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-600">
                        Daftar Calon Pekerja Migran Terpilih
                    </div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                        Terpilih: <span id="selectedCount">0</span> / 100
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                        <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th scope="col" class="w-12 px-4 py-3">
                                    <input id="checkAll" type="checkbox"
                                        class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                </th>
                                <th scope="col" class="w-14 px-3 py-3 text-left">No</th>
                                <th scope="col" class="px-3 py-3 text-left">Identitas</th>
                                <th scope="col" class="px-3 py-3 text-left">Gender</th>
                                <th scope="col" class="px-3 py-3 text-left">Pendidikan</th>
                                <th scope="col" class="px-3 py-3 text-left">Perusahaan</th>
                                <th scope="col" class="px-3 py-3 text-left">Agensi</th>
                                <th scope="col" class="px-3 py-3 text-left">Destinasi</th>
                                <th scope="col" class="px-3 py-3 text-left">Lowongan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @php
                                $startNumber = ($tkis->firstItem() ?? 1) - 1;
                            @endphp
                            @forelse ($tkis as $tki)
                                @php
                                    $lowongan = $tki->lowongan;
                                    $perusahaan = optional($lowongan)->perusahaan;
                                    $agensi = optional($lowongan)->agensi;
                                    $destinasi = optional($lowongan)->destinasi;
                                    $genderValue = Str::lower($tki->gender ?? '');
                                    $genderLabel = match ($genderValue) {
                                        'l', 'laki-laki' => 'Laki-laki',
                                        'p', 'perempuan' => 'Perempuan',
                                        default => '-',
                                    };
                                @endphp
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-4 py-3 align-top">
                                        <input name="ids[]" value="{{ $tki->id }}" type="checkbox"
                                            class="rowCheck h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-500">
                                        {{ $startNumber + $loop->iteration }}
                                    </td>
                                    <td class="px-3 py-3 align-top">
                                        <div class="font-semibold text-slate-900">{{ $tki->nama }}</div>
                                        <div class="text-xs text-slate-500">{{ $tki->nik }}</div>
                                        <div class="mt-1 text-xs text-slate-400">
                                            {{ Str::limit($tki->alamat_lengkap, 110, '...') }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-600">
                                        {{ $genderLabel }}
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-600">
                                        {{ optional($tki->pendidikan)->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-600">
                                        {{ $perusahaan->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-600">
                                        {{ $agensi->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-600">
                                        {{ $destinasi->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 align-top text-slate-600">
                                        {{ $lowongan->nama ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-6 text-center text-sm text-slate-500">
                                        Tidak ada data yang dapat ditampilkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-3 rounded-3xl border border-slate-200/70 bg-white px-5 py-4 shadow-sm md:flex-row md:items-center md:justify-between">
                <div class="text-sm text-slate-600">
                    Terpilih: <span id="selectedCountFooter">0</span> data
                </div>
                <div class="flex flex-col items-stretch justify-end gap-3 sm:flex-row sm:items-center">
                    <div class="text-xs text-slate-400">
                        Menampilkan {{ $tkis->firstItem() ?? 0 }}&ndash;{{ $tkis->lastItem() ?? 0 }} dari
                        {{ number_format($tkis->total()) }} data
                    </div>
                    <div class="flex items-center gap-3">
                        {{ $tkis->withQueryString()->links() }}
                        <button
                            class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:ring-offset-1"
                            onclick="return confirmSelected()">
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const checkAll = document.getElementById('checkAll');
        const rowChecks = () => Array.from(document.querySelectorAll('.rowCheck'));
        const selectedCountBadges = [
            document.getElementById('selectedCount'),
            document.getElementById('selectedCountFooter')
        ].filter(Boolean);

        const updateCount = () => {
            const totalSelected = rowChecks().filter((checkbox) => checkbox.checked).length;
            selectedCountBadges.forEach((badge) => (badge.textContent = totalSelected));
            if (checkAll) {
                const totalCheckbox = rowChecks().length;
                checkAll.checked = totalSelected > 0 && totalSelected === totalCheckbox;
                checkAll.indeterminate = totalSelected > 0 && totalSelected < totalCheckbox;
            }
        };

        if (checkAll) {
            checkAll.addEventListener('change', (event) => {
                rowChecks().forEach((checkbox) => {
                    checkbox.checked = event.target.checked;
                });
                updateCount();
            });
        }

        rowChecks().forEach((checkbox) => {
            checkbox.addEventListener('change', updateCount);
        });

        function confirmSelected() {
            const totalSelected = rowChecks().filter((checkbox) => checkbox.checked).length;
            if (totalSelected < 1 || totalSelected > 100) {
                alert('Pilih minimal 1 dan maksimal 100 data.');
                return false;
            }
            return true;
        }

        updateCount();
    </script>
@endsection
