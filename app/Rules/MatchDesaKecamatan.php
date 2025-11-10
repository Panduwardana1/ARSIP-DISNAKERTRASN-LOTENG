<?php

namespace App\Rules;

use App\Models\Desa;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class MatchDesaKecamatan implements Rule, DataAwareRule
{
    /**
     * @var array<string, array<string, mixed>>
     */
    private array $data = [];

    /**
     * @var array<string, mixed>|null
     */
    private ?array $currentRow = null;

    public function __construct(
        private readonly string $kecamatanField = 'kecamatan'
    ) {
    }

    /**
     * @param array<string, array<string, mixed>> $data
     */
    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $rowKey = explode('.', (string) $attribute)[0] ?? null;
        $rowData = $this->data[$rowKey] ?? [];
        $this->currentRow = $rowData;

        $desaName = $this->normalize($value);
        if ($desaName === null) {
            return false;
        }

        $kecamatanName = $this->normalize($rowData[$this->kecamatanField] ?? null);

        $query = Desa::query()->whereRaw('LOWER(nama) = ?', [$desaName]);

        if ($kecamatanName !== null) {
            $query->whereHas('kecamatan', fn ($builder) => $builder->whereRaw('LOWER(nama) = ?', [$kecamatanName]));
        }

        return $query->exists();
    }

    public function message(): string
    {
        $kecamatan = $this->normalize($this->currentRow[$this->kecamatanField] ?? null);

        if ($kecamatan !== null) {
            return "Desa :input tidak ditemukan pada kecamatan {$kecamatan}.";
        }

        return 'Desa :input tidak ditemukan.';
    }

    private function normalize(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : Str::lower($trimmed);
    }
}
