<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrasiTenagaKerja extends Model
{
    /** @use HasFactory<\Database\Factories\RegistrasiTenagaKerjaFactory> */
    use HasFactory;

    protected $fillable = [
        'tenaga_kerja_id',
        'agensi_lowongan_id',
        'perusahaan_agensi_id',
        'perusahaan_id',
        'agensi_id',
        'lowongan_pekerjaan_id',
        'negara_id',
        'pendidikan_id',
        'kecamatan',
        'desa',
        'status',
        'tanggal_daftar',
        'tahun',
        'bulan',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tahun' => 'integer',
        'bulan' => 'integer',
    ];

    public function tenagaKerja(): BelongsTo
    {
        return $this->belongsTo(TenagaKerja::class);
    }

    public function agensiLowongan(): BelongsTo
    {
        return $this->belongsTo(AgensiLowongan::class);
    }

    public function perusahaanAgensi(): BelongsTo
    {
        return $this->belongsTo(PerusahaanAgensi::class);
    }

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
