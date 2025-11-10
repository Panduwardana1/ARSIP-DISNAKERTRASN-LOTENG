<?php

namespace App\Models;

use App\Models\Desa;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    /** @use HasFactory<\Database\Factories\KecamatanFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
    ];

    protected $casts = [
        'nama' => 'string',
        'kode' => 'string',
    ];

    public function desas() {
        return $this->hasMany(Desa::class);
    }
}
