<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapTenagaKerja extends Model
{
    /** @use HasFactory<\Database\Factories\RekapTenagaKerjaFactory> */
    use HasFactory;

    protected $fillable = [
        'jenis',
        'periode',
        'tahun',
        'bulan',
        'perusahaan_id',
        'agensi_id',
        'lowongan_pekerjaan_id',
        'negara_id',
        'pendidikan_id',
        'kecamatan',
        'desa',
        'total',
    ];

    protected $casts = [
        'periode' => 'date',
        'tahun' => 'integer',
        'bulan' => 'integer',
        'total' => 'integer',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function agensi(): BelongsTo
    {
        return $this->belongsTo(Agensi::class);
    }

    public function lowonganPekerjaan(): BelongsTo
    {
        return $this->belongsTo(LowonganPekerjaan::class);
    }

    public function negaraTujuan(): BelongsTo
    {
        return $this->belongsTo(Negara::class, 'negara_id');
    }

    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
