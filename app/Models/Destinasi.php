<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    ];

    protected $casts = [
        'nama' => 'string',
        'kode' => 'string',
        'benua' => 'string',
    ];

    /**
     * Rekap penempatan yang menunjuk destinasi ini.
     */
    public function rekaps(): HasMany
    {
        return $this->hasMany(Rekap::class);
    }

    protected function kode(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? strtoupper($value) : null,
            set: fn(?string $value) => $value ? strtoupper($value) : null,
        );
    }
}
