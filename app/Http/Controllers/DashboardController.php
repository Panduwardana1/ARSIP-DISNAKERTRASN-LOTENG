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
    private const DAY_LABELS = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    public function index(DashboardFilterRequest $request)
    {
        $filters = $request->validated();
        $filters['periode'] = $filters['periode'] ?? 'monthly';

        $stats = $this->buildStats();
        $charts = [
            'tenaga_kerja_series' => $this->tenagaKerjaSeries($filters),
            'gender' => $this->genderDistribution($filters),
        ];

        return view('layouts.index', compact('stats', 'charts', 'filters'));
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

        $dbFormat = match ($period) {
            'weekly' => '%Y-%m-%d',
            'yearly' => '%Y',
            default => '%Y-%m',
        };

        $dataset = $query
            ->selectRaw("DATE_FORMAT(created_at, '{$dbFormat}') as label, COUNT(*) as total")
            ->groupBy('label')
            ->orderBy('label')
            ->get()
            ->pluck('total', 'label')
            ->all();

        [$labels, $data] = $this->buildSeriesBuckets($period, $start, $end, $dataset);

        return [
            'labels' => $labels,
            'data' => $data,
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
        $kecamatan = isset($filters['kecamatan']) ? mb_strtolower($filters['kecamatan']) : null;
        $desa = isset($filters['desa']) ? mb_strtolower($filters['desa']) : null;

        return $query
            ->when($kecamatan, fn ($q) => $q->whereRaw('LOWER(kecamatan) = ?', [$kecamatan]))
            ->when($desa, fn ($q) => $q->whereRaw('LOWER(desa) = ?', [$desa]));
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

    private function buildSeriesBuckets(string $period, Carbon $start, Carbon $end, array $dataset): array
    {
        $labels = [];
        $data = [];

        $cursor = $start->copy();

        while ($cursor <= $end) {
            switch ($period) {
                case 'weekly':
                    $bucketKey = $cursor->format('Y-m-d');
                    $displayLabel = self::DAY_LABELS[$cursor->isoWeekday()] ?? $cursor->translatedFormat('l');
                    $cursor->addDay();
                    break;
                case 'yearly':
                    $bucketKey = $cursor->format('Y');
                    $displayLabel = $cursor->format('Y');
                    $cursor->addYear();
                    break;
                default:
                    $bucketKey = $cursor->format('Y-m');
                    $displayLabel = $cursor->translatedFormat('M Y');
                    $cursor->addMonth();
                    break;
            }

            $labels[] = $displayLabel;
            $data[] = (int) ($dataset[$bucketKey] ?? 0);
        }

        return [$labels, $data];
    }
}

