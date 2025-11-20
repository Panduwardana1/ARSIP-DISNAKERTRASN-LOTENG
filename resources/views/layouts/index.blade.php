@extends('layouts.app')

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js" defer></script>
@endpush

<section>
    <span class="font-semibold">
        @section('titlePageContent', 'Dashboard Overview')
    </span>
</section>

@section('content')
    <section class="space-y-4">
        {{-- Ringkasan angka --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-lg border bg-white p-4">
                <div class="flex items-center gap-3 text-zinc-900">
                    <x-heroicon-o-user-circle class="h-8 w-8 rounded bg-emerald-500 p-1 text-white" />
                    <span class="text-sm font-medium text-zinc-500">Total CPMI</span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-zinc-900">{{ $cast['totalTenagaKerja'] }}</p>
            </div>
            <div class="rounded-lg border bg-white p-4">
                <div class="flex items-center gap-3 text-zinc-900">
                    <x-heroicon-o-building-office class="h-8 w-8 rounded bg-amber-500 p-1 text-white" />
                    <span class="text-sm font-medium text-zinc-500">Total P3MI</span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-zinc-900">{{ $cast['totalPerusahaan'] }}</p>
            </div>
            <div class="rounded-lg border bg-white p-4">
                <div class="flex items-center gap-3 text-zinc-900">
                    <x-heroicon-o-document-text class="h-8 w-8 rounded bg-blue-500 p-1 text-white" />
                    <span class="text-sm font-medium text-zinc-500">Total Rekomendasi</span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-zinc-900">{{ $cast['totalRekomendasi'] }}</p>
            </div>
        </div>

        {{-- Visualisasi --}}
        <div class="grid gap-4 lg:grid-cols-3">
            {{-- Bar Chart Tenaga Kerja --}}
            <div class="lg:col-span-2 rounded-xl border bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-zinc-900">
                                Visualisasi Data
                            </h2>
                            <p id="chart-range-label" class="text-xs text-zinc-500">
                                Memuat data...
                            </p>
                        </div>

                        {{-- Filter range --}}
                        <div
                            class="flex w-full flex-wrap items-center justify-start gap-2 rounded-md border border-zinc-200 bg-zinc-50 p-1 text-xs font-medium text-zinc-700 sm:w-auto sm:justify-end">
                            <button type="button"
                                class="range-btn rounded-md px-3 py-1.5 transition hover:bg-white hover:text-zinc-900"
                                data-range="week">
                                Minggu
                            </button>
                            <button type="button"
                                class="range-btn rounded-md px-3 py-1.5 transition hover:bg-white hover:text-zinc-900"
                                data-range="month">
                                Bulan
                            </button>
                            <button type="button"
                                class="range-btn rounded-md px-3 py-1.5 transition hover:bg-white hover:text-zinc-900"
                                data-range="year">
                                Tahun
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label for="chart-filter-kecamatan" class="block text-xs font-medium text-zinc-600">
                                Filter Kecamatan
                            </label>
                            <select id="chart-filter-kecamatan" data-filter-kecamatan
                                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Kecamatan</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="chart-filter-desa" class="block text-xs font-medium text-zinc-600">
                                Filter Desa
                            </label>
                            <select id="chart-filter-desa" data-filter-desa
                                class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-blue-500 focus:ring-blue-500 disabled:cursor-not-allowed disabled:bg-zinc-100"
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

                    <div class="w-full h-[18rem] sm:h-[22rem]">
                        <canvas id="tenagaKerjaChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-xl border bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-semibold text-zinc-900">
                                Distribusi Gender
                            </h2>
                            <span
                                class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-semibold uppercase text-zinc-500">
                                CPMI
                            </span>
                        </div>
                        <p id="chart-gender-label" class="text-xs text-zinc-500">
                            Memuat data...
                        </p>
                    </div>

                    <div class="relative mt-4 flex h-[18rem] items-center justify-center sm:h-[22rem]">
                        <canvas id="genderPieChart" class="h-40 w-40 sm:h-48 sm:w-48"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-xl overflow-hidden border bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900">5 Data Terbaru</h2>
                    <p class="text-xs text-zinc-500">Menampilkan entri terbaru dari Tenaga Kerja.</p>
                </div>
                <a href="{{ route('sirekap.tenaga-kerja.index') }}"
                    class="inline-flex text-sm font-medium text-blue-600 hover:text-blue-700">Lihat semua</a>
            </div>

            <div class="mt-4 overflow-x-auto rounded-md border border-zinc-100">
                <table class="min-w-full divide-y divide-zinc-200 text-xs text-zinc-700 sm:text-sm">
                    <thead class="bg-blue-600 text-xs font-semibold uppercase tracking-wide text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Gender</th>
                            <th class="px-4 py-3 text-left">Desa/Kecamatan</th>
                            <th class="px-4 py-3 text-left">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @forelse ($lastAdd as $row)
                            <tr>
                                <td class="px-4 py-3 font-medium text-zinc-900">
                                    <div class="grid items-center space-y-0">
                                        <span class="font-medium">{{ $row->nama ?? '-' }}</span>
                                        <strong>{{ $row->id ?? '-' }}</strong>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $row->getLabelGender() }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ optional($row->desa)->nama ?? '-' }} /
                                    {{ optional(optional($row->desa)->kecamatan)->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-zinc-500">
                                    {{ $row->created_at->diffForHumans() ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500">
                                    Belum ada data terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

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

                    function setActiveRangeButton(range) {
                        rangeButtons.forEach(btn => {
                            if (btn.dataset.range === range) {
                                btn.classList.add('bg-white', 'text-zinc-900', 'shadow-sm');
                            } else {
                                btn.classList.remove('bg-white', 'text-zinc-900', 'shadow-sm');
                            }
                        });
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
                                        maintainAspectRatio: true,
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
    </section>
@endsection
