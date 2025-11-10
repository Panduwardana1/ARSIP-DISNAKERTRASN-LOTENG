<?php

namespace App\Models;

use App\Models\Kecamatan;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model
{
    /** @use HasFactory<\Database\Factories\DesaFactory> */
    use HasFactory;

    protected $fillable = ['kecamatan_id','nama'];

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }

    public function tenagaKerja() {
        return $this->hasMany(TenagaKerja::class);
    }
}
