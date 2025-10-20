<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Lowongan;
use App\Models\Pendidikan;
use Maatwebsite\Excel\Row;
use App\Models\TenagaKerja;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TenagaKerjaImport implements
    OnEachRow,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts,
    WithChunkReading,
    SkipsOnFailure,
    SkipsOnError
{
    use SkipsFailures, SkipsErrors;

    protected array $pendidikanByNama;
    protected array $pendidikanByKode;
    protected array $lowonganByNama;
    protected string $mode;
    protected bool $dryRun;
    protected int $ok = 0;

    /** Header wajib & alias yang diterima */
    protected array $requiredHeaders = [
        'nama',
        'nik',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'desa',
        'kecamatan',
        'alamat_lengkap',
        'pendidikan',
        'lowongan'
    ];
    protected array $headerAliases = [
        'alamat' => 'alamat_lengkap',
        'tgl_lahir' => 'tanggal_lahir',
    ];

    public function __construct(string $mode = 'upsert', bool $dryRun = false)
    {
        $this->mode   = $mode;
        $this->dryRun = $dryRun;

        // Preload kamus relasi untuk lookup cepat
        $this->pendidikanByNama = Pendidikan::pluck('id', 'nama')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $this->pendidikanByKode = Pendidikan::pluck('id', 'kode')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $this->lowonganByNama   = Lowongan::pluck('id', 'nama')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();
    }

    /** 2.1 Validasi SCHEMA (header) sebelum proses baris */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                // Ambil header baris pertama
                $sheet = $event->reader->getDelegate()->getActiveSheet();
                $firstRow = $sheet->rangeToArray('A1:Z1', null, true, true, true)[1] ?? [];
                $headers  = array_values(array_filter(array_map(fn($v) => $v !== null ? Str::snake(trim($v)) : null, $firstRow)));

                // Aliaskan yang dikenal
                $headers = array_map(function ($h) {
                    return $this->headerAliases[$h] ?? $h;
                }, $headers);

                // Cek header wajib
                $missing = array_diff($this->requiredHeaders, $headers);
                if (!empty($missing)) {
                    // Lempar ValidationException supaya langsung berhenti
                    $failures = [new Failure(1, 'header', ['Header wajib hilang: ' . implode(', ', $missing)], $headers)];
                    throw new \Maatwebsite\Excel\Validators\ValidationException(
                        \Illuminate\Validation\ValidationException::withMessages(['file' => 'Header tidak sesuai']),
                        $failures
                    );
                }
            },
        ];
    }

    /** 2.2 Aturan validasi isi */
    public function rules(): array
    {
        // Rule gender ketat
        $genderList = ['Laki-laki', 'Perempuan', 'L', 'P', 'LAKI-LAKI', 'PEREMPUAN', 'LAKI LAKI'];

        return [
            '*.nama'           => ['required', 'string', 'min:2', 'max:255'],
            '*.nik'            => ['required', 'digits:16'],
            '*.gender'         => ['required', Rule::in($genderList)],
            '*.tempat_lahir'   => ['nullable', 'string', 'max:100'],
            '*.tanggal_lahir'  => ['nullable'],  // diparse manual
            '*.email'          => ['nullable', 'email'],
            '*.desa'           => ['nullable', 'string', 'max:100'],
            '*.kecamatan'      => ['nullable', 'string', 'max:100'],
            '*.alamat_lengkap' => ['nullable', 'string', 'max:255'],

            // Pendidikan & Lowongan: validasi via closure agar sesuai kamus (nama atau kode)
            '*.pendidikan' => [
                'required',
                'string',
                function ($attr, $value, $fail) {
                    $key = Str::upper(trim((string)$value));
                    if (!isset($this->pendidikanByNama[$key]) && !isset($this->pendidikanByKode[$key])) {
                        $fail('Pendidikan tidak dikenali (gunakan nama/kode yang valid).');
                    }
                }
            ],
            '*.lowongan' => [
                'required',
                'string',
                function ($attr, $value, $fail) {
                    $key = Str::upper(trim((string)$value));
                    if (!isset($this->lowonganByNama[$key])) {
                        $fail('Lowongan tidak ditemukan (harus sesuai nama yang ada).');
                    }
                }
            ],
        ];
    }

    /** 2.3 Proses per baris */
    public function onRow(Row $row): void
    {
        $raw = $row->toArray();

        // --- Normalisasi awal
        $data = $this->normalize($raw);

        // --- Mapping relasi setelah normalisasi
        $pendKey   = Str::upper($data['pendidikan'] ?? '');
        $lowKey    = Str::upper($data['lowongan'] ?? '');
        $pendId    = $this->pendidikanByNama[$pendKey] ?? $this->pendidikanByKode[$pendKey] ?? null;
        $lowId     = $this->lowonganByNama[$lowKey] ?? null;

        // Kalau mapping gagal, anggap failure (ini backup jika lolos rules karena header case)
        if (!$data['gender'] || !$pendId || !$lowId) {
            $this->failures()->push(new Failure(
                $row->getIndex(),
                'kolom',
                ['Gender/pendidikan/lowongan tidak valid.'],
                $raw
            ));
            return;
        }

        // Build payload ke DB
        $payload = [
            'nama'            => $data['nama'],
            'nik'             => $data['nik'],
            'gender'          => $data['gender'],
            'tempat_lahir'    => $data['tempat_lahir'] ?? null,
            'tanggal_lahir'   => $data['tanggal_lahir'] ?? null,
            'email'           => $data['email'] ?? null,
            'desa'            => $data['desa'] ?? null,
            'kecamatan'       => $data['kecamatan'] ?? null,
            'alamat_lengkap'  => $data['alamat_lengkap'] ?? null,
            'pendidikan_id'   => $pendId,
            'lowongan_id'     => $lowId,
            'updated_at'      => now(),
        ];

        // Dry-run: jangan simpan, tapi hitung sebagai baris valid
        if ($this->dryRun) {
            $this->ok++;
            return;
        }

        // Mode penyimpanan
        if ($this->mode === 'insert') {
            if (!TenagaKerja::where('nik', $data['nik'])->exists()) {
                $payload['created_at'] = now();
                TenagaKerja::insert($payload);
                $this->ok++;
            } else {
                // kalau insert-only, yang duplikat tidak dihitung sukses
                $this->failures()->push(new Failure(
                    $row->getIndex(),
                    'nik',
                    ['NIK sudah ada, dilewati.'],
                    $raw
                ));
            }
        } else { // upsert
            TenagaKerja::updateOrCreate(['nik' => $data['nik']], $payload);
            $this->ok++;
        }
    }

    /** Normalisasi semua field agar konsisten sebelum validasi/DB */
    protected function normalize(array $r): array
    {
        $nama = isset($r['nama']) ? trim((string)$r['nama']) : null;
        $nik  = isset($r['nik']) ? trim((string)$r['nik']) : null;

        // Gender normalisasi
        $gRaw = strtoupper(trim((string)($r['gender'] ?? '')));
        $gender = in_array($gRaw, ['L', 'LAKI-LAKI', 'LAKI LAKI']) ? 'Laki-laki'
            : (in_array($gRaw, ['P', 'PEREMPUAN']) ? 'Perempuan' : null);

        // Tanggal
        $tgl = $this->parseTanggal($r['tanggal_lahir'] ?? null);

        return [
            'nama'            => $nama,
            'nik'             => $nik,
            'gender'          => $gender,
            'tempat_lahir'    => $r['tempat_lahir'] ?? null,
            'tanggal_lahir'   => $tgl,
            'email'           => $r['email'] ?? null,
            'desa'            => $r['desa'] ?? null,
            'kecamatan'       => $r['kecamatan'] ?? null,
            'alamat_lengkap'  => $r['alamat_lengkap'] ?? ($r['alamat'] ?? null), // dukung alias
            'pendidikan'      => $r['pendidikan'] ?? null,
            'lowongan'        => $r['lowongan'] ?? null,
        ];
    }

    public function isEmptyWhen(array $row): bool
    {
        // normalisasi: trim string, biar spasi doang dianggap kosong
        $row = array_map(fn($v) => is_string($v) ? trim($v) : $v, $row);

        $keysWajib = ['nama', 'nik', 'gender', 'pendidikan', 'lowongan'];
        foreach ($keysWajib as $k) {
            if (!empty($row[$k])) {
                return false;
            }
        }
        return true;
    }

    /** Parser tanggal: dukung serial Excel & string umum */
    protected function parseTanggal($value): ?string
    {
        if (blank($value)) return null;
        try {
            if (is_numeric($value)) {
                return Carbon::createFromTimestampUTC(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value)
                )->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    // Performa
    public function chunkSize(): int
    {
        return 1000;
    }
    public function batchSize(): int
    {
        return 1000;
    }

    // Ringkasan
    public function successCount(): int
    {
        return $this->ok;
    }
    public function failureCount(): int
    {
        return count($this->failures());
    }
}
