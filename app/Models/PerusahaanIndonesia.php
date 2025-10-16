<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerusahaanIndonesia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nama_pimpinan',
        'email',
        'nomor_hp',
        'alamat',
        'icon',
    ];

    /**
     * Lowongan yang dikeluarkan oleh perusahaan ini.
     */
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'perusahaan_id');
    }
}
