@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Tenaga Kerja')
@section('Title', 'Tenaga Kerja')

@section('content')
    @php
        $activeStatus = $status;
    @endphp
    <section class="container mx-auto space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-medium text-indigo-600">Data CPMI</p>
                <h1 class="text-2xl font-semibold text-zinc-900">Daftar Tenaga Kerja</h1>
                <p class="text-sm text-zinc-600">
                    Pantau data CPMI, filter berdasarkan status, dan lakukan pembaruan apabila dibutuhkan.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <form action="{{ route('sirekap.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xls,.xlsx" class="block w-full border rounded p-2 mb-3">
                    @error('file')
                        <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Import Data
                    </button>
                </form>

                <a href="{{ route('sirekap.tenaga-kerja.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                    <x-heroicon-o-plus class="h-5 w-5" />
                    Tambah Tenaga Kerja
                </a>
            </div>
        </div>

        @php
            $exportMonths = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
            $exportKecamatans = \App\Models\Kecamatan::select('id', 'nama')->orderBy('nama')->get();
            $exportDesas = \App\Models\Desa::select('id', 'nama', 'kecamatan_id')->orderBy('nama')->get();
            $exportPerusahaans = \App\Models\Perusahaan::select('id', 'nama')->orderBy('nama')->get();
            $exportAgencies = \App\Models\Agency::select('id', 'nama')->orderBy('nama')->get();
            $exportNegaras = \App\Models\Negara::select('id', 'nama')->orderBy('nama')->get();
        @endphp

        <div class="max-w-2xl mx-auto bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold mb-4">Export Data Tenaga Kerja</h2>

            <form action="{{ route('sirekap.export.download') }}" method="POST" class="grid grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun', now()->year) }}"
                        class="w-full border rounded p-2">
                    @error('tahun')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Bulan</label>
                    <select name="bulan" class="w-full border rounded p-2">
                        <option value="">Semua</option>
                        @foreach ($exportMonths as $value => $label)
                            <option value="{{ $value }}" @selected((int) old('bulan') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Gender</label>
                    <select name="gender" class="w-full border rounded p-2">
                        <option value="">Semua</option>
                        <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                        <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Kecamatan</label>
                    <select name="kecamatan_id" class="w-full border rounded p-2" data-export-kecamatan>
                        <option value="">Semua</option>
                        @foreach ($exportKecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" @selected((int) old('kecamatan_id') === $kecamatan->id)>
                                {{ $kecamatan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Desa</label>
                    <select name="desa_id" class="w-full border rounded p-2" data-export-desa data-placeholder="Semua"
                        @disabled(!old('kecamatan_id'))>
                        <option value="">{{ __('Semua') }}</option>
                        @foreach ($exportDesas as $desa)
                            <option value="{{ $desa->id }}" data-kecamatan="{{ $desa->kecamatan_id }}"
                                @selected((int) old('desa_id') === $desa->id)>
                                {{ $desa->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('desa_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Perusahaan</label>
                    <select name="perusahaan_id" class="w-full border rounded p-2">
                        <option value="">Semua</option>
                        @foreach ($exportPerusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id }}" @selected((int) old('perusahaan_id') === $perusahaan->id)>
                                {{ $perusahaan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('perusahaan_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Agency</label>
                    <select name="agency_id" class="w-full border rounded p-2">
                        <option value="">Semua</option>
                        @foreach ($exportAgencies as $agency)
                            <option value="{{ $agency->id }}" @selected((int) old('agency_id') === $agency->id)>
                                {{ $agency->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('agency_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Negara Tujuan</label>
                    <select name="negara_id" class="w-full border rounded p-2">
                        <option value="">Semua</option>
                        @foreach ($exportNegaras as $negara)
                            <option value="{{ $negara->id }}" @selected((int) old('negara_id') === $negara->id)>
                                {{ $negara->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('negara_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Export ke Excel
                    </button>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-4 rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <form method="GET" action="{{ route('sirekap.tenaga-kerja.index') }}"
                class="flex flex-col gap-3 sm:flex-row sm:items-center">
                @foreach (request()->except(['q', 'status', 'page']) as $param => $value)
                    @if (is_scalar($value))
                        <input type="hidden" name="{{ $param }}" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="relative flex-1 sm:w-80">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-zinc-400">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                    </span>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau NIK..."
                        class="w-full rounded-md border border-zinc-300 bg-zinc-50 px-10 py-2 text-sm text-zinc-700 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                </div>
                <select name="status"
                    class="rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                    <option value="">Semua Status</option>
                    @foreach ($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected($activeStatus === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                    Terapkan
                </button>
                @if ($search !== '' || $activeStatus !== '')
                    <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                        class="text-xs font-medium text-zinc-500 underline underline-offset-4">
                        Reset filter
                    </a>
                @endif
            </form>

            <div class="flex flex-wrap gap-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-zinc-500">Status:</span>
                <a href="{{ route('sirekap.tenaga-kerja.index', array_merge(request()->except('page'), ['status' => ''])) }}"
                    class="rounded-full px-3 py-1 text-xs font-medium {{ $activeStatus === '' ? 'bg-indigo-600 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                    Semua
                </a>
                @foreach ($statusOptions as $value => $label)
                    <a href="{{ route('sirekap.tenaga-kerja.index', array_merge(request()->except('page'), ['status' => $value])) }}"
                        class="rounded-full px-3 py-1 text-xs font-medium {{ $activeStatus === $value ? 'bg-indigo-600 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @error('app')
            <div class="rounded-md border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $message }}
            </div>
        @enderror

        <div class="relative flex flex-col w-full h-full rounded-lg overflow-hidden max-w-full overflow-x-auto border">
            <table class="w-full text-left table-auto min-w-max">
                <thead class="bg-zinc-800 uppercase">
                    <tr>
                        <th class="p-4">
                            <p class="text-sm font-normal leading-none text-slate-300">
                                Identitas
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="text-sm font-normal text-center leading-none text-slate-300">
                                Gender
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="text-sm font-normal leading-none text-slate-300">
                                P3MI
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="text-sm font-normal leading-none text-slate-300">
                                Agency
                            </p>
                        <th class="p-4">
                            <p class="text-sm font-normal leading-none text-slate-300">
                                Pekerjaan
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="text-sm font-normal leading-none text-slate-300">
                                Terdata
                            </p>
                        </th>
                        <th class="p-4">
                            <p class="text-sm font-normal leading-none text-slate-300">
                                Aksi
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody class="border">
                    @forelse ($tenagaKerjas as $items)
                        <tr class="border-zinc-300 hover:bg-zinc-100 bg-white border-b">
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('sirekap.tenaga-kerja.show', $items) }}">
                                        <img src="{{ asset('asset/images/default-profile.jpg') }}" alt="Profile"
                                            class="h-12 w-auto rounded-full border-[1.5px] hover:border-amber-500">
                                    </a>
                                    <span class="grid items-center">
                                        <p class="text-sm font-semibold text-zinc-800">{{ $items->nama }}</p>
                                        <p class="text-xs font-medium text-zinc-600">{{ $items->nik }}</p>
                                    </span>
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="text-sm text-center text-zinc-800">
                                    {{ $items->gender }}
                                </p>
                            </td>
                            <td class="p-4">
                                <p class="text-sm font-medium text-zinc-800">
                                    {{ $items->perusahaan->nama ?? 'none' }}
                                </p>
                            </td>
                            <td class="p-4">
                                <p class="text-sm font-medium text-zinc-800">
                                    {{ $items->agency->nama ?? 'none' }}
                                </p>
                            </td>
                            <td class="p-4">
                                <p class="text-sm font-medium text-zinc-800">
                                    {{ $items->agency->lowongan ?? 'none' }}
                                </p>
                            </td>
                            <td class="p-4">
                                <p class="text-sm text-zinc-800">
                                    {{ $items->created_at->translatedFormat('d F Y') }}
                                </p>
                            </td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-x-6">
                                    <a href="{{ route('sirekap.perusahaan.edit', $items) }}"
                                        class="text-zinc-600 transition-colors duration-200 hover:text-amber-500">
                                        <span class="sr-only">Edit</span>
                                        <x-heroicon-o-pencil class="w-5 h-5" />
                                    </a>

                                    <x-modal-delete :action="route('sirekap.perusahaan.destroy', $items)" :title="'Hapus Data '" :message="'Datas ' . $items->nama . ' akan dihapus permanen.'"
                                        confirm-field="confirm_delete">
                                        <button type="button" class="text-zinc-600 hover:text-rose-600">
                                            <x-heroicon-o-trash class="h-5 w-5" />
                                        </button>
                                    </x-modal-delete>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <div>
                            <span>Belum ada data</span>
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ? pagination --}}
        <div class="pt-6">
            {{ $tenagaKerjas->onEachSide(2)->links() }}
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const kecamatanSelect = document.querySelector('[data-export-kecamatan]');
            const desaSelect = document.querySelector('[data-export-desa]');

            if (!kecamatanSelect || !desaSelect) {
                return;
            }

            const placeholder = desaSelect.querySelector('option[value=""]');
            const desaOptions = Array.from(desaSelect.options).filter((option) => option.value !== '');

            const refreshDesaOptions = (kecamatanId) => {
                const hasKecamatan = Boolean(kecamatanId);
                let hasMatch = false;

                desaSelect.disabled = !hasKecamatan;

                desaOptions.forEach((option) => {
                    const match =
                        hasKecamatan &&
                        String(option.dataset.kecamatan) === String(kecamatanId);

                    option.hidden = !match;
                    option.disabled = !match;

                    if (!match && option.selected) {
                        option.selected = false;
                    }

                    if (match) {
                        hasMatch = true;
                    }
                });

                if (!hasMatch && placeholder) {
                    placeholder.selected = true;
                }
            };

            refreshDesaOptions(kecamatanSelect.value);

            kecamatanSelect.addEventListener('change', () => {
                refreshDesaOptions(kecamatanSelect.value);
            });
        });
    </script>
@endpush
