<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerusahaanAgensi extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanAgensiFactory> */
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'agensi_id',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function agensi(): BelongsTo
    {
        return $this->belongsTo(Agensi::class);
    }

    /**
     * Lowongan yang ditawarkan oleh kemitraan perusahaan-agensi ini.
     */
    public function agensiLowongans(): HasMany
    {
        return $this->hasMany(AgensiLowongan::class);
    }

    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }
}
