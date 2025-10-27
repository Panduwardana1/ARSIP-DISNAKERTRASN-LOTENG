@extends('layouts.app')

@section('pageTitle', 'SIREKAP - PASMI | Dashboard Admin')
@section('titlePageContent', 'Dashboard Overview')

@section('content')
    @php
        $now = now();
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
        $filterSummary = $activeFilters->isNotEmpty()
            ? $activeFilters->map(fn($value, $key) => ucfirst($key) . ': ' . $value)->implode(' | ')
            : 'Semua Wilayah';
        $agencies = \App\Models\AgensiPenempatan::orderBy('nama')->get();
        $companies = \App\Models\PerusahaanIndonesia::orderBy('nama')->get();
        $destinations = \App\Models\Destinasi::orderBy('nama')->get();
    @endphp
    <div class="min-h-screen space-y-8 bg-zinc-50 p-4 font-inter">
        <section class="grid gap-4 md:grid-cols-3">
            @foreach ([
            'CPMI' => $stats['tenaga_kerja'] ?? 0,
            'P3MI' => $stats['perusahaan'] ?? 0,
            'Agensi' => $stats['agensi'] ?? 0,
        ] as $label => $value)
                <div class="rounded-lg border-[1.5px] border-zinc-200 bg-white">
                    <div class="py-2 px-4">
                        <p class="text-md font-semibold uppercase tracking-wide pb-2 text-slate-500">{{ $label }}
                        </p>
                        <p class="py-2 text-3xl font-bold tracking-tight text-center text-slate-900">
                            {{ number_format($value) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            <div class="col-span-2 rounded-lg border border-slate-200/70 bg-white p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-base font-semibold text-slate-700">Distribusi Tenaga Kerja</h2>
                        <p class="text-xs font-medium text-slate-400">Filter: {{ $filterSummary }}</p>
                        @if (!empty($charts['tenaga_kerja_series']['meta']['range_label']))
                            <span class="text-[11px] font-medium text-slate-400">
                                Rentang data: {{ $charts['tenaga_kerja_series']['meta']['range_label'] }}
                            </span>
                        @endif
                    </div>
                    <span class="text-xs font-medium text-slate-500">Periode {{ $selectedPeriodLabel }}</span>
                </div>
                <div class="mt-4 h-72">
                    <canvas id="seriesChart"></canvas>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200/70 bg-white p-6">
                <h2 class="text-base font-semibold text-slate-700">Komposisi Gender</h2>
                <div class="mt-4 h-72">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </section>

        @if ($latestEntries->isNotEmpty())
            <section class="rounded-lg border border-slate-200/70 bg-white/90 p-6">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h2 class="text-base font-semibold text-slate-700">Data Terbaru</h2>
                        <p class="text-sm text-slate-500">Entri CPMI yang paling baru ditambahkan.</p>
                    </div>
                    <span class="text-xs font-medium text-slate-400">Terakhir diperbarui {{ $now->diffForHumans() }}</span>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-600">
                        <thead class="text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="py-2 pr-6 font-semibold">Nama</th>
                                <th class="py-2 pr-6 font-semibold">Kecamatan</th>
                                <th class="py-2 pr-6 font-semibold">Desa</th>
                                <th class="py-2 font-semibold">Tanggal Ditambahkan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/70">
                            @foreach ($latestEntries as $entry)
                                <tr class="align-middle">
                                    <td class="py-3 pr-6 text-slate-700">{{ $entry->nama }}</td>
                                    <td class="py-3 pr-6">{{ $entry->kecamatan ?? '-' }}</td>
                                    <td class="py-3 pr-6">{{ $entry->desa ?? '-' }}</td>
                                    <td class="py-3 text-slate-500">
                                        {{ optional($entry->created_at)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const genderDataset = @json($charts['gender']);
        const seriesDataset = @json($charts['tenaga_kerja_series']);

        const numberFormatter = new Intl.NumberFormat('id-ID');
        const baseOptions = {
            responsive: true,
            maintainAspectRatio: false,
        };

        const seriesMeta = seriesDataset.meta ?? {};
        const unitLabel = seriesMeta.unit ? `per ${seriesMeta.unit}` : '';

        new Chart(document.getElementById('seriesChart'), {
            type: 'bar',
            data: {
                labels: seriesDataset.labels,
                datasets: [{
                    label: 'Jumlah CPMI',
                    data: seriesDataset.data,
                    backgroundColor: seriesDataset.colors ?? seriesDataset.labels.map(() => '#0ea5e9'),
                    borderRadius: 10,
                    borderSkipped: false,
                    maxBarThickness: 42,
                }],
            },
            options: {
                ...baseOptions,
                scales: {
                    x: {
                        ticks: {
                            color: '#475569',
                            maxRotation: 0,
                            autoSkip: seriesDataset.labels.length > 12,
                            font: {
                                size: 11,
                            },
                        },
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#475569',
                            callback: (value) => numberFormatter.format(value),
                        },
                        title: {
                            display: true,
                            text: unitLabel ? `Jumlah CPMI ${unitLabel}` : 'Jumlah CPMI',
                            color: '#0f172a',
                            font: {
                                size: 12,
                                weight: '600',
                            },
                        },
                        grid: {
                            color: '#e2e8f0',
                            drawTicks: false,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = numberFormatter.format(context.parsed.y ?? 0);
                                return `${context.dataset.label}: ${value} CPMI`;
                            },
                        },
                    },
                },
            },
        });

        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: genderDataset.labels,
                datasets: [{
                    data: genderDataset.data,
                    backgroundColor: ['#0ea5e9', '#f97316', '#38bdf8'],
                    hoverOffset: 6,
                }],
            },
            options: {
                ...baseOptions,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#475569',
                            boxWidth: 12,
                            boxHeight: 12,
                            padding: 16,
                            font: {
                                size: 12,
                            },
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const value = numberFormatter.format(context.parsed ?? 0);
                                const label = context.label ?? 'Total';
                                return `${label}: ${value} CPMI`;
                            },
                        },
                    },
                },
            },
        });
    </script>
@endpush
