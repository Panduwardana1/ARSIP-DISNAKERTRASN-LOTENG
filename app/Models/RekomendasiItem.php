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
    ];

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function tenagaKerja(): BelongsTo
    {
        return $this->belongsTo(TenagaKerja::class);
    }
}
