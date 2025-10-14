<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenagaKerja extends Model
{
    /** @use HasFactory<\Database\Factories\TenagaKerjaFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_induk',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'desa',
        'kecamatan',
        'alamat_lengkap',
        'pendidikan_id',
        'agensi_lowongan_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class);
    }

    public function agensiLowongan(): BelongsTo
    {
        return $this->belongsTo(AgensiLowongan::class);
    }

    public function registrasiTenagaKerjas(): HasMany
    {
        return $this->hasMany(RegistrasiTenagaKerja::class);
    }
}
