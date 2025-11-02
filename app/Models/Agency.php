<?php

namespace App\Models;

use App\Models\Perusahaan;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agency extends Model
{
    /** @use HasFactory<\Database\Factories\AgencyFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'country',
        'kota',
        'lowongan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tenagaKerjas()
    {
        return $this->hasMany(TenagaKerja::class);
    }

    public function perusahaans()
    {
        return $this->hasMany(Perusahaan::class);
    }
}
