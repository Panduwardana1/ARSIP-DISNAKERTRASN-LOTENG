<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LowonganPekerjaan extends Model
{
    /** @use HasFactory<\Database\Factories\LowonganPekerjaanFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_pekerjaan',
        'kontrak_kerja',
        'keterangan',
    ];

    protected $casts = [
        'kontrak_kerja' => 'integer',
    ];

    public function agensiLowongans(): HasMany
    {
        return $this->hasMany(AgensiLowongan::class);
    }

    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }

    public function rekapTenagaKerjas(): HasMany
    {
        return $this->hasMany(RekapTenagaKerja::class);
    }
}
