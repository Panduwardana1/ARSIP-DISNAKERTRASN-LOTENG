<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiItem extends Model
{
    /** @use HasFactory<\Database\Factories\RekomendasiItemFactory> */
    use HasFactory;

    protected $fillable = [
        'rekomendasi_id',
        'tenaga_kerja_id',
        'lowongan_id',
        'agensi_id',
        'perusahaan_id',
        'destinasi_id',
        'pendidikan_id',
        'nik',
        'nama',
        'gender',
        'alamat_lengkap'
    ];
    public function rekomendasi() {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function tenagaKerja() {
        return $this->belongsTo(TenagaKerja::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }

    public function agensi()
    {
        return $this->belongsTo(AgensiPenempatan::class, 'agensi_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(PerusahaanIndonesia::class, 'perusahaan_id');
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
