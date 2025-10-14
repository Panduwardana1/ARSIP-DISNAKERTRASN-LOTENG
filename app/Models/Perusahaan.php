<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perusahaan extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'email',
        'nama_pimpinan',
        'no_telepon',
        'alamat',
    ];

    /**
     * Relasi ke tabel pivot perusahaan dengan agensi.
     */
    public function perusahaanAgensis(): HasMany
    {
        return $this->hasMany(PerusahaanAgensi::class);
    }

    /**
     * Registrasi tenaga kerja yang tercatat dengan perusahaan ini.
     */
    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }

    /**
     * Rekap agregat untuk perusahaan ini.
     */
    public function rekapTenagaKerjas(): HasMany
    {
        return $this->hasMany(RekapTenagaKerja::class);
    }
}
