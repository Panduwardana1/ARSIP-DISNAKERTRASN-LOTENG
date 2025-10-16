<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'agensi_id',
        'perusahaan_id',
        'kontrak_kerja',
        'is_aktif',
    ];

    /**
     * Agensi penempatan yang mengelola lowongan ini.
     */
    public function agensi(): BelongsTo
    {
        return $this->belongsTo(AgensiPenempatan::class, 'agensi_id');
    }

    /**
     * Perusahaan asal yang membutuhkan tenaga kerja.
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(PerusahaanIndonesia::class, 'perusahaan_id');
    }

    /**
     * Tenaga kerja yang melamar atau ditempatkan di lowongan ini.
     */
    public function tenagaKerja(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    /**
     * Riwayat rekap untuk lowongan ini.
     */
    public function rekaps(): HasMany
    {
        return $this->hasMany(Rekap::class);
    }
}
