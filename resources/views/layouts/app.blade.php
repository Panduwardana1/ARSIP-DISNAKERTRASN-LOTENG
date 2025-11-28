<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle', 'Sirekap Pasmi - Disnakertrans')</title>
    <link rel="icon" href="{{ asset('asset/logo/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ sidebarOpen: false, exportOpen: false }" class="min-h-screen bg-zinc-100 font-inter">
    {{-- ? allert info --}}
    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    @if (session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif

    @if (session('warning'))
        <x-alert type="warning" message="{{ session('warning') }}" />
    @endif

    <div class="flex min-h-screen">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity
            class="fixed inset-0 z-20 bg-black/30 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        {{-- todo sidebar --}}
        <x-sidebar />

        {{-- MAIN CONTENT --}}
        <main class="ml-0 flex-1 bg-zinc-100 lg:ml-60">
            <div class="sticky top-0 z-30 border-b border-zinc-200 bg-white px-4 py-3 text-sm backdrop-blur sm:px-6">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between font-inter">
                    <div class="flex flex-1 items-start gap-3">
                        <button type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-700 shadow-sm transition hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 lg:hidden"
                            @click="sidebarOpen = true" aria-label="Buka menu navigasi">
                            <x-heroicon-o-bars-3 class="h-5 w-5" />
                        </button>
                        <div class="min-w-0">
                            <h2 class="truncate text-2xl font-semibold text-zinc-900">@yield('titlePageContent', '')</h2>
                            <p class="text-sm text-zinc-600">@yield('description', '')</p>
                        </div>
                    </div>
                    <div class="flex w-full flex-wrap items-center gap-2 md:w-auto md:justify-end">
                        @yield('headerAction')
                    </div>
                </div>
            </div>

            <div class="px-4 pb-6 pt-4 sm:px-6">
                <div class="mx-auto w-full max-w-7xl space-y-4">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @php
        $isDashboard = request()->routeIs('sirekap.dashboard.index');
        if ($isDashboard) {
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
        }
    @endphp

    @if ($isDashboard)
        {{-- Modal Export Data --}}
        <div x-cloak x-show="exportOpen" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-6">
            <div x-show="exportOpen" x-transition
                class="w-full max-w-4xl rounded-2xl bg-white shadow-2xl ring-1 ring-black/5" role="dialog"
                aria-modal="true">
                <div class="flex items-center justify-between border-b px-5 py-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Export</p>
                        <h3 class="text-lg font-semibold text-zinc-900">Tenaga Kerja</h3>
                        <p class="text-sm text-zinc-500">Gunakan filter untuk mempersempit hasil sebelum unduh.</p>
                    </div>
                    <button type="button" @click="exportOpen = false"
                        class="rounded-full bg-zinc-100 p-2 text-zinc-500 transition hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <x-heroicon-o-x-mark class="h-5 w-5" />
                    </button>
                </div>

                <form action="{{ route('sirekap.export.download') }}" method="POST" data-export-modal
                    class="grid gap-4 px-5 py-4 md:grid-cols-3">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Tahun</label>
                        <input type="number" name="tahun" value="{{ old('tahun', now()->year) }}"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @error('tahun')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Bulan</label>
                        <select name="bulan"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua</option>
                            @foreach ($exportMonths as $value => $label)
                                <option value="{{ $value }}" @selected((int) old('bulan') === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('bulan')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Gender</label>
                        <select name="gender"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua</option>
                            <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Kecamatan</label>
                        <select name="kecamatan_id"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            data-export-kecamatan>
                            <option value="">Semua</option>
                            @foreach ($exportKecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" @selected((int) old('kecamatan_id') === $kecamatan->id)>
                                    {{ $kecamatan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Desa</label>
                        <select name="desa_id"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500 disabled:cursor-not-allowed disabled:bg-zinc-100"
                            data-export-desa data-placeholder="Semua" @disabled(!old('kecamatan_id'))>
                            <option value="">{{ __('Semua') }}</option>
                            @foreach ($exportDesas as $desa)
                                <option value="{{ $desa->id }}" data-kecamatan="{{ $desa->kecamatan_id }}"
                                    @selected((int) old('desa_id') === $desa->id)>
                                    {{ $desa->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('desa_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Perusahaan</label>
                        <select name="perusahaan_id"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua</option>
                            @foreach ($exportPerusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}" @selected((int) old('perusahaan_id') === $perusahaan->id)>
                                    {{ $perusahaan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('perusahaan_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Agency</label>
                        <select name="agency_id"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua</option>
                            @foreach ($exportAgencies as $agency)
                                <option value="{{ $agency->id }}" @selected((int) old('agency_id') === $agency->id)>
                                    {{ $agency->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('agency_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-medium text-zinc-600">Negara Tujuan</label>
                        <select name="negara_id"
                            class="w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua</option>
                            @foreach ($exportNegaras as $negara)
                                <option value="{{ $negara->id }}" @selected((int) old('negara_id') === $negara->id)>
                                    {{ $negara->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('negara_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-3 flex items-center justify-between gap-3 border-t border-zinc-100 pt-3">
                        <p class="text-xs text-zinc-500">Kosongkan filter untuk mengunduh seluruh data.</p>
                        <div class="flex gap-2">
                            <button type="button" @click="exportOpen = false"
                                class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                                Batalkan
                            </button>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                                <x-heroicon-o-arrow-down-tray class="h-4 w-4" />
                                Export ke Excel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                state: JSON.parse(localStorage.getItem('sidebar-menus')) || {
                    master: false,
                    rekomendasi: false,
                    wilayah: false,
                },

                toggle(menu) {
                    this.state[menu] = !this.state[menu];
                    localStorage.setItem('sidebar-menus', JSON.stringify(this.state));
                }
            });
        });
    </script>
    @if ($isDashboard)
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const modal = document.querySelector('[data-export-modal]');
                    if (!modal) return;

                    const kecSelect = modal.querySelector('[data-export-kecamatan]');
                    const desaSelect = modal.querySelector('[data-export-desa]');
                    const desaPlaceholder = desaSelect ? desaSelect.querySelector('option[value=""]') : null;
                    const desaOptions = desaSelect ? Array.from(desaSelect.options).filter(opt => opt.value !== '') : [];

                    function refreshDesaOptions(kecamatanId) {
                        if (!desaSelect) return;

                        const hasKecamatan = Boolean(kecamatanId);
                        let hasMatch = false;
                        desaSelect.disabled = !hasKecamatan;

                        desaOptions.forEach(option => {
                            const match = hasKecamatan && String(option.dataset.kecamatan) === String(kecamatanId);
                            option.hidden = !match;
                            option.disabled = !match;
                            if (!match && option.selected) {
                                option.selected = false;
                            }
                            if (match) hasMatch = true;
                        });

                        if ((!hasMatch || !hasKecamatan) && desaPlaceholder) {
                            desaPlaceholder.selected = true;
                        }
                    }

                    if (kecSelect) {
                        refreshDesaOptions(kecSelect.value);
                        kecSelect.addEventListener('change', () => refreshDesaOptions(kecSelect.value));
                    }
                });
            </script>
        @endpush
    @endif
    @stack('scripts')
</body>

</html>
