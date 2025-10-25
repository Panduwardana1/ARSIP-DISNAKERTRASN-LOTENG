<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rekomendasi;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RekomendasiItem;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ExportRekomendasiRequest;
use App\Http\Requests\PreviewRekomendasiRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class RekomendasiExportController extends Controller
{

    public function index(Request $request)
    {
        $q = $request->get('q');
        $tkis = TenagaKerja::with(['lowongan.perusahaan', 'lowongan.agensi', 'lowongan.destinasi', 'pendidikan'])
            ->when(
                $q,
                fn($query) => $query->where(
                    fn($filter) => $filter
                        ->where('nama', 'like', "%{$q}%")
                        ->orWhere('nik', 'like', "%{$q}%")
                )
            )
            ->latest('id')->paginate(100);

        return view('cruds.rekomendasi.index', compact('tkis', 'q'));
    }

    public function storePreview(PreviewRekomendasiRequest $request)
    {
        $data = $request->validated();
        $ids = $data['ids'];
        $tanggal = $data['tanggal_rekom'] ?? now()->toDateString();

        $tkis = $this->loadTenagaKerjas($ids);
        if ($tkis->count() !== count($ids)) {
            return redirect()->route('rekomendasi.index')->withErrors([
                'ids' => 'Sebagian ID tidak ditemukan atau sudah dihapus.'
            ]);
        }

        $invalid = $tkis->filter(fn($t) => blank($t->nik) || blank($t->nama));
        if ($invalid->isNotEmpty()) {
            return redirect()->route('rekomendasi.index')->withErrors([
                'ids' => 'Terdapat TKI tanpa NIK/Nama: ' . $invalid->pluck('id')->join(', ') . '. lengkapi datanya dulu.'
            ]);
        }

        $request->session()->put('rekomendasi_preview', [
            'ids' => $ids,
            'tanggal_rekom' => $tanggal,
        ]);

        return redirect()->route('rekomendasi.preview');
    }

    public function preview(Request $request)
    {
        $state = $request->session()->get('rekomendasi_preview');
        if (!$state) {
            return redirect()->route('rekomendasi.index')->withErrors([
                'ids' => 'Silakan pilih data CPMI terlebih dahulu sebelum melakukan preview.'
            ]);
        }

        $ids = $state['ids'];
        $tanggal = Carbon::parse($state['tanggal_rekom'] ?? now()->toDateString());

        $tkis = $this->loadTenagaKerjas($ids);
        if ($tkis->count() !== count($ids)) {
            $request->session()->forget('rekomendasi_preview');
            return redirect()->route('rekomendasi.index')->withErrors([
                'ids' => 'Sebagian ID tidak ditemukan atau sudah dihapus.'
            ]);
        }

        $rowsPage = 100;
        $rows = $this->mapTenagaKerjaRows($tkis);
        $pages = $rows->chunk($rowsPage);

        return view('cruds.rekomendasi.preview', [
            'ids' => $ids,
            'count' => $tkis->count(),
            'selectedDate' => $tanggal->format('Y-m-d'),
            'formattedDate' => $tanggal->translatedFormat('d F Y'),
            'pages' => $pages,
        ]);
    }

    protected function loadTenagaKerjas(array $ids)
    {
        return TenagaKerja::query()
            ->with([
                'lowongan:id,nama,perusahaan_id,agensi_id,destinasi_id',
                'lowongan.perusahaan:id,nama',
                'lowongan.agensi:id,nama',
                'lowongan.destinasi:id,nama',
                'pendidikan:id,nama'
            ])
            ->whereIn('id', $ids)
            ->orderBy('nama')
            ->get(['id', 'nama', 'nik', 'gender', 'pendidikan_id', 'alamat_lengkap', 'lowongan_id']);
    }

    protected function mapTenagaKerjaRows($tkis)
    {
        return $tkis->map(function ($tki) {
            $lowongan = $tki->lowongan;

            return [
                'nama' => $tki->nama,
                'nik' => $tki->nik,
                'gender' => $this->genderLabel($tki->gender),
                'pendidikan' => optional($tki->pendidikan)->nama,
                'perusahaan' => optional($lowongan?->perusahaan)->nama,
                'agensi' => optional($lowongan?->agensi)->nama,
                'destinasi' => optional($lowongan?->destinasi)->nama,
                'pekerjaan' => optional($lowongan)->nama,
                'alamat' => $tki->alamat_lengkap,
            ];
        });
    }

    public function redirectExport(Request $request)
    {
        return redirect()
            ->route('rekomendasi.preview')
            ->withErrors(['export' => 'Gunakan tombol "Export PDF" pada halaman preview untuk mengunduh rekomendasi.']);
    }

    private function genderCode(?string $gender): ?string
    {
        return match ($gender) {
            'Laki-laki', 'L' => 'L',
            'Perempuan', 'P' => 'P',
            default => null,
        };
    }

    private function genderLabel(?string $gender): string
    {
        return match ($this->genderCode($gender)) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    public function export(ExportRekomendasiRequest $request)
    {
        $data = $request->validated();
        $tkis = $this->loadTenagaKerjas($data['ids']);

        if ($tkis->count() !== count($data['ids'])) {
            return back()->withErrors(['ids' => 'Sebagian ID tidak ditemukan atau sudah dihapus.']);
        }

        $missingLowongan = $tkis->filter(fn($t) => $t->lowongan === null);
        if ($missingLowongan->isNotEmpty()) {
            return back()->withErrors([
                'ids' => 'Sebagian CPMI belum terhubung ke lowongan sehingga tidak bisa diekspor: ' . $missingLowongan->pluck('id')->join(', ') . '.'
            ]);
        }

        // validasi NIK
        $invalid = $tkis->filter(fn($t) => blank($t->nik) || blank($t->nama));
        if ($invalid->isNotEmpty()) {
            return back()->withErrors([
                'ids' => 'Terdapat CPMI tanpa NIK/nama: ' . $invalid->pluck('id')->join(', ') . '.'
            ]);
        }

        $jumlahLaki = $tkis->filter(fn($t) => $this->genderCode($t->gender) === 'L')->count();
        $jumlahPerempuan = $tkis->filter(fn($t) => $this->genderCode($t->gender) === 'P')->count();
        $perusahaanId = $data['perusahaan_id'] ?? optional($tkis->first()->lowongan)->perusahaan_id;

        $rekom = DB::transaction(function () use ($tkis, $data, $jumlahLaki, $jumlahPerempuan, $perusahaanId, $request) {
            $tanggal = Carbon::parse($data['tanggal_rekom']);
            $tahun = (int)$tanggal->format('Y');

            $sequence = (int)(Rekomendasi::where('tahun', $tahun)->lockForUpdate()->max('sequence') ?? 0) + 1;

            $nomor = sprintf('%03d_REKOM_DISNAKER_%d', $sequence, $tahun);

            $rekom = Rekomendasi::create([
                'sequence'  => $sequence,
                'nomor' => $nomor,
                'tahun' => $tahun,
                'tanggal_rekom' => $tanggal->toDateString(),
                'perusahaan_id' => $perusahaanId,
                'jumlah_laki'   => $jumlahLaki,
                'jumlah_perempuan'  => $jumlahPerempuan,
                'total' => $tkis->count(),
                'dibuat_oleh'   => optional($request->user())->id,
            ]);

            $now = now();
            $payload = $tkis->map(function ($tki) use ($rekom, $now) {
                $low = $tki->lowongan;
                return [
                    'rekomendasi_id'    => $rekom->id,
                    'tenaga_kerja_id'   => $tki->id,
                    'lowongan_id'   => $tki->lowongan_id,
                    'agensi_id'     => $low?->agensi_id,
                    'perusahaan_id' => $low?->perusahaan_id,
                    'destinasi_id'  => $low?->destinasi_id,
                    'pendidikan_id' => $tki->pendidikan_id,
                    'nik'   => $tki->nik,
                    'nama'  => $tki->nama,
                    'gender'    => $this->genderCode($tki->gender),
                    'alamat_lengkap' => $tki->alamat_lengkap,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all();

            // upsert untuk tahan klik ganda
            RekomendasiItem::upsert(
                $payload,
                ['rekomendasi_id', 'tenaga_kerja_id'],
                ['lowongan_id', 'agensi_id', 'perusahaan_id', 'destinasi_id', 'pendidikan_id', 'nik', 'nama', 'gender', 'alamat_lengkap', 'updated_at'],
            );
            return $rekom;
        });

        $items = RekomendasiItem::with(['pendidikan', 'perusahaan', 'agensi', 'destinasi', 'lowongan'])
            ->where('rekomendasi_id', $rekom->id)
            ->orderBy('nama')
            ->get();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages([
                'ids' => 'Data rekomendasi belum tersimpan pada tabel pivot rekomendasi_items.',
            ]);
        }

        $pivotIds = $items->pluck('tenaga_kerja_id')->filter()->unique()->values();
        $missingPivotIds = $tkis->pluck('id')->diff($pivotIds);
        if ($missingPivotIds->isNotEmpty()) {
            throw ValidationException::withMessages([
                'ids' => 'Data rekomendasi untuk CPMI berikut belum tersimpan: ' . $missingPivotIds->join(', '),
            ]);
        }

        $pivotInvalid = $items->first(fn($item) => blank($item->nik) || blank($item->nama));
        if ($pivotInvalid) {
            throw ValidationException::withMessages([
                'ids' => 'Ditemukan entri rekomendasi tanpa NIK atau nama pada tabel pivot. Harap periksa kembali data CPMI.',
            ]);
        }

        $rowPerPage = 100;
        $rows = $items->map(function ($item) {
            $lowongan = $item->lowongan;
            return [
                'nama' => $item->nama,
                'nik' => $item->nik,
                'gender' => $this->genderLabel($item->gender),
                'pendidikan' => optional($item->pendidikan)->kode, // pendidikan
                'perusahaan' => optional($item->perusahaan)->nama ?? optional($lowongan?->perusahaan)->nama,
                'agensi' => optional($item->agensi)->nama ?? optional($lowongan?->agensi)->nama,
                'destinasi' => optional($item->destinasi)->nama ?? optional($lowongan?->destinasi)->nama,
                'pekerjaan' => optional($lowongan)->nama,
                'alamat' => $item->alamat_lengkap,
            ];
        });
        $pages = $rows->chunk($rowPerPage);

        if ($pages->isEmpty()) {
            throw ValidationException::withMessages([
                'ids' => 'Tidak ada data CPMI yang dapat dibentuk menjadi tabel rekomendasi.',
            ]);
        }

        $formattedDate = Carbon::parse($rekom->tanggal_rekom)->translatedFormat('d F Y');

        $pdfSurat = Pdf::loadView('rekomendasi.pdf_surat', [
            'rekom' => $rekom,
            'tanggal' => $formattedDate,
        ])
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 150,
                'defaultFont' => 'Times-Roman',
            ])
            ->output();

        $pdfTabel = Pdf::loadView('rekomendasi.pdf_tabel', [
            'rekom' => $rekom,
            'pages' => $pages,
            'tanggal' => $formattedDate,
        ])
            ->setPaper('a4', 'landscape')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'dpi' => 150,
                'defaultFont' => 'Times-Roman',
            ])
            ->output();

        $merger = new Merger();
        $merger->addRaw($pdfSurat);
        $merger->addRaw($pdfTabel);
        $finalPdf = $merger->merge();

        $sanitizedNomor = (string) Str::of($rekom->nomor)
            ->replaceMatches('/[^A-Za-z0-9_-]+/', '-')
            ->trim('-');

        $filename = 'Rekomendasi_Paspor_' . $sanitizedNomor . '.pdf';
        $storagePath = 'rekomendasi/' . $filename;

        Storage::disk('public')->put($storagePath, $finalPdf);
        $absolutePath = Storage::disk('public')->path($storagePath);

        $request->session()->forget('rekomendasi_preview');

        return response()->download($absolutePath, $filename)->deleteFileAfterSend(true);
    }

    public function previewPdf(Request $request)
    {
        $state = $request->session()->get('rekomendasi_preview');
        if (!$state) {
            return redirect()->route('rekomendasi.index')->withErrors([
                'ids' => 'Silahkan pilih data CPMI telebih dahulu'
            ]);
        }

        $ids = $state['ids'];
        $tanggal = $state['tanggal_rekom'] ?? now()->toDateString();

        $tkis = $this->loadTenagaKerjas($ids);
        if ($tkis->count() !== count($ids)) {
            return redirect()->route('rekomendasi.index')->withErrors([
                'ids' => 'Sebagian ID tidak ditemukan atau sudah dihapus.'
            ]);
        }

        $rowsPage = 100;
        $rows = $this->mapTenagaKerjaRows($tkis);
        $pages = $rows->chunk($rowsPage);
        $jumlahLaki = $tkis->filter(fn($t) => $this->genderCode($t->gender) === 'L')->count();
        $jumlahPerempuan = $tkis->filter(fn($t) => $this->genderCode($t->gender) === 'P')->count();
        $dummyRekom = (object) [
            'nomor' => 'DRAFT',
            'total' => $tkis->count(),
            'jumlah_laki' => $jumlahLaki,
            'jumlah_perempuan' => $jumlahPerempuan,
        ];
        $formattedDate = Carbon::parse($tanggal)->translatedFormat('d F Y');

        $pdf = Pdf::loadView('rekomendasi.pdf', [
            'rekom' => $dummyRekom,
            'pages' => $pages,
            'tanggal' => $formattedDate,
        ])->setPaper('a4')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->stream('Preview_Rekomendasi.pdf');
    }
}
