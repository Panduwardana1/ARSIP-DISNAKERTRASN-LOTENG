<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenagaKerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'desa',
        'kecamatan',
        'alamat_lengkap',
        'pendidikan_id',
        'lowongan_id',
    ];

    /**
     * Pendidikan terakhir tenaga kerja.
     */
    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class);
    }

    /**
     * Lowongan yang sedang diikuti.
     */
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    /**
     * Riwayat rekap untuk tenaga kerja ini.
     */
    public function rekaps(): HasMany
    {
        return $this->hasMany(Rekap::class);
    }
}
