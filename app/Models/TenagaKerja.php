<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class TenagaKerja extends Model
{
    use HasFactory;

    public const GENDER_MALE = 'Laki-laki';
    public const GENDER_FEMALE = 'Perempuan';

    protected $fillable = [
        'nama',
        'nik',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'desa',
        'kecamatan',
        'alamat_lengkap',
        'pendidikan_id',
        'lowongan_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $appends = [
        'usia',
    ];

    /**
     * Pendidikan terakhir tenaga kerja.
     */
    public function pendidikan(): BelongsTo
    {
        return $this->belongsTo(Pendidikan::class);
    }

    /**
     * Lowongan yang sedang diikuti.
     */
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class);
    }

    /**
     * Riwayat rekap untuk tenaga kerja ini.
     */
    public function rekaps(): HasMany
    {
        return $this->hasMany(Rekap::class);
    }

    /**
     * Pilihan gender yang tersedia.
     *
     * @return array<string, string>
     */
    public static function genderOptions(): array
    {
        return [
            self::GENDER_MALE => self::GENDER_MALE,
            self::GENDER_FEMALE => self::GENDER_FEMALE,
        ];
    }

    /**
     * Scope filter untuk pencarian tenaga kerja.
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        $keyword = trim((string) ($filters['keyword'] ?? ''));
        $gender = $filters['gender'] ?? null;
        $pendidikanId = $filters['pendidikan'] ?? null;
        $lowonganId = $filters['lowongan'] ?? null;

        $query
            ->when($keyword !== '', function (Builder $subQuery) use ($keyword) {
                $subQuery->where(function (Builder $inner) use ($keyword) {
                    $inner
                        ->where('nama', 'like', '%' . $keyword . '%')
                        ->orWhere('nik', 'like', '%' . $keyword . '%')
                        ->orWhere('desa', 'like', '%' . $keyword . '%')
                        ->orWhere('kecamatan', 'like', '%' . $keyword . '%');
                });
            })
            ->when(static::isValidGender($gender), function (Builder $subQuery) use ($gender) {
                $subQuery->where('gender', $gender);
            })
            ->when(!empty($pendidikanId), function (Builder $subQuery) use ($pendidikanId) {
                $subQuery->where('pendidikan_id', $pendidikanId);
            })
            ->when(!empty($lowonganId), function (Builder $subQuery) use ($lowonganId) {
                $subQuery->where('lowongan_id', $lowonganId);
            });
    }

    /**
     * Validasi nilai gender.
     */
    public static function isValidGender(?string $gender): bool
    {
        return in_array($gender, array_keys(static::genderOptions()), true);
    }

    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir instanceof Carbon
            ? $this->tanggal_lahir->age
            : null;
    }
}
