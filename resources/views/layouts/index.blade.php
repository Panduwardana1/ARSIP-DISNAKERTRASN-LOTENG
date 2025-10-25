@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Dashboard Admin')

@section('content')
    @php
        $period = $filters['periode'] ?? 'monthly';
        $periodLabelMap = [
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
            'yearly' => 'Tahunan',
        ];
        $selectedPeriodLabel = $periodLabelMap[$period] ?? $periodLabelMap['monthly'];
        $currentFilters = [
            'kecamatan' => $filters['kecamatan'] ?? null,
            'desa' => $filters['desa'] ?? null,
        ];
        $activeFilters = collect($currentFilters)->filter();
    @endphp
    <div class="space-y-6 bg-white p-4 font-inter min-h-screen">
        <header class="relative overflow-hidden rounded-xl bg-slate-50 px-6 py-6">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <span class="block text-sm font-semibold uppercase tracking-wide text-sky-600">Dashboard Admin Overview</span>
                    <h1 class="text-3xl font-semibold leading-tight text-slate-900">Ringkasan Aktivitas Sistem</h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Pantau perkembangan data tenaga kerja, rekomendasi, dan rekapan secara langsung.
                    </p>
                </div>
                <div class="flex items-center gap-2 rounded-lg bg-sky-50 px-3 py-2 text-sky-700">
                    <x-heroicon-s-calendar-days class="h-6 w-6" />
                    <span class="text-sm font-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
            <div class="pointer-events-none absolute -right-16 bottom-0 hidden h-40 w-40 rounded-full border border-white/40 bg-white/10 blur-xl md:block"></div>
        </header>

        <section class="grid gap-4 md:grid-cols-3">
            @foreach ([
                'Total Tenaga Kerja' => $stats['tenaga_kerja'] ?? 0,
                'Total Perusahaan' => $stats['perusahaan'] ?? 0,
                'Total Agensi' => $stats['agensi'] ?? 0,
            ] as $label => $value)
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($value) }}</p>
                </div>
            @endforeach
        </section>

        <section class="rounded-2xl border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur">
            <form method="GET" class="space-y-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-slate-700">Filter Data</h2>
                        <p class="text-sm text-slate-500">Sesuaikan ringkasan agar tetap relevan dengan kebutuhan Anda.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200 focus:ring-offset-1">
                            <x-heroicon-s-funnel class="h-4 w-4" />
                            Terapkan
                        </button>
                        <a href="{{ route('sirekap.dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-white focus:outline-none focus:ring-2 focus:ring-slate-200 focus:ring-offset-1">
                            <x-heroicon-s-arrow-path class="h-4 w-4" />
                            Reset
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-slate-200/80 bg-white px-4 py-4 shadow-sm transition hover:border-sky-300 hover:shadow-md">
                        <label for="filter-kecamatan" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Kecamatan</label>
                        <input type="text" id="filter-kecamatan" name="kecamatan"
                            value="{{ $currentFilters['kecamatan'] }}"
                            placeholder="Contoh: Cicurug"
                            class="mt-3 w-full rounded-lg border border-transparent bg-slate-100 px-3 py-2 text-sm text-slate-700 transition focus:border-sky-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-sky-100">
                    </div>
                    <div class="rounded-xl border border-slate-200/80 bg-white px-4 py-4 shadow-sm transition hover:border-sky-300 hover:shadow-md">
                        <label for="filter-desa" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Desa</label>
                        <input type="text" id="filter-desa" name="desa"
                            value="{{ $currentFilters['desa'] }}"
                            placeholder="Contoh: Sukaraja"
                            class="mt-3 w-full rounded-lg border border-transparent bg-slate-100 px-3 py-2 text-sm text-slate-700 transition focus:border-sky-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-sky-100">
                    </div>
                    <div class="rounded-xl border border-slate-200/80 bg-white px-4 py-4 shadow-sm transition hover:border-sky-300 hover:shadow-md md:col-span-2 lg:col-span-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Periode Data</span>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($periodLabelMap as $value => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="periode" value="{{ $value }}" {{ $period === $value ? 'checked' : '' }}
                                        class="peer sr-only">
                                    <span class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600 transition hover:border-sky-300 hover:text-sky-600 peer-checked:border-transparent peer-checked:bg-sky-600 peer-checked:text-white peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-sky-200">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if ($activeFilters->isNotEmpty())
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Filter aktif</span>
                            @foreach ($activeFilters as $key => $value)
                                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-xs font-medium text-slate-600 shadow-sm">
                                    <x-heroicon-s-check class="h-3.5 w-3.5 text-sky-500" />
                                    {{ ucfirst($key) }}: {{ $value }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </form>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-slate-600">Tren Tenaga Kerja</h2>
                    <span class="text-xs font-medium text-slate-400">Periode {{ $selectedPeriodLabel }}</span>
                </div>
                <div class="mt-4 h-72">
                    <canvas id="seriesChart"></canvas>
                </div>
            </div>

            <div class="grid col-span-1 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-sm font-semibold text-slate-600">Komposisi Gender</h2>
                <div class="mt-4 h-72">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const genderDataset = @json($charts['gender']);
        const seriesDataset = @json($charts['tenaga_kerja_series']);

        const baseOptions = {
            responsive: true,
            maintainAspectRatio: false,
        };

        new Chart(document.getElementById('seriesChart'), {
            type: 'bar',
            data: {
                labels: seriesDataset.labels,
                datasets: [{
                    label: 'Total CPMI',
                    data: seriesDataset.data,
                    backgroundColor: '#0ea5e9',
                    borderRadius: 2,
                }],
            },
            options: {
                ...baseOptions,
                scales: {
                    x: {
                        ticks: {
                            color: '#475569',
                            maxRotation: 45,
                            minRotation: 0,
                            autoSkip: true,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                    },
                },
                plugins: {
                    legend: { display: false },
                },
            },
        });

        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: genderDataset.labels,
                datasets: [{
                    data: genderDataset.data,
                    backgroundColor: ['#0ea5e9', '#f97316'],
                }],
            },
            options: {
                ...baseOptions,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, boxHeight: 12, padding: 16 },
                    },
                },
            },
        });
    </script>
@endpush
