<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destinasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'benua',
        'icon',
    ];

    /**
     * Rekap penempatan yang menunjuk destinasi ini.
     */
    public function rekaps(): HasMany
    {
        return $this->hasMany(Rekap::class);
    }
}
