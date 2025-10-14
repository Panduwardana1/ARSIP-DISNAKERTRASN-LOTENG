<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Negara extends Model
{
    /** @use HasFactory<\Database\Factories\NegaraFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_negara',
        'kode',
    ];

    /**
     * Lowongan yang menargetkan negara ini sebagai tujuan.
     */
    public function agensiLowongans(): HasMany
    {
        return $this->hasMany(AgensiLowongan::class, 'negara_id');
    }

    /**
     * Registrasi tenaga kerja yang tercatat menuju negara ini.
     */
    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class, 'negara_id');
    }

    /**
     * Rekap agregat berdasarkan negara tujuan.
     */
    public function rekapTenagaKerjas(): HasMany
    {
        return $this->hasMany(RekapTenagaKerja::class, 'negara_id');
    }
}
