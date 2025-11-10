<?php

namespace App\Models;

use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Perusahaan extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'pimpinan',
        'email',
        'alamat',
        'gambar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tenagaKerja()
    {
        return $this->hasMany(TenagaKerja::class);
    }
}
