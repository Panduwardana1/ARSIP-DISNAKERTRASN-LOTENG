<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgensiPenempatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'lokasi',
        'icon',
        'is_aktif',
    ];

    /**
     * Lowongan yang ditawarkan oleh agensi ini.
     */
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'agensi_id');
    }
}
