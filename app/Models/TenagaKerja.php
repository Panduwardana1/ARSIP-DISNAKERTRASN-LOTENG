<?php

namespace App\Models;

use App\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TenagaKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const GENDERS = [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ];

    public const STATUSES = [
        'Aktif' => 'Aktif',
        'Banned' => 'Banned',
    ];

    protected $fillable = [
        'nama',
        'nik',
        'gender',
        'email',
        'no_telpon',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_lengkap',
        'desa_id',
        'kode_pos',
        'pendidikan_id',
        'perusahaan_id',
        'agency_id',
        'negara_id',
        'is_active',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi Eloquent
    public function desa() {
        return $this->belongsTo(Desa::class);
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

    public function rekomendasis(): BelongsToMany
    {
        return $this->belongsToMany(Rekomendasi::class, 'rekomendasi_items')
            ->withPivot('id');
    }

    public function negara() : BelongsTo {
        return $this->belongsTo(Negara::class);
    }

    // label gender
    public function getLabelGender(): string {
        return self::GENDERS[$this->gender] ?? $this->gender;
    }

    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
    }
}
