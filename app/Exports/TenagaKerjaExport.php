<?php

namespace App\Exports;

use App\Models\TenagaKerja;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TenagaKerjaExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(private array $filters = [])
    {
    }

    public function query(): Builder
    {
        $query = TenagaKerja::query()
            ->select([
                'nama',
                'nik',
                'gender',
                'email',
                'no_telpon',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat_lengkap',
                'desa_id',
                'perusahaan_id',
                'agency_id',
                'negara_id',
                'is_active',
                'created_at',
            ])
            ->with([
                'desa:id,nama,kecamatan_id',
                'desa.kecamatan:id,nama',
                'perusahaan:id,nama',
                'agency:id,nama',
                'negara:id,nama',
            ]);

        return $this->applyFilters($query)->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Gender',
            'Email',
            'No Telpon',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Kecamatan',
            'Desa',
            'Perusahaan',
            'Agency',
            'Negara Tujuan',
            'Status',
            'Dibuat Pada',
        ];
    }

    /**
     * @param TenagaKerja $tenagaKerja
     * @return array<int, mixed>
     */
    public function map($tenagaKerja): array
    {
        return [
            $tenagaKerja->nama,
            $tenagaKerja->nik,
            TenagaKerja::GENDERS[$tenagaKerja->gender] ?? $tenagaKerja->gender,
            $tenagaKerja->email,
            $tenagaKerja->no_telpon,
            $tenagaKerja->tempat_lahir,
            $tenagaKerja->tanggal_lahir?->format('Y-m-d'),
            $tenagaKerja->alamat_lengkap,
            optional($tenagaKerja->desa?->kecamatan)->nama,
            optional($tenagaKerja->desa)->nama,
            optional($tenagaKerja->perusahaan)->nama,
            optional($tenagaKerja->agency)->nama,
            optional($tenagaKerja->negara)->nama,
            $tenagaKerja->is_active,
            $tenagaKerja->created_at?->format('Y-m-d H:i:s'),
        ];
    }

    private function applyFilters(Builder $query): Builder
    {
        return $query
            ->when(
                isset($this->filters['tahun']),
                fn (Builder $builder) => $builder->whereYear('created_at', (int) $this->filters['tahun'])
            )
            ->when(
                isset($this->filters['bulan']),
                fn (Builder $builder) => $builder->whereMonth('created_at', (int) $this->filters['bulan'])
            )
            ->when(
                isset($this->filters['minggu']),
                function (Builder $builder) {
                    $offset = (int) $this->filters['minggu'];
                    $startOfWeek = CarbonImmutable::now()->startOfWeek()->subWeeks($offset);
                    $endOfWeek = $startOfWeek->endOfWeek();

                    $builder->whereBetween('created_at', [
                        $startOfWeek->startOfDay(),
                        $endOfWeek->endOfDay(),
                    ]);
                }
            )
            ->when(
                isset($this->filters['gender']),
                fn (Builder $builder) => $builder->where('gender', $this->filters['gender'])
            )
            ->when(
                isset($this->filters['kecamatan_id']),
                fn (Builder $builder) => $builder->whereHas(
                    'desa',
                    fn (Builder $desaQuery) => $desaQuery->where('kecamatan_id', $this->filters['kecamatan_id'])
                )
            )
            ->when(
                isset($this->filters['desa_id']),
                fn (Builder $builder) => $builder->where('desa_id', $this->filters['desa_id'])
            )
            ->when(
                isset($this->filters['perusahaan_id']),
                fn (Builder $builder) => $builder->where('perusahaan_id', $this->filters['perusahaan_id'])
            )
            ->when(
                isset($this->filters['agency_id']),
                fn (Builder $builder) => $builder->where('agency_id', $this->filters['agency_id'])
            )
            ->when(
                isset($this->filters['negara_id']),
                fn (Builder $builder) => $builder->where('negara_id', $this->filters['negara_id'])
            );
    }
}
