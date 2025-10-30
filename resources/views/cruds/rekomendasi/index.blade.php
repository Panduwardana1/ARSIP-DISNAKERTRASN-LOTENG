@extends('layouts.app')
@section('pageTitle', 'Data CPMI - Cetak Rekomendasi Paspor')
@section('titlePageContent', 'Rekomendasi Paspor')

{{-- Content Page --}}
@section('content')
    <div class="min-h-screen space-y-6 bg-zinc-100 px-4 py-6 font-inter md:px-6 md:py-8">
        <div class="rounded-xl border border-zinc-200 bg-white p-6">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div class="space-y-3">
                    <div class="flex flex-wrap gap-3 text-xs font-medium uppercase tracking-wide text-zinc-500">
                        <span
                            class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1 text-zinc-600">
                            Total data tersedia: {{ number_format($tkis->total()) }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">
                            Batas per cetak: 100 baris
                        </span>
                    </div>
                    <p class="text-sm text-zinc-600">
                        Pilih data CPMI sesuai kebutuhan, maksimal 100 entri per kali cetak rekomendasi.
                    </p>
                </div>
                <form method="GET" class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                    <input name="q" value="{{ $q }}" placeholder="Cari nama atau NIK"
                        class="w-full rounded-md border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 placeholder:text-zinc-400 sm:w-64 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                    <button
                        class="inline-flex items-center justify-center rounded-md bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('rekomendasi.preview.store') }}" id="form-preview" class="space-y-4">
            @csrf

            <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white">
                <div
                    class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 bg-zinc-50 px-5 py-3">
                    <div class="text-xs font-semibold uppercase tracking-wide text-zinc-600">
                        Daftar Calon Pekerja Migran Terpilih
                    </div>
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                        Terpilih: <span id="selectedCount">0</span> / 100
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm text-zinc-700">
                        <thead class="bg-zinc-100 text-xs font-semibold tracking-wide text-zinc-500">
                            <tr>
                                <th scope="col" class="w-12 px-4 py-3">
                                    <input id="checkAll" type="checkbox"
                                        class="h-4 w-4 rounded border-zinc-300 text-sky-600 focus:ring-sky-500">
                                </th>
                                <th scope="col" class="px-3 py-3 text-center">No</th>
                                <th scope="col" class="px-3 py-3 text-left">Nama & ID PMI</th>
                                <th scope="col" class="px-3 py-3 text-center">Tempat Tgl.Lahir</th>
                                <th scope="col" class="px-3 py-3 text-center">L/P</th>
                                <th scope="col" class="px-3 py-3 text-center">Alamat PMI</th>
                                <th scope="col" class="px-3 py-3 text-center">Agency</th>
                                <th scope="col" class="px-3 py-3 text-center">Jenis Pekerjaan</th>
                                <th scope="col" class="px-3 py-3 text-center">Pendidikan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200">
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
                                        'l', 'laki-laki' => 'L',
                                        'p', 'perempuan' => 'P',
                                        default => '-',
                                    };
                                @endphp
                                <tr class="odd:bg-white even:bg-zinc-50">
                                    <td class="px-4 py-3 align-top">
                                        <input name="ids[]" value="{{ $tki->id }}" type="checkbox"
                                            class="rowCheck h-4 w-4 rounded border-zinc-300 text-sky-600 focus:ring-sky-500">
                                    </td>
                                    <td class="px-3 py-3 align-top text-zinc-500">
                                        {{ $startNumber + $loop->iteration }}
                                    </td>
                                    <td class="px-3 py-3 align-top">
                                        <div class="font-semibold text-zinc-900">{{ $tki->nama }}</div>
                                        <div class="text-[12px] text-zinc-500">{{ $tki->nik }}</div>
                                    </td>
                                    <td class="px-3 py-3 align-top text-zinc-600">
                                        <div class="mt-1 text-[12px] text-zinc-600">
                                            <span>{{ $tki->tempat_lahir ?? '-' }}</span>
                                            <span>
                                                {{ $tki->tanggal_lahir->locale('id')->translatedFormat('d F Y') ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 align-top text-zinc-600">
                                        {{ $genderLabel ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 align-top text-zinc-600 max-w-xs">
                                        <div class="mt-1 text-[12px] text-center text-zinc-400">
                                            {{ Str::limit($tki->alamat_lengkap, 200, '...') }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-[12px] align-top text-zinc-600">
                                        {{ $agensi->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 text-[12px] align-top text-zinc-600">
                                        {{ $lowongan->nama ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 text-[12px] align-top text-zinc-600">
                                        {{ ($tki->pendidikan)->level ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-6 text-center text-sm text-zinc-500">
                                        Tidak ada data yang dapat ditampilkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white px-5 py-4 md:flex-row md:items-center md:justify-between">
                <div class="text-sm text-zinc-600">
                    Terpilih: <span id="selectedCountFooter">0</span> data
                </div>
                <div class="flex flex-col items-stretch justify-end gap-3 sm:flex-row sm:items-center">
                    <div class="text-xs text-zinc-400">
                        Menampilkan {{ $tkis->firstItem() ?? 0 }}&ndash;{{ $tkis->lastItem() ?? 0 }} dari
                        {{ number_format($tkis->total()) }} data
                    </div>
                    <div class="flex items-center gap-3">
                        {{ $tkis->withQueryString()->links() }}
                        <button
                            class="rounded-md bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
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
