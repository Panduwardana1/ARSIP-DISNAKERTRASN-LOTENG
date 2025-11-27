<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TenagaKerja;

class Pendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
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
