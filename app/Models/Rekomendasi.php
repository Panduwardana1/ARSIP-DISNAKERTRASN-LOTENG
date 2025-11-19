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
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function tenagaKerjas(): BelongsToMany
    {
        return $this->belongsToMany(TenagaKerja::class, 'rekomendasi_items')
            ->withPivot(['perusahaan_id', 'negara_id']);
    }

    public function items(): HasMany
    {
        return $this->hasMany(RekomendasiItem::class);
    }

   public static function generateKode(): string
    {
        $year = now()->year;

        // kunci baris terakhir tahun berjalan supaya aman concurrent
        $last = static::whereYear('tanggal', $year)
            ->where('kode', 'like', "562/%/LTSA/$year")
            ->lockForUpdate()
            ->orderByDesc('id')
            ->first();

        $seq = 1;
        if ($last && preg_match("/^562\/(\d{4})\/LTSA\/{$year}$/", $last->kode, $m)) {
            $seq = (int) $m[1] + 1;
        }

        return sprintf('562/%04d/LTSA/%d', $seq, $year);
    }

}
