<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Lowongan;
use App\Models\Destinasi;
use App\Models\Pendidikan;
use Maatwebsite\Excel\Row;
use App\Models\TenagaKerja;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\AgensiPenempatan;
use App\Models\PerusahaanIndonesia;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
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
    SkipsOnError,
    SkipsEmptyRows
{
    use SkipsFailures, SkipsErrors;

    protected array $pendidikanByNama;
    protected array $pendidikanByKode;
    protected array $lowonganByNama;
    protected array $lowonganByComposite;
    protected array $agensiByNama;
    protected array $perusahaanByNama;
    protected array $destinasiByNama;
    protected array $destinasiByKode;
    protected string $mode;
    protected bool $dryRun;
    protected int $ok = 0;

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
        'agensi',
        'perusahaan',
        'destinasi',
        'lowongan'
    ];
    protected array $headerAliases = [
        'alamat' => 'alamat_lengkap',
        'tgl_lahir' => 'tanggal_lahir',
        'alamat_lengkap_tki' => 'alamat_lengkap',
        'p3mi' => 'agensi',
        'agensi_penempatan' => 'agensi',
        'perusahaan_indonesia' => 'perusahaan',
        'perusahaan_asal' => 'perusahaan',
        'negara' => 'destinasi',
        'negara_tujuan' => 'destinasi',
        'destinasi_negara' => 'destinasi',
        'tujuan' => 'destinasi',
        'destination' => 'destinasi',
        'kode_destinasi' => 'destinasi',
    ];

    public function __construct(string $mode = 'upsert', bool $dryRun = false)
    {
        $this->mode   = $mode;
        $this->dryRun = $dryRun;

        $this->pendidikanByNama = Pendidikan::pluck('id', 'nama')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $this->pendidikanByKode = Pendidikan::pluck('id', 'kode')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $lowongans = Lowongan::select(['id', 'nama', 'agensi_id', 'perusahaan_id', 'destinasi_id'])->get();
        $this->lowonganByNama = [];
        $this->lowonganByComposite = [];
        foreach ($lowongans as $lowongan) {
            $nameKey = Str::upper(trim((string) $lowongan->nama));
            if ($nameKey === '') {
                continue;
            }
            $this->lowonganByNama[$nameKey][] = $lowongan->id;
            $compositeKey = $this->composeLowonganKey(
                $lowongan->nama,
                $lowongan->agensi_id,
                $lowongan->perusahaan_id,
                $lowongan->destinasi_id
            );
            $this->lowonganByComposite[$compositeKey] = $lowongan->id;
        }

        $this->agensiByNama = AgensiPenempatan::pluck('id', 'nama')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $this->perusahaanByNama = PerusahaanIndonesia::pluck('id', 'nama')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $this->destinasiByNama = Destinasi::pluck('id', 'nama')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();

        $this->destinasiByKode = Destinasi::pluck('id', 'kode')
            ->mapWithKeys(fn($v, $k) => [Str::upper(trim($k)) => $v])->all();
    }

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
            '*.tanggal_lahir'  => ['nullable'],
            '*.email'          => ['nullable', 'email'],
            '*.desa'           => ['nullable', 'string', 'max:100'],
            '*.kecamatan'      => ['nullable', 'string', 'max:100'],
            '*.alamat_lengkap' => ['nullable', 'string', 'max:255'],

            // Pendidikan & Lowongan: validasi via closure agar sesuai kamus (nama atau kode)
            '*.agensi' => [
                'required',
                'string',
                'max:150',
                function ($attr, $value, $fail) {
                    $key = Str::upper(trim((string) $value));
                    if ($key === '' || !isset($this->agensiByNama[$key])) {
                        $fail('Agensi penempatan tidak ditemukan. Pastikan sesuai data master.');
                    }
                },
            ],
            '*.perusahaan' => [
                'required',
                'string',
                'max:150',
                function ($attr, $value, $fail) {
                    $key = Str::upper(trim((string) $value));
                    if ($key === '' || !isset($this->perusahaanByNama[$key])) {
                        $fail('Perusahaan asal tidak ditemukan. Gunakan nama yang terdaftar.');
                    }
                },
            ],
            '*.destinasi' => [
                'required',
                'string',
                'max:150',
                function ($attr, $value, $fail) {
                    $key = Str::upper(trim((string) $value));
                    if (
                        $key === ''
                        || (!isset($this->destinasiByNama[$key]) && !isset($this->destinasiByKode[$key]))
                    ) {
                        $fail('Destinasi tidak ditemukan. Gunakan nama negara atau kode yang valid.');
                    }
                },
            ],
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
                'max:150',
                function ($attr, $value, $fail) {
                    $key = Str::upper(trim((string)$value));
                    if ($key === '' || !array_key_exists($key, $this->lowonganByNama)) {
                        $fail('Lowongan tidak ditemukan. Pastikan nama sesuai data master.');
                    }
                },
            ],
        ];
    }

    /** 2.3 Proses per baris */
    public function onRow(Row $row): void
    {
        $raw = $row->toArray();

        $data = $this->normalize($raw);

        $pendKey = Str::upper($data['pendidikan'] ?? '');
        $pendId  = $this->pendidikanByNama[$pendKey] ?? $this->pendidikanByKode[$pendKey] ?? null;

        $agensiKey      = Str::upper($data['agensi'] ?? '');
        $perusahaanKey  = Str::upper($data['perusahaan'] ?? '');
        $destinasiKey   = Str::upper($data['destinasi'] ?? '');
        $lowonganName   = $data['lowongan'] ?? null;
        $lowonganKey    = Str::upper(trim((string) $lowonganName));

        $agensiId     = $this->agensiByNama[$agensiKey] ?? null;
        $perusahaanId = $this->perusahaanByNama[$perusahaanKey] ?? null;
        $destinasiId  = $this->destinasiByNama[$destinasiKey] ?? $this->destinasiByKode[$destinasiKey] ?? null;

        $errors = [];

        if (!$data['gender']) {
            $errors[] = 'Gender tidak valid.';
        }
        if (!$pendId) {
            $errors[] = 'Pendidikan tidak dikenali.';
        }
        if (!$agensiId) {
            $errors[] = 'Agensi penempatan tidak ditemukan.';
        }
        if (!$perusahaanId) {
            $errors[] = 'Perusahaan asal tidak ditemukan.';
        }
        if (!$destinasiId) {
            $errors[] = 'Destinasi tidak dikenali.';
        }

        $lowonganId = null;
        if ($lowonganKey === '') {
            $errors[] = 'Lowongan wajib diisi.';
        } elseif (!array_key_exists($lowonganKey, $this->lowonganByNama)) {
            $errors[] = 'Lowongan tidak ditemukan di data master.';
        } elseif ($agensiId && $perusahaanId && $destinasiId) {
            $compositeKey = $this->composeLowonganKey($lowonganName, $agensiId, $perusahaanId, $destinasiId);
            $lowonganId = $this->lowonganByComposite[$compositeKey] ?? null;
            if (!$lowonganId) {
                $errors[] = 'Lowongan tidak cocok dengan agensi, perusahaan, dan destinasi yang diberikan.';
            }
        }

        if (!empty($errors)) {
            $this->failures()->push(new Failure(
                $row->getIndex(),
                'kolom',
                array_values(array_unique($errors)),
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
            'lowongan_id'     => $lowonganId,
            'updated_at'      => now(),
        ];

        if ($this->dryRun) {
            $this->ok++;
            return;
        }

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

    protected function composeLowonganKey(?string $nama, ?int $agensiId, ?int $perusahaanId, ?int $destinasiId): string
    {
        $namaKey = Str::upper(trim((string) $nama));

        return implode('|', [
            $namaKey,
            $agensiId ? (string) $agensiId : '0',
            $perusahaanId ? (string) $perusahaanId : '0',
            $destinasiId ? (string) $destinasiId : '0',
        ]);
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

        $alamat = $r['alamat_lengkap'] ?? ($r['alamat'] ?? null);
        $pendidikan = isset($r['pendidikan']) ? trim((string) $r['pendidikan']) : null;
        $lowongan = isset($r['lowongan']) ? trim((string) $r['lowongan']) : null;
        $agensi = $r['agensi'] ?? ($r['p3mi'] ?? ($r['agensi_penempatan'] ?? null));
        $perusahaan = $r['perusahaan'] ?? ($r['perusahaan_indonesia'] ?? null);
        $destinasiRaw = $r['destinasi'] ?? ($r['negara'] ?? ($r['negara_tujuan'] ?? ($r['tujuan'] ?? $r['destination'] ?? null)));

        return [
            'nama'            => $nama,
            'nik'             => $nik,
            'gender'          => $gender,
            'tempat_lahir'    => $r['tempat_lahir'] ?? null,
            'tanggal_lahir'   => $tgl,
            'email'           => $r['email'] ?? null,
            'desa'            => $r['desa'] ?? null,
            'kecamatan'       => $r['kecamatan'] ?? null,
            'alamat_lengkap'  => $alamat !== null ? trim((string) $alamat) : null,
            'pendidikan'      => $pendidikan,
            'agensi'          => $agensi !== null ? trim((string) $agensi) : null,
            'perusahaan'      => $perusahaan !== null ? trim((string) $perusahaan) : null,
            'destinasi'       => $destinasiRaw !== null ? trim((string) $destinasiRaw) : null,
            'lowongan'        => $lowongan,
        ];
    }

    public function isEmptyWhen(array $row): bool
    {
        // normalisasi: trim string, biar spasi doang dianggap kosong
        $row = array_map(fn($v) => is_string($v) ? trim($v) : $v, $row);

        $keysWajib = ['nama', 'nik', 'gender', 'pendidikan', 'lowongan', 'agensi', 'perusahaan', 'destinasi'];
        foreach ($keysWajib as $k) {
            if (!empty($row[$k])) {
                return false;
            }
        }
        return true;
    }

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
