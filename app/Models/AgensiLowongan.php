<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgensiLowongan extends Model
{
    /** @use HasFactory<\Database\Factories\AgensiLowonganFactory> */
    use HasFactory;

    protected $fillable = [
        'lowongan_pekerjaan_id',
        'negara_id',
        'perusahaan_agensi_id',
        'status',
        'tanggal_mulai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];

    public function lowonganPekerjaan(): BelongsTo
    {
        return $this->belongsTo(LowonganPekerjaan::class);
    }

    public function negaraTujuan(): BelongsTo
    {
        return $this->belongsTo(Negara::class, 'negara_id');
    }

    public function perusahaanAgensi(): BelongsTo
    {
        return $this->belongsTo(PerusahaanAgensi::class);
    }

    public function tenagaKerjas(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }
}
