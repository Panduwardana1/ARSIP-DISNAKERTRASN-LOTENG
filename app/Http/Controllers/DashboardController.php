<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardFilterRequest;
use App\Models\AgensiPenempatan;
use App\Models\PerusahaanIndonesia;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(DashboardFilterRequest $request)
    {
        $filters = $request->validated();
        $filters['periode'] = $filters['periode'] ?? 'monthly';

        $stats = $this->buildStats();
        $charts = [
            'tenaga_kerja_series' => $this->tenagaKerjaSeries($filters),
            'gender' => $this->genderDistribution($filters),
        ];

        $latestEntries = $this->latestTenagaKerja();

        return view('layouts.index', compact('stats', 'charts', 'filters', 'latestEntries'));
    }

    private function buildStats(): array
    {
        return [
            'tenaga_kerja' => TenagaKerja::count(),
            'perusahaan' => PerusahaanIndonesia::count(),
            'agensi' => AgensiPenempatan::count(),
        ];
    }

    private function tenagaKerjaSeries(array $filters): array
    {
        $period = $filters['periode'] ?? 'monthly';
        [$start, $end] = $this->resolvePeriodRange($period);

        $query = $this->baseTenagaKerjaQuery($filters, $start, $end);

        $series = match ($period) {
            'weekly' => $this->buildDailySeries(clone $query, $start, $end),
            'yearly' => $this->buildYearlySeries(clone $query, $start, $end),
            default => $this->buildMonthlySeries(clone $query, $start, $end),
        };

        return [
            'labels' => $series['labels'],
            'data' => $series['data'],
            'colors' => array_map(
                fn () => '#0ea5e9',
                $series['data']
            ),
            'meta' => [
                'unit' => $series['unit'],
                'range' => [
                    'start' => $start->copy()->translatedFormat('d M Y'),
                    'end' => $end->copy()->translatedFormat('d M Y'),
                ],
                'range_label' => sprintf(
                    '%s - %s',
                    $start->copy()->translatedFormat('d M Y'),
                    $end->copy()->translatedFormat('d M Y')
                ),
            ],
        ];
    }

    private function genderDistribution(array $filters): array
    {
        $period = $filters['periode'] ?? 'monthly';
        [$start, $end] = $this->resolvePeriodRange($period);

        $counts = $this->baseTenagaKerjaQuery($filters, $start, $end)
            ->select('gender', DB::raw('COUNT(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        $complete = collect(TenagaKerja::GENDERS)
            ->mapWithKeys(fn ($gender) => [$gender => (int) ($counts[$gender] ?? 0)]);

        return [
            'labels' => $complete->keys()->values()->all(),
            'data' => $complete->values()->all(),
        ];
    }

    private function baseTenagaKerjaQuery(array $filters, ?Carbon $start, ?Carbon $end): Builder
    {
        return $this->applyLocationFilters(TenagaKerja::query(), $filters)
            ->when($start && $end, fn ($q) => $q->whereBetween('created_at', [$start, $end]));
    }

    private function applyLocationFilters(Builder $query, array $filters): Builder
    {
        $kecamatan = isset($filters['kecamatan']) ? trim(mb_strtolower($filters['kecamatan'])) : null;
        $desa = isset($filters['desa']) ? trim(mb_strtolower($filters['desa'])) : null;

        return $query
            ->when($kecamatan, fn ($q) => $q->whereRaw('LOWER(kecamatan) LIKE ?', ['%' . $kecamatan . '%']))
            ->when($desa, fn ($q) => $q->whereRaw('LOWER(desa) LIKE ?', ['%' . $desa . '%']));
    }

    private function resolvePeriodRange(string $period): array
    {
        $now = now()->endOfDay();

        if ($period === 'weekly') {
            $startOfWeek = $now->copy()->startOfWeek(Carbon::MONDAY);

            return [$startOfWeek, $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY)];
        }

        $start = match ($period) {
            'yearly' => $now->copy()->subYears(4)->startOfYear(),
            default => $now->copy()->subMonths(11)->startOfMonth(),
        };

        return [$start, $now];
    }

    private function buildDailySeries(Builder $query, Carbon $start, Carbon $end): array
    {
        $counts = $query
            ->selectRaw('DATE(created_at) as bucket')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->pluck('total', 'bucket');

        $labels = [];
        $data = [];
        $cursor = $start->copy();

        while ($cursor <= $end) {
            $key = $cursor->format('Y-m-d');
            $labels[] = $cursor->translatedFormat('d M');
            $data[] = (int) ($counts[$key] ?? 0);
            $cursor->addDay();
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'unit' => 'Hari',
        ];
    }

    private function buildMonthlySeries(Builder $query, Carbon $start, Carbon $end): array
    {
        $counts = $query
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bucket')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->pluck('total', 'bucket');

        $labels = [];
        $data = [];
        $cursor = $start->copy()->startOfMonth();
        $endOfPeriod = $end->copy()->startOfMonth();

        while ($cursor <= $endOfPeriod) {
            $key = $cursor->format('Y-m');
            $labels[] = $cursor->translatedFormat('M Y');
            $data[] = (int) ($counts[$key] ?? 0);
            $cursor->addMonthNoOverflow();
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'unit' => 'Bulan',
        ];
    }

    private function buildYearlySeries(Builder $query, Carbon $start, Carbon $end): array
    {
        $counts = $query
            ->selectRaw('YEAR(created_at) as bucket')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->pluck('total', 'bucket');

        $labels = [];
        $data = [];

        for ($year = $start->year; $year <= $end->year; $year++) {
            $labels[] = (string) $year;
            $data[] = (int) ($counts[$year] ?? 0);
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'unit' => 'Tahun',
        ];
    }

    private function latestTenagaKerja()
    {
        return TenagaKerja::query()
            ->latest()
            ->take(6)
            ->get(['id', 'nama', 'kecamatan', 'desa', 'created_at']);
    }
}
