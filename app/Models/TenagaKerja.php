<?php

namespace App\Models;

use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\Rekap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class TenagaKerja extends Model
{
    use HasFactory;

    public const GENDERS = ['Laki-laki', 'Perempuan'];

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

    public function rekomendasiItems()
    {
        return $this->hasMany(RekomendasiItem::class);
    }

    public function scopeSearch(Builder $query, ?string $raw): Builder
    {
        $keyword = trim((string) $raw);
        if ($keyword === '') {
            return $query;
        }

        $tokens = preg_split('/\s+/', $keyword);
        $tokens = array_slice($tokens, 0, 5);

        return $query->where(function (Builder $q) use ($tokens) {
            foreach ($tokens as $t) {
                $t = trim($t);
                if ($t === '') continue;

                $digits = preg_replace('/\D+/', '', $t);

                $q->where(function (Builder $sub) use ($t, $digits) {
                    $sub->where('nama', 'like', "%{$t}%");

                    if ($digits !== '') {
                        $sub->orWhere('nik', 'like', "{$digits}%");
                    }
                });
            }
        });
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->search($filters['keyword'] ?? null)
            ->when(!empty($filters['gender']), fn($q) => $q->where('gender', $filters['gender']))
            ->when(!empty($filters['pendidikan']), fn($q) => $q->where('pendidikan_id', $filters['pendidikan']))
            ->when(!empty($filters['lowongan']), fn($q) => $q->where('lowongan_id', $filters['lowongan']));
    }
}
