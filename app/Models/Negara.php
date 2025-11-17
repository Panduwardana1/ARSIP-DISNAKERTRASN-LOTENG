<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Negara extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'kode_iso',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function tenagaKerjas(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    public function rekomendasiItems(): HasMany
    {
        return $this->hasMany(RekomendasiItem::class);
    }
}
