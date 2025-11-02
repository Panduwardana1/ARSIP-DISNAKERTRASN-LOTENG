<?php

namespace App\Models;

use App\Models\Agency;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perusahaan extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'agency_id',
        'nama',
        'pimpinan',
        'email',
        'alamat',
        'gambar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function tenagaKerja()
    {
        return $this->hasMany(TenagaKerja::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
