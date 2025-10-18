<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use App\Models\Lowongan;

class PerusahaanIndonesia extends Model
{
    use HasFactory;
    protected $table = 'perusahaan_indonesias';
    protected $fillable = [
        'nama',
        'nama_pimpinan',
        'email',
        'nomor_hp',
        'alamat',
        'gambar',
    ];

    protected $appends = [
        'icon_url',
    ];

    /**
     * Lowongan yang dikeluarkan oleh perusahaan ini.
     */
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'perusahaan_id');
    }
}
