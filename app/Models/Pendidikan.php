<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TenagaKerja;

class Pendidikan extends Model
{
    use HasFactory;

    public const LEVELS = ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'];

    protected $fillable = [
        'nama',
        'level',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tenagaKerjas()
    {
        return $this->hasMany(TenagaKerja::class);
    }
}
