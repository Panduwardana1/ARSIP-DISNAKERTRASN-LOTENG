<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'level'
    ];

    /**
     * Tenaga kerja dengan pendidikan ini.
     */
    public function tenagaKerja(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    public function rekomendasiItems()
    {
        return $this->hasMany(RekomendasiItem::class, 'pendidikan_id');
    }
}
