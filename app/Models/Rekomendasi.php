<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    /** @use HasFactory<\Database\Factories\RekomendasiFactory> */
    use HasFactory;

    protected $fillable = [
        'sequence',
        'nomor',
        'tahun',
        'tanggal_rekom',
        'perusahaan_id',
        'jumlah_laki',
        'jumlah_perempuan',
        'total',
        'dibuat_oleh'
    ];

    public function items()
    {
        return $this->hasMany(RekomendasiItem::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(PerusahaanIndonesia::class, 'perusahaan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
