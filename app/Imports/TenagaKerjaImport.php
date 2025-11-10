<?php

namespace App\Imports;

use App\Models\Agency;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\Pendidikan;
use App\Models\Perusahaan;
use App\Models\TenagaKerja;
use App\Rules\MatchDesaKecamatan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class TenagaKerjaImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows,
    SkipsOnFailure,
    SkipsOnError,
    WithBatchInserts,
    WithChunkReading
{
    use SkipsFailures;
    use SkipsErrors {
        onError as private traitOnError;
    }

    private int $successfulRows = 0;

    /** @var array<string, int|null> */
    private array $relationCache = [];

    /** @var array<string, int|null> */
    private array $desaCache = [];

    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * @param array<string, mixed> $row
     */
    public function model(array $row): TenagaKerja
    {
        $this->successfulRows++;

        return new TenagaKerja([
            'nama' => $this->cleanString($row['nama'] ?? ''),
            'nik' => $this->cleanString($row['nik'] ?? ''),
            'gender' => strtoupper($row['gender'] ?? ''),
            'email' => $this->cleanNullableString($row['email'] ?? null),
            'no_telpon' => $this->cleanNullableString($row['no_telpon'] ?? null),
            'tempat_lahir' => $this->cleanString($row['tempat_lahir'] ?? ''),
            'tanggal_lahir' => $this->parseTanggalLahir($row['tanggal_lahir'] ?? null),
            'alamat_lengkap' => $this->cleanString($row['alamat_lengkap'] ?? ''),
            'desa_id' => $this->resolveDesaId($row),
            'kode_pos' => $this->cleanNullableString($row['kode_pos'] ?? null),
            'pendidikan_id' => $this->resolveRelationId(Pendidikan::class, $row['pendidikan'] ?? null),
            'perusahaan_id' => $this->resolveRelationId(Perusahaan::class, $row['perusahaan'] ?? null),
            'agency_id' => $this->resolveRelationId(Agency::class, $row['agency'] ?? null),
            'negara_id' => $this->resolveRelationId(Negara::class, $row['negara'] ?? null),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function prepareForValidation(array $row, int $index): array
    {
        return collect($row)
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->all();
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            '*.nama' => ['required', 'string', 'max:100'],
            '*.nik' => ['required', 'digits:16', 'distinct', 'unique:tenaga_kerjas,nik'],
            '*.gender' => ['required', Rule::in(array_keys(TenagaKerja::GENDERS))],
            '*.email' => ['nullable', 'email', 'max:100', 'distinct', 'unique:tenaga_kerjas,email'],
            '*.no_telpon' => ['nullable', 'string', 'max:20'],
            '*.tempat_lahir' => ['required', 'string', 'max:100'],
            '*.tanggal_lahir' => ['required', 'date'],
            '*.alamat_lengkap' => ['required', 'string'],
            '*.kecamatan' => ['required', 'string', 'max:100', 'exists:kecamatans,nama'],
            '*.desa' => ['required', 'string', 'max:100', new MatchDesaKecamatan()],
            '*.pendidikan' => ['required', 'string', 'max:120', 'exists:pendidikans,nama'],
            '*.perusahaan' => ['required', 'string', 'max:150', 'exists:perusahaans,nama'],
            '*.agency' => ['required', 'string', 'max:150', 'exists:agencies,nama'],
            '*.negara' => ['required', 'string', 'max:120', 'exists:negaras,nama'],
            '*.kode_pos' => ['nullable', 'string', 'max:10'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function customValidationMessages(): array
    {
        return [
            '*.nik.unique' => 'NIK :input sudah terdaftar.',
            '*.nik.distinct' => 'NIK :input duplikat di dalam file.',
            '*.email.unique' => 'Email :input sudah digunakan.',
            '*.email.distinct' => 'Email :input duplikat di dalam file.',
            '*.tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            '*.desa.required' => 'Kolom desa wajib diisi.',
            '*.kecamatan.required' => 'Kolom kecamatan wajib diisi.',
            '*.kecamatan.exists' => 'Kecamatan :input belum terdaftar.',
            '*.pendidikan.exists' => 'Data pendidikan :input belum terdaftar.',
            '*.perusahaan.exists' => 'Perusahaan :input belum terdaftar.',
            '*.agency.exists' => 'Agency :input belum terdaftar.',
            '*.negara.exists' => 'Negara :input belum terdaftar.',
        ];
    }

    public function hasFailures(): bool
    {
        return count($this->failures()) > 0;
    }

    public function hasErrors(): bool
    {
        return count($this->errors()) > 0;
    }

    public function successfulRows(): int
    {
        return $this->successfulRows;
    }

    public function formattedFailures(): string
    {
        if (! $this->hasFailures()) {
            return '';
        }

        return collect($this->failures())
            ->map(function (Failure $failure) {
                $message = implode(', ', $failure->errors());

                return "Baris {$failure->row()}: {$message}";
            })
            ->implode(' | ');
    }

    public function formattedErrors(): string
    {
        if (! $this->hasErrors()) {
            return '';
        }

        return collect($this->errors())
            ->map(fn (Throwable $error) => $error->getMessage())
            ->implode(' | ');
    }

    /**
     * @param array<string, mixed> $row
     */
    private function resolveDesaId(array $row): ?int
    {
        $desaName = $this->cleanString($row['desa'] ?? '');
        $kecamatanName = $this->cleanString($row['kecamatan'] ?? '');

        $cacheKey = Str::lower($desaName) . '|' . Str::lower($kecamatanName);

        if (! array_key_exists($cacheKey, $this->desaCache)) {
            $query = Desa::query()
                ->whereRaw('LOWER(nama) = ?', [Str::lower($desaName)]);

            if ($kecamatanName !== '') {
                $query->whereHas(
                    'kecamatan',
                    fn ($builder) => $builder->whereRaw('LOWER(nama) = ?', [Str::lower($kecamatanName)])
                );
            }

            $this->desaCache[$cacheKey] = $query->value('id');
        }

        return $this->desaCache[$cacheKey];
    }

    private function resolveRelationId(string $model, ?string $value): ?int
    {
        $name = $this->cleanNullableString($value);

        if ($name === null) {
            return null;
        }

        $cacheKey = $model . '|' . Str::lower($name);

        if (! array_key_exists($cacheKey, $this->relationCache)) {
            $this->relationCache[$cacheKey] = $model::query()
                ->whereRaw('LOWER(nama) = ?', [Str::lower($name)])
                ->value('id');
        }

        return $this->relationCache[$cacheKey];
    }

    private function parseTanggalLahir(mixed $value): string
    {
        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject((float) $value))->format('Y-m-d');
        }

        return Carbon::parse((string) $value)->format('Y-m-d');
    }

    private function cleanString(?string $value): string
    {
        return trim((string) $value);
    }

    private function cleanNullableString(?string $value): ?string
    {
        $cleaned = $value !== null ? trim((string) $value) : null;

        return $cleaned === '' ? null : $cleaned;
    }

    public function onError(Throwable $error): void
    {
        if ($this->successfulRows > 0) {
            $this->successfulRows--;
        }

        $this->traitOnError($error);
    }
}
