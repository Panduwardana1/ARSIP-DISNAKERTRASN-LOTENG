<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipRekomendasi extends Model
{
    use HasFactory;

    protected $table = 'arsip_rekomendasis';

    protected $fillable = [
        'rekomendasi_id',
        'file_path',
        'dicetak_pada',
        'dicetak_oleh',
    ];

    protected $casts = [
        'dicetak_pada' => 'datetime',
    ];

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function pencetak(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicetak_oleh');
    }
}
