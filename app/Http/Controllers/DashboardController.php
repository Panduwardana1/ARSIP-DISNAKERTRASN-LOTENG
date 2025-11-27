<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Perusahaan;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RekomendasiItem;
use Illuminate\Database\QueryException;

class DashboardController extends Controller
{
    public function index()
    {
        $lastAdd = TenagaKerja::latest()->paginate(5);

        $cast = [
            'totalTenagaKerja' => $this->countTenagaKerja(),
            'totalAgency'      => $this->countAgency(),
            'totalPerusahaan'  => $this->countPerusahaan(),
            'totalRekomendasi' => $this->countRekomendasi(),
        ];

        $kecamatans = Kecamatan::orderBy('nama')->get(['id', 'nama']);
        $desas = Desa::orderBy('nama')->get(['id', 'nama', 'kecamatan_id']);

        return view('layouts.index', compact('cast', 'lastAdd', 'kecamatans', 'desas'));
    }

    private function countTenagaKerja()
    {
        return TenagaKerja::count(); // otomatis exclude softDeletes
    }

    private function countPerusahaan()
    {
        return Perusahaan::count();
    }

    private function countAgency()
    {
        return Agency::count();
    }

    private function countRekomendasi()
    {
        return RekomendasiItem::count();
    }

    public function chartTenagaKerja(Request $request)
    {
        $range = $request->get('range', 'month');
        $filters = $this->resolveLocationFilters(
            $request->input('kecamatan_id'),
            $request->input('desa_id')
        );
        $now   = Carbon::now();

        if ($range === 'week') {
            return $this->chartPerMinggu($now, $filters);
        }

        if ($range === 'year') {
            return $this->chartPerTahun($filters);
        }

        // default: per bulan (12 bulan dalam tahun berjalan)
        return $this->chartPerBulan($now, $filters);
    }

    /** CPMI per hari dalam minggu ini (Senin–Minggu) */
    protected function chartPerMinggu(Carbon $now, array $filters = [])
    {
        $start = $now->copy()->startOfWeek(Carbon::MONDAY);
        $end   = $now->copy()->endOfWeek(Carbon::SUNDAY);

        // Query group by DATE
        $rows = $this->buildFilteredTenagaKerjaQuery($filters)
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Map ke Senin–Minggu
        $labels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $data   = array_fill(0, 7, 0);

        foreach ($rows as $row) {
            $tgl = Carbon::parse($row->tanggal);
            // Carbon: Monday=1 ... Sunday=7 → kita jadikan index 0–6
            $index = $tgl->dayOfWeekIso - 1;
            $data[$index] = (int) $row->total;
        }

        return response()->json([
            'type'   => 'week',
            'labels' => $labels,
            'datasets' => [
                [
                    'label'           => 'CPMI minggu ini',
                    'data'            => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor'     => 'rgba(37, 99, 235, 1)',
                    'borderWidth'     => 1,
                    'borderRadius'    => 8,
                ],
            ],
            'meta' => [
                'range_label' => 'Data Mingguan',
                'filter_label' => $filters['filter_label'] ?? 'Semua Wilayah',
            ],
        ]);
    }

    /** CPMI per bulan (Jan–Des) tahun ini */
    protected function chartPerBulan(Carbon $now, array $filters = [])
    {
        $year = (int) $now->year;

        $rows = $this->buildFilteredTenagaKerjaQuery($filters)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $labels = [];
        $data   = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $namaBulan[$i];

            $row  = $rows->firstWhere('bulan', $i);
            $data[] = $row ? (int) $row->total : 0;
        }

