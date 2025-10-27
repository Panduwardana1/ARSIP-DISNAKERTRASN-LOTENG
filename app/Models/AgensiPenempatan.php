<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class AgensiPenempatan extends Model
{
    use HasFactory;

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_NON_AKTIF = 'non_aktif';

    protected $fillable = [
        'nama',
        'lokasi',
        'gambar',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'string',
    ];

    protected $appends = [
        'gambar_url',
    ];

    public function rekomendasiItems()
    {
        return $this->hasMany(RekomendasiItem::class, 'agensi_id');
    }


    /**
     * Lowongan yang ditawarkan oleh agensi ini.
     */
    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'agensi_id');
    }

    /**
     * Opsi status yang tersedia untuk agensi.
     *
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_AKTIF => 'Aktif',
            self::STATUS_NON_AKTIF => 'Non Aktif',
        ];
    }

    /**
     * Validasi nilai status.
     */
    public static function isValidStatus(?string $status): bool
    {
        return in_array($status, array_keys(static::statusOptions()), true);
    }

    /**
     * Scope pencarian sederhana berdasarkan nama dan status.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $keyword = trim((string) ($filters['keyword'] ?? ''));

        return $query->when($keyword !== '', function (Builder $subQuery) use ($keyword) {
                $subQuery->where('nama', 'like', '%' . $keyword . '%');
            });
    }
}
