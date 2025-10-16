<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekap extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenaga_kerja_id',
        'lowongan_id',
        'destinasi_id',
        'status',
        'dibuat_oleh',
    ];

    /**
     * Tenaga kerja yang direkap.
     */
    public function tenagaKerja(): BelongsTo
    {
        return $this->belongsTo(TenagaKerja::class);
    }

    /**
     * Lowongan yang terkait dengan rekap ini.
     */
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    /**
     * Destinasi penempatan (opsional).
     */
    public function destinasi(): BelongsTo
    {
        return $this->belongsTo(Destinasi::class);
    }

    /**
     * Pengguna yang membuat rekap.
     */
    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
