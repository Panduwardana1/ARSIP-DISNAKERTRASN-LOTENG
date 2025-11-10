<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Rekomendasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'tanggal',
        'total',
        'author_id',
        'user_verifikasi_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function userVerifikasi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_verifikasi_id');
    }

    public function tenagaKerjas(): BelongsToMany
    {
        return $this->belongsToMany(TenagaKerja::class, 'rekomendasi_items')
            ->withPivot('id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RekomendasiItem::class);
    }

    public function arsip(): HasMany
    {
        return $this->hasMany(ArsipRekomendasi::class);
    }

    public static function generateKode(mixed $tanggal = null, bool $lockForUpdate = false): string
    {
        $date = $tanggal ? Carbon::parse($tanggal) : now();
        $year = $date->format('Y');

        $query = static::withTrashed()
            ->whereYear('tanggal', $year);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        $latestKode = $query->latest('id')->value('kode');

        $lastSequence = 0;

        if ($latestKode && preg_match('/562\/(\d+)\/LTSA\/' . $year . '/i', $latestKode, $matches)) {
            $lastSequence = (int) $matches[1];
        }

        $nextSequence = str_pad((string) ($lastSequence + 1), 3, '0', STR_PAD_LEFT);

        return "562/{$nextSequence}/LTSA/{$year}";
    }
}
