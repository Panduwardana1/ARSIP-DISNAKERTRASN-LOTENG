@extends('layouts.app')

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" defer></script>
@endpush

{{-- Header Section --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
    @section('titlePageContent', 'Dashboard Overview')

    @section('headerAction')
        <button type="button" @click="exportOpen = true"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 transition-all">
            <x-heroicon-o-arrow-up-tray class="h-4 w-4" />
            <span>Export Data</span>
        </button>
    @endsection
</div>

@section('content')
    <div class="space-y-6">

        {{-- Ringkasan Angka (Stats Cards) --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {{-- Card 1: Total CPMI --}}
            <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500">Total CPMI</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900">{{ $cast['totalTenagaKerja'] }}</p>
                    </div>
                    <div class="rounded-lg bg-blue-50 p-3 text-blue-600">
                        <x-heroicon-o-user-circle class="h-6 w-6" />
                    </div>
                </div>
            </div>

            {{-- Card 2: Total Agency --}}
            <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500">Total Agency</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900">{{ $cast['totalAgency'] }}</p>
                    </div>
                    <div class="rounded-lg bg-emerald-50 p-3 text-emerald-600">
                        <x-heroicon-o-building-library class="h-6 w-6" />
                    </div>
                </div>
            </div>

            {{-- Card 3: Total P3MI --}}
            <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500">Total P3MI</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900">{{ $cast['totalPerusahaan'] }}</p>
                    </div>
                    <div class="rounded-lg bg-orange-50 p-3 text-orange-600">
                        <x-heroicon-o-building-office class="h-6 w-6" />
                    </div>
                </div>
            </div>

            {{-- Card 4: Total Rekomendasi --}}
            <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500">Total Rekomendasi</p>
                        <p class="mt-2 text-3xl font-bold text-zinc-900">{{ $cast['totalRekomendasi'] }}</p>
                    </div>
                    <div class="rounded-lg bg-purple-50 p-3 text-purple-600">
                        <x-heroicon-o-document-text class="h-6 w-6" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Visualisasi Area --}}
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Bar Chart Tenaga Kerja --}}
            <div class="rounded-xl border border-zinc-200 bg-white shadow-sm lg:col-span-2">
                {{-- Header Chart & Filter --}}
                <div class="border-b border-zinc-100 p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-zinc-900">Visualisasi Data</h2>
                            <p id="chart-range-label" class="text-sm text-zinc-500">Memuat data...</p>
                        </div>

                        {{-- Filter Range (Segmented Control Style) --}}
                        <div class="flex rounded-lg bg-zinc-100 p-1 text-xs font-medium text-zinc-600">
                            <button type="button"
                                class="range-btn rounded-md px-3 py-1.5 transition-all hover:text-zinc-900"
                                data-range="week">Minggu</button>
                            <button type="button"
                                class="range-btn rounded-md px-3 py-1.5 transition-all hover:text-zinc-900"
                                data-range="month">Bulan</button>
                            <button type="button"
                                class="range-btn rounded-md px-3 py-1.5 transition-all hover:text-zinc-900"
                                data-range="year">Tahun</button>
                        </div>
                    </div>

                    {{-- Filter Dropdowns --}}
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <select id="chart-filter-kecamatan" data-filter-kecamatan
                            class="block w-full rounded-lg border border-zinc-300 py-2 pl-3 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                            @endforeach
                        </select>

                        <select id="chart-filter-desa" data-filter-desa
                            class="block w-full border rounded-lg border-zinc-300 py-2 pl-3 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:cursor-not-allowed disabled:bg-zinc-100 disabled:text-zinc-400"
                            disabled>
                            <option value="">Semua Desa</option>
                            @foreach ($desas as $desa)
                                <option value="{{ $desa->id }}" data-kecamatan="{{ $desa->kecamatan_id }}">
                                    {{ $desa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Canvas Area --}}
                <div class="p-5">
                    <div class="relative h-[300px] w-full">
                        <canvas id="tenagaKerjaChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Pie Chart Gender --}}
            <div class="flex flex-col rounded-xl border border-zinc-200 bg-white shadow-sm lg:col-span-1">
                <div class="border-b border-zinc-100 p-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-900">Distribusi Gender</h2>
                        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                            CPMI
                        </span>
                    </div>
                    <p id="chart-gender-label" class="mt-1 text-sm text-zinc-500">Memuat data...</p>
                </div>

                <div class="flex flex-1 items-center justify-center p-5">
                    <div class="relative h-64 w-64">
                        <canvas id="genderPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Data Terbaru --}}
        <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-zinc-100 p-5">
                <h2 class="text-lg font-semibold text-zinc-900">Terakhir Ditambahkan</h2>
                <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                    Lihat semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm">
                    <thead class="bg-zinc-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500">
                                Nama</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500">
                                Gender</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500">
                                Desa/Kecamatan</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500">
                                Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 bg-white">
                        @forelse ($lastAdd as $row)
                            <tr class="group hover:bg-zinc-50 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-zinc-900">{{ $row->nama ?? '-' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ strtolower($row->jenis_kelamin ?? '') == 'l' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $row->getLabelGender() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-medium text-zinc-900">{{ optional($row->desa)->nama ?? '-' }}</span>
                                        <span
                                            class="text-xs text-zinc-500">{{ optional(optional($row->desa)->kecamatan)->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-zinc-500">
                                    {{ $row->created_at->diffForHumans() ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-zinc-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <x-heroicon-o-inbox class="h-8 w-8 text-zinc-300" />
                                        <span>Belum ada data terbaru.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Scripts (Logic Tidak Diubah) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('tenagaKerjaChart');
                const rangeButtons = document.querySelectorAll('.range-btn');
                const rangeLabel = document.getElementById('chart-range-label');
                const genderCanvas = document.getElementById('genderPieChart');
                const genderLabel = document.getElementById('chart-gender-label');
                const filterKecamatan = document.querySelector('[data-filter-kecamatan]');
                const filterDesa = document.querySelector('[data-filter-desa]');
                const desaPlaceholder = filterDesa ? filterDesa.querySelector('option[value=""]') : null;
                const desaOptions = filterDesa ? Array.from(filterDesa.options).filter(option => option.value !== '') :
                    [];

                if (!canvas) return;

                let tenagaChart = null;
                let currentRange = 'month';
                let genderChart = null;

                // Stylistic update: Add logic to handle the 'active' state class for the new segmented button design
                function updateRangeButtonStyles(activeRange) {
                    rangeButtons.forEach(btn => {
                        if (btn.dataset.range === activeRange) {
                            btn.classList.remove('hover:text-zinc-900');
                            btn.classList.add('bg-white', 'text-zinc-900', 'shadow-sm', 'ring-1',
                                'ring-black/5');
                        } else {
                            btn.classList.add('hover:text-zinc-900');
                            btn.classList.remove('bg-white', 'text-zinc-900', 'shadow-sm', 'ring-1',
                                'ring-black/5');
                        }
                    });
                }

                function setActiveRangeButton(range) {
                    // Call the style updater
                    updateRangeButtonStyles(range);
                }

                function refreshDesaOptions(kecamatanId) {
                    if (!filterDesa) {
                        return;
                    }

                    const hasKecamatan = Boolean(kecamatanId);
                    let hasMatch = false;

                    filterDesa.disabled = !hasKecamatan;

                    desaOptions.forEach(option => {
                        const match = hasKecamatan && String(option.dataset.kecamatan) === String(kecamatanId);

                        option.hidden = !match;
                        option.disabled = !match;

                        if (!match && option.selected) {
                            option.selected = false;
                        }

                        if (match) {
                            hasMatch = true;
                        }
                    });

                    if ((!hasMatch || !hasKecamatan) && desaPlaceholder) {
                        desaPlaceholder.selected = true;
                    }
                }

                async function loadChartData(range = 'month') {
                    try {
                        const params = new URLSearchParams({
                            range
                        });

                        if (filterKecamatan && filterKecamatan.value) {
                            params.append('kecamatan_id', filterKecamatan.value);
                        }

                        if (filterDesa && filterDesa.value) {
                            params.append('desa_id', filterDesa.value);
                        }

                        const url = `{{ route('sirekap.dashboard.chart') }}?${params.toString()}`;
                        const res = await fetch(url);
                        if (!res.ok) throw new Error('Gagal memuat data chart');

                        const payload = await res.json();

                        const data = {
                            labels: payload.labels,
                            datasets: payload.datasets,
                        };

                        if (rangeLabel && payload.meta) {
                            const baseLabel = payload.meta.range_label ?? '';
                            const filterLabel = payload.meta.filter_label ?? '';
                            const combinedLabel = [baseLabel, filterLabel].filter(Boolean).join(' - ');
                            rangeLabel.textContent = combinedLabel || 'Data chart';
                        }

                        if (tenagaChart) {
                            // update chart saja
                            tenagaChart.data.labels = data.labels;
                            tenagaChart.data.datasets = data.datasets;
                            tenagaChart.update();
                        } else {
                            // inisialisasi chart pertama kali
                            tenagaChart = new Chart(canvas, {
                                type: 'bar',
                                data: data,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                precision: 0
                                            },
                                            title: {
                                                display: true,
                                                text: 'Jumlah CPMI'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: payload.type === 'week' ?
                                                    'Hari' : (payload.type === 'month' ? '' : 'Tahun')
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const val = context.parsed.y ?? 0;
                                                    return `${val} orang`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }

                        currentRange = range;
                        setActiveRangeButton(range);
                    } catch (error) {
                        console.error(error);
                        if (rangeLabel) {
                            rangeLabel.textContent = 'Terjadi kesalahan saat memuat data.';
                        }
                    }
                }

                async function loadGenderChartData() {
                    if (!genderCanvas) {
                        return;
                    }

                    try {
                        const params = new URLSearchParams();

                        if (filterKecamatan && filterKecamatan.value) {
                            params.append('kecamatan_id', filterKecamatan.value);
                        }

                        if (filterDesa && filterDesa.value) {
                            params.append('desa_id', filterDesa.value);
                        }

                        const query = params.toString();
                        const url = query ?
                            `{{ route('sirekap.dashboard.chart.gender') }}?${query}` :
                            `{{ route('sirekap.dashboard.chart.gender') }}`;

                        const res = await fetch(url);
                        if (!res.ok) throw new Error('Gagal memuat data gender');

                        const payload = await res.json();

                        const pieData = {
                            labels: payload.labels,
                            datasets: payload.datasets,
                        };

                        if (genderChart) {
                            genderChart.data.labels = pieData.labels;
                            genderChart.data.datasets = pieData.datasets;
                            genderChart.update();
                        } else {
                            genderChart = new Chart(genderCanvas, {
                                type: 'doughnut',
                                data: pieData,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false, // Changed to false to fit container better
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label || '';
                                                    const value = context.parsed ?? 0;
                                                    return `${label}: ${value} orang`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }

                        if (genderLabel) {
                            const filterText = payload.meta && payload.meta.filter_label ?
                                payload.meta.filter_label :
                                'Semua Wilayah';
                            genderLabel.textContent = filterText;
                        }
                    } catch (error) {
                        console.error(error);
                        if (genderLabel) {
                            genderLabel.textContent = 'Terjadi kesalahan saat memuat data.';
                        }
                    }
                }

                rangeButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const range = this.dataset.range;
                        if (range && range !== currentRange) {
                            loadChartData(range);
                            loadGenderChartData();
                        }
                    });
                });

                refreshDesaOptions(filterKecamatan ? filterKecamatan.value : null);

                if (filterKecamatan) {
                    filterKecamatan.addEventListener('change', () => {
                        refreshDesaOptions(filterKecamatan.value);
                        loadChartData(currentRange);
                        loadGenderChartData();
                    });
                }

                if (filterDesa) {
                    filterDesa.addEventListener('change', () => {
                        loadChartData(currentRange);
                        loadGenderChartData();
                    });
                }

                loadChartData(currentRange);
                loadGenderChartData();
            });
        </script>
    @endpush
@endsection
