<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendidikan extends Model
{
    /** @use HasFactory<\Database\Factories\PendidikanFactory> */
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'level',
    ];

    /**
     * Tenaga kerja yang memiliki jenjang pendidikan ini.
     */
    public function tenagaKerjas(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    /**
     * Data registrasi yang tersimpan dengan snapshot pendidikan ini.
     */
    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }

    /**
     * Rekap agregat berdasarkan pendidikan.
     */
    public function rekapTenagaKerjas(): HasMany
    {
        return $this->hasMany(RekapTenagaKerja::class);
    }
}
