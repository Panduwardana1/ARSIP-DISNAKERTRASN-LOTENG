<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'rekomendasi_id',
        'tenaga_kerja_id',
        'perusahaan_id',
        'negara_id',
    ];

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function tenagaKerja(): BelongsTo
    {
        return $this->belongsTo(TenagaKerja::class);
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function negara(): BelongsTo
    {
        return $this->belongsTo(Negara::class);
    }
}
