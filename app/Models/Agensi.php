<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agensi extends Model
{
    /** @use HasFactory<\Database\Factories\AgensiFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_agensi',
        'lokasi',
    ];

    /**
     * Hubungan kemitraan antara agensi dan perusahaan.
     */
    public function perusahaanAgensis(): HasMany
    {
        return $this->hasMany(PerusahaanAgensi::class);
    }

    /**
     * Registrasi tenaga kerja yang melibatkan agensi ini.
     */
    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }

    /**
     * Rekap agregat dengan dimensi agensi.
     */
    public function rekapTenagaKerjas(): HasMany
    {
        return $this->hasMany(RekapTenagaKerja::class);
    }
}
