<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenagaKerja extends Model
{
    use HasFactory, SoftDeletes;

    public const GENDERS = [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ];

    protected $fillable = [
        'nama',
        'nik',
        'gender',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_lengkap',
        'kecamatan_id',
        'desa_id',
        'pendidikan_id',
        'perusahaan_id',
        'agency_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi Eloquent
    public function desa() {
        return $this->belongsTo(Desa::class);
    }

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class);
    }

    public function pendidikan() {
        return $this->belongsTo(Pendidikan::class);
    }

    public function perusahaan() {
        return $this->belongsTo(Perusahaan::class);
    }

    public function agency() {
        return $this->belongsTo(Agency::class);
    }

    // label gender
    public function getLabelGender(): string {
        return self::GENDERS[$this->gender] ?? $this->gender;
    }

    // rapikan nik hanya angka saja
    public function setNikAttribute($value): void
    {
        $this->attributes['nik'] = preg_replace('/\D/', '', (string) $value);
    }

    // scoop search
    public function scopeSearch($keyword, ?string $term) {
        if(!$term) return $keyword;
        $term = trim($term);
        return $keyword->where(function ($q) use ($term) {
            $q->where('nama', 'like', "%{$term}%")
                ->orWhere('nama', 'like', "%{$term}%");
        });
    }

    // filter data
    public function scopeFilterWilayah($q, ?int $kecamatanId, ?int $desaId) {
        if($kecamatanId) $q->where('kecamatan_id', $kecamatanId);
        if($desaId) $q->where('desa_id', $desaId);
        return $q;
    }

    public function scopeRange($q, ?string $from, ?string $to) {
        if($from) $q->whereDate('created_at', '>=' ,$from);
        if($to) $q->whereDate('created_at', '<=' ,$to);
        return $q;
    }
}