        return response()->json([
            'type'   => 'month',
            'labels' => $labels,
            'datasets' => [
                [
                    'label'           => "CPMI tahun $year",
                    'data'            => $data,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.8)',
                    'borderColor'     => 'rgba(5, 150, 105, 1)',
                    'borderWidth'     => 1,
                    'borderRadius'    => 8,
                ],
            ],
            'meta' => [
                'year'        => $year,
                'range_label' => "Januari – Desember $year",
                'filter_label' => $filters['filter_label'] ?? 'Semua Wilayah',
            ],
        ]);
    }

    /** CPMI per tahun (semua tahun yang ada) */
    protected function chartPerTahun(array $filters = [])
    {
        $rows = $this->buildFilteredTenagaKerjaQuery($filters)
            ->selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $labels = $rows->pluck('tahun')->map(fn ($y) => (string) $y)->toArray();
        $data   = $rows->pluck('total')->map(fn ($v) => (int) $v)->toArray();

        return response()->json([
            'type'   => 'year',
            'labels' => $labels,
            'datasets' => [
                [
                    'label'           => 'CPMI',
                    'data'            => $data,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.8)',
                    'borderColor'     => 'rgba(217, 119, 6, 1)',
                    'borderWidth'     => 1,
                    'borderRadius'    => 8,
                ],
            ],
            'meta' => [
                'range_label' => 'Tahun',
                'filter_label' => $filters['filter_label'] ?? 'Semua Wilayah',
            ],
        ]);
    }

    public function chartTenagaKerjaGender(Request $request)
    {
        $filters = $this->resolveLocationFilters(
            $request->input('kecamatan_id'),
            $request->input('desa_id')
        );

        $rows = $this->buildFilteredTenagaKerjaQuery($filters)
            ->selectRaw('gender, COUNT(*) as total')
            ->groupBy('gender')
            ->get()
            ->keyBy('gender');

        $labels = [];
        $data = [];

        foreach (TenagaKerja::GENDERS as $code => $label) {
            $labels[] = $label;
            $value = optional($rows->get($code))->total;
            $data[] = (int) ($value ?? 0);
        }

        return response()->json([
            'type' => 'gender',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Distribusi Gender',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.85)',
                        'rgba(249, 115, 22, 0.85)',
                    ],
                    'borderColor' => [
                        'rgba(37, 99, 235, 1)',
                        'rgba(194, 65, 12, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'meta' => [
                'filter_label' => $filters['filter_label'] ?? 'Semua Wilayah',
            ],
        ]);
    }

    protected function resolveLocationFilters($kecamatanId, $desaId): array
    {
        $kecamatanId = $kecamatanId ? (int) $kecamatanId : null;
        $desaId = $desaId ? (int) $desaId : null;
        $filterLabel = 'Semua Wilayah';
        $kecamatanName = null;
        $desaName = null;

        if ($desaId) {
            $desa = Desa::with('kecamatan:id,nama')->find($desaId);
            if ($desa) {
                $desaName = $desa->nama;
                $kecamatanId = $desa->kecamatan_id;
                $kecamatanName = optional($desa->kecamatan)->nama;
            } else {
                $desaId = null;
            }
        }

        if ($kecamatanId) {
            if (! $kecamatanName) {
                $kecamatan = Kecamatan::find($kecamatanId);
                if ($kecamatan) {
                    $kecamatanName = $kecamatan->nama;
                } else {
                    $kecamatanId = null;
                }
            }
        }

        if ($desaName) {
            $filterLabel = $kecamatanName
                ? "Desa {$desaName} - {$kecamatanName}"
                : "Desa {$desaName}";
        } elseif ($kecamatanName) {
            $filterLabel = "Kecamatan {$kecamatanName}";
        }

        return [
            'kecamatan_id' => $kecamatanId,
            'desa_id' => $desaId,
            'filter_label' => $filterLabel,
        ];
    }

    protected function buildFilteredTenagaKerjaQuery(array $filters)
    {
        $query = TenagaKerja::query();

        $desaId = $filters['desa_id'] ?? null;
        $kecamatanId = $filters['kecamatan_id'] ?? null;

        if ($desaId) {
            $query->where('desa_id', $desaId);
        }

        if ($kecamatanId) {
            $query->whereHas('desa', function ($q) use ($kecamatanId) {
                $q->where('kecamatan_id', $kecamatanId);
            });
        }

        return $query;
    }
}
