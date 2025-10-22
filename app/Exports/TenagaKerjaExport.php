<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\TenagaKerja;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TenagaKerjaExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    ShouldAutoSize
{
    protected Carbon $start;
    protected Carbon $end;
    protected array $filters;

    public function __construct(Carbon $start, Carbon $end, array $filters = [])
    {
        $this->start   = $start->copy()->startOfDay();
        $this->end     = $end->copy()->endOfDay();
        $this->filters = $filters;
    }

    public function query()
    {
        $q = TenagaKerja::query()
            ->from('tenaga_kerjas as tk')
            ->leftJoin('pendidikans as pd', 'pd.id', '=', 'tk.pendidikan_id')
            ->leftJoin('lowongans as lw', 'lw.id', '=', 'tk.lowongan_id')
            ->leftJoin('agensi_penempatans as ag', 'ag.id', '=', 'lw.agensi_id')
            ->leftJoin('perusahaan_indonesias as pr', 'pr.id', '=', 'lw.perusahaan_id')
            ->leftJoin('destinasis as ds', 'ds.id', '=', 'lw.destinasi_id')
            ->whereBetween('tk.created_at', [$this->start, $this->end])
            ->select([
                'tk.nama',
                'tk.nik',
                'tk.gender',
                'tk.tempat_lahir',
                'tk.tanggal_lahir',
                'pd.nama as pendidikan',
                'lw.nama as lowongan',
                'ag.nama as agensi',
                'pr.nama as perusahaan',
                'ds.nama as destinasi',
                'tk.desa',
                'tk.kecamatan',
                'tk.alamat_lengkap',
                'tk.created_at as tgl_daftar',
            ]);

        if ($ag = Arr::get($this->filters, 'agensi_id')) {
            $q->where('lw.agensi_id', $ag);
        }
        if ($pr = Arr::get($this->filters, 'perusahaan_id')) {
            $q->where('lw.perusahaan_id', $pr);
        }
        if ($ds = Arr::get($this->filters, 'destinasi_id')) {
            $q->where('lw.destinasi_id', $ds);
        }

        return $q->orderBy('tk.created_at');
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Gender',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Pendidikan',
            'Lowongan',
            'Agensi',
            'Perusahaan',
            'Destinasi',
            'Desa',
            'Kecamatan',
            'Alamat Lengkap',
            'Tanggal Daftar',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nama,
            $row->nik,
            $row->gender,
            $row->tempat_lahir,
            $row->tanggal_lahir ? Carbon::parse($row->tanggal_lahir)->format('Y-m-d') : null,
            $row->pendidikan,
            $row->lowongan,
            $row->agensi,
            $row->perusahaan,
            $row->destinasi,
            $row->desa,
            $row->kecamatan,
            $row->alamat_lengkap,
            $row->tgl_daftar ? Carbon::parse($row->tgl_daftar)->format('Y-m-d') : null,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Tanggal Lahir
            'N' => NumberFormat::FORMAT_DATE_YYYYMMDD, // Tanggal Daftar
        ];
    }
}
