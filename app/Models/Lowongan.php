<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    use HasFactory;

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_NON_AKTIF = 'non_aktif';

    protected $fillable = [
        'nama',
        'agensi_id',
        'perusahaan_id',
        'destinasi_id',
        'catatan',
        'is_aktif',
    ];

    /**
     * Agensi penempatan yang mengelola lowongan ini.
     */
    public function agensi(): BelongsTo
    {
        return $this->belongsTo(AgensiPenempatan::class, 'agensi_id');
    }

    public function rekomendasiItems()
    {
        return $this->hasMany(RekomendasiItem::class);
    }


    /**
     * Perusahaan asal yang membutuhkan tenaga kerja.
     */
    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(PerusahaanIndonesia::class, 'perusahaan_id');
    }

    /**
     * Destinasi negara tujuan untuk lowongan ini.
     */
    public function destinasi(): BelongsTo
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }

    /**
     * Tenaga kerja yang melamar atau ditempatkan di lowongan ini.
     */
    public function tenagaKerja(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    /**
     * Riwayat rekap untuk lowongan ini.
     */
    public function rekaps(): HasMany
    {
        return $this->hasMany(Rekap::class);
    }

    /**
     * Opsi status yang tersedia untuk lowongan.
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
     * Filter query berdasarkan kata kunci, status, dan destinasi.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $keyword = trim((string) ($filters['keyword'] ?? ''));

        return $query->when($keyword !== '', function (Builder $subQuery) use ($keyword) {
                $subQuery->where('nama', 'like', '%' . $keyword . '%');
            });
    }

    /**
     * Pastikan status berada dalam daftar yang diizinkan.
     */
    public static function isValidStatus(?string $status): bool
    {
        return in_array($status, array_keys(static::statusOptions()), true);
    }
}
