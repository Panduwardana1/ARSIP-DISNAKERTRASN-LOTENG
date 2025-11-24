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

    {{-- * header  --}}
    <header
        class="fixed inset-x-0 top-0 z-40 flex h-14 items-center justify-between bg-zinc-800 px-4 shadow-sm backdrop-blur">
        <div class="flex items-center gap-3">
            <button type="button" class="rounded-md border border-amber-600/50 p-1 text-amber-50 lg:hidden"
                @click="sidebarOpen = true">
                <x-heroicon-o-bars-3 class="h-6 w-6" />
            </button>
            <img src="{{ asset('asset/logo/W-logo.png') }}" alt="Logo" class="h-9 w-auto">
        </div>
        <div class="flex items-center gap-3 text-xs font-medium text-amber-100/80 sm:text-sm">
            <button type="button" @click="exportOpen = true"
                class="flex items-center gap-2 bg-amber-600 rounded-md py-1.5 px-2 text-amber-50 transition hover:bg-amber-500 focus:outline-none">
                <x-heroicon-o-document-arrow-up class="h-5 w-5" />
                <span>Export</span>
            </button>
            <a href="{{ route('sirekap.user.profile.index') }}"
                class="bg-white hover:bg-zinc-100 text-zinc-700 border rounded-md py-1.5 px-2">
                <div class="flex items-center gap-2">
                    <x-heroicon-s-user-circle class="h-5 w-5" />
                    Profile
                </div>
            </a>
        </div>
    </header>

    <div class="flex pt-14">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-white lg:hidden"
            @click="sidebarOpen = false"></div>

        {{-- todo sidebar --}}
        <aside id="sidebar-multi-level-sidebar"
            class="fixed left-0 top-14 z-40 flex h-[calc(100vh-3.5rem)] w-60 flex-col border-r bg-zinc-100 px-4 py-4 backdrop-blur transition-transform duration-300 lg:translate-x-0"
            aria-label="Sidebar" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:-translate-x-0'">

            <div class="flex-1 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    @can('view_dashboard')
                        <li>
                            <x-nav-link :active="request()->routeIs('sirekap.dashboard.index')" href="{{ route('sirekap.dashboard.index') }}">
                                <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                                    <x-heroicon-o-home class="h-5 w-5 shrink-0" />
                                    <span class="text-sm font-semibold">Dashboard</span>
                                </div>
                            </x-nav-link>
                        </li>
                    @endcan

                    @can('manage_users')
                        <li>
                            <x-nav-link :active="request()->routeIs('sirekap.users.*')" href="{{ route('sirekap.users.index') }}">
                                <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                                    <x-heroicon-o-users class="h-5 w-5 shrink-0" />
                                    <span class="text-sm font-semibold">User</span>
                                </div>
                            </x-nav-link>
                        </li>
                    @endcan

                    <li x-data>
                        <button type="button"
                            class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand"
                            @click="$store.sidebar.toggle('master')">

                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-folder-open class="h-5 w-5 shrink-0" />
                                <span class="font-semibold">Master</span>
                            </span>

                            <span class="transition-transform duration-200"
                                x-bind:class="$store.sidebar.state.master ? 'rotate-180' : ''">
                                <x-heroicon-s-chevron-down class="w-5 h-5" />
                            </span>
                        </button>

                        <ul x-show="$store.sidebar.state.master" x-collapse x-cloak
                            class="space-y-2 border-l border-zinc-200 pl-4">
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.tenaga-kerja.index')" href="{{ route('sirekap.tenaga-kerja.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">CPMI</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.perusahaan.index')" href="{{ route('sirekap.perusahaan.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">P3MI</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.agency.index')" href="{{ route('sirekap.agency.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Agency</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.pendidikan.index')" href="{{ route('sirekap.pendidikan.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Pendidikan</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.negara.index')" href="{{ route('sirekap.negara.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Destinasi</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>

                    @canany(['manage_rekomendasi', 'manage_master'])
                        {{-- rekomendasi --}}
                        <li x-data>
                            <button @click="$store.sidebar.toggle('rekomendasi')"
                                class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand">

                                <span class="inline-flex items-center gap-2">
                                    <x-heroicon-o-document-text class="h-5 w-5" />
                                    <span class="font-semibold">Rekomendasi</span>
                                </span>

                                <span class="transition-transform duration-200"
                                    x-bind:class="$store.sidebar.state.rekomendasi ? 'rotate-180' : ''">
                                    <x-heroicon-s-chevron-down class="w-5 h-5" />
                                </span>
                            </button>

                            <ul x-show="$store.sidebar.state.rekomendasi" x-collapse x-cloak
                                class="space-y-2 border-l border-zinc-200 pl-4">
                                @can('manage_rekomendasi')
                                    <li class="ml-4">
                                        <x-nav-link :active="request()->routeIs('sirekap.author.index')" href="{{ route('sirekap.author.index') }}">
                                            <div class="flex items-center gap-2 transition-all duration-200">
                                                <span class="text-sm font-medium">Author</span>
                                            </div>
                                        </x-nav-link>
                                    </li>
                                @endcan
                                @canany(['manage_rekomendasi', 'manage_master'])
                                    <li class="ml-4">
                                        <x-nav-link :active="request()->routeIs('sirekap.rekomendasi.index')" href="{{ route('sirekap.rekomendasi.index') }}">
                                            <div class="flex items-center gap-2 transition-all duration-200">
                                                <span class="text-sm font-medium">Rekom</span>
                                            </div>
                                        </x-nav-link>
                                    </li>
                                @endcanany
                            </ul>
                        </li>
                    @endcanany

                    <li x-data>
                        <button @click="$store.sidebar.toggle('wilayah')"
                            class="flex items-center w-full justify-between rounded-md px-2 py-2 text-sm text-body transition hover:bg-neutral-tertiary hover:text-fg-brand">

                            <span class="inline-flex items-center gap-2">
                                <x-heroicon-o-map-pin class="h-5 w-5" />
                                <span class="font-semibold">Wilayah</span>
                            </span>

                            <span class="transition-transform duration-200"
                                x-bind:class="$store.sidebar.state.wilayah ? 'rotate-180' : ''">
                                <x-heroicon-s-chevron-down class="w-5 h-5" />
                            </span>
                        </button>

                        <ul x-show="$store.sidebar.state.wilayah" x-collapse x-cloak
                            class="space-y-2 border-l border-zinc-200 pl-4">
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.kecamatan.index')" href="{{ route('sirekap.kecamatan.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Kecamatan</span>
                                    </div>
                                </x-nav-link>
                            </li>
                            <li class="ml-4">
                                <x-nav-link :active="request()->routeIs('sirekap.desa.index')" href="{{ route('sirekap.desa.index') }}">
                                    <div class="flex items-center gap-2 transition-all duration-200">
                                        <span class="text-sm font-medium">Desa</span>
                                    </div>
                                </x-nav-link>
                            </li>
                        </ul>
                    </li>

                    {{-- ! logs --}}
                    @can('view_activity_log')
                        <li>
                            <x-nav-link :active="request()->routeIs('sirekap.logs.index')" href="{{ route('sirekap.logs.index') }}">
                                <div class="flex items-center rounded-md gap-2 transition-all duration-200">
                                    <x-heroicon-o-clipboard-document-list class="h-5 w-5 shrink-0" />
                                    <span class="text-sm font-semibold">Log Aktivitas</span>
                                </div>
                            </x-nav-link>
                        </li>
                    @endcan
                </ul>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main
            class="ml-0 h-[calc(100vh-3.5rem)] w-full flex-1 overflow-y-auto border-zinc-200 bg-white py-6 px-4 sm:px-6 lg:ml-60">
            {{-- todo Header action --}}
            <div class="flex items-center justify-between w-full pb-4 space-y-4 font-inter">
                <span>
                    <h2 class="text-3xl font-medium">@yield('titlePageContent', '')</h2>
                    <p class="text-sm">@yield('description', '')</p>
                </span>
                <div class="flex items-center justify-between gap-2">
                    @yield('headerAction')
                </div>
            </div>

            <div class="rounded-base">
                @yield('content')
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
