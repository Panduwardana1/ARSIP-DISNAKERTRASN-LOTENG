<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Rekomendasi;
use App\Models\TenagaKerja;
use iio\libmergepdf\Merger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Http\Requests\RekomendasiRequest;

class RekomendasiController extends Controller
{
    private const MALE_GENDERS = ['l', 'laki-laki', 'male', 'm'];
    private const FEMALE_GENDERS = ['p', 'perempuan', 'female', 'f'];

    public function index(Request $request)
    {
        $q = TenagaKerja::query()
            ->with(['perusahaan:id,nama', 'negara:id,nama', 'agency:id,nama,lowongan'])
            ->select('id', 'nama', 'nik', 'agency_id', 'gender', 'perusahaan_id', 'negara_id', 'tanggal_lahir')
            ->orderByDesc('created_at');

        if ($s = $request->get('search')) {
            $q->where(fn($w) => $w->where('nama', 'like', "%{$s}%")->orWhere('nik', 'like', "%{$s}%"));
        }

        $tenagaKerjas = $q->paginate(20)->withQueryString();

        return view('cruds.rekomendasi.index', compact('tenagaKerjas'));
    }

    public function preview(Request $request)
    {
        $selectedIds = $this->resolveSelectedIds($request);
        if (empty($selectedIds)) {
            abort(404);
        }

        $tenagaKerjas = TenagaKerja::with(['perusahaan:id,nama', 'negara:id,nama', 'agency:id,nama,lowongan'])
            ->whereIn('id', $selectedIds)
            ->get();

        if ($tenagaKerjas->isEmpty()) {
            abort(404);
        }

        $authors = Author::select('id', 'nama', 'nip', 'jabatan')->orderBy('nama')->get();
        $kodeDefault = DB::transaction(fn() => Rekomendasi::generateKode());

        return response()->view('cruds.rekomendasi.preview', compact('tenagaKerjas', 'authors', 'kodeDefault'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')->header('Pragma', 'no-cache')->header('Expires', '0');
    }

    public function store(RekomendasiRequest $request)
    {
        $userId = $request->user()->id ?? null;
        $ids = array_values(array_unique($request->tenaga_kerja_ids ?: []));

        if (empty($ids)) {
            return back()
                ->withErrors([
                    'tenaga_kerja_ids' => 'Pilih minimal satu tenaga kerja.',
                ])
                ->withInput();
        }

        try {
            $rekomendasi = DB::transaction(function () use ($request, $userId, $ids) {
                $kode = $request->filled('kode') ? (string) $request->input('kode') : Rekomendasi::generateKode();
                $tanggal = optional($request->date('tanggal'))?->toDateString();

                $rek = Rekomendasi::create([
                    'kode' => $kode,
                    'tanggal' => $tanggal ?? now()->toDateString(),
                    'total' => count($ids),
                    'author_id' => (int) $request->author_id,
                    'user_verifikasi_id' => $userId,
                ]);

                $rek->tenagaKerjas()->attach($ids);

                return $rek->load(['author', 'tenagaKerjas.perusahaan', 'tenagaKerjas.negara']);
            });
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan rekomendasi', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
            ]);

            return back()
                ->withErrors(['general' => 'Terjadi kesalahan saat menyimpan rekomendasi. Silakan coba lagi.'])
                ->withInput();
        }

        return $this->buildPdfResponse($rekomendasi);
    }

    public function pdf(Rekomendasi $rekomendasi): Response
    {
        $rekomendasi->load(['author', 'tenagaKerjas.perusahaan', 'tenagaKerjas.negara']);

        return $this->buildPdfResponse($rekomendasi);
    }

    private function buildPdfResponse(Rekomendasi $rekomendasi): Response
    {
        $stats = $this->buildStats($rekomendasi->tenagaKerjas, $rekomendasi->tanggal);

        try {
            $coverPdf = $this->renderPdf(
                'cruds.rekomendasi.pdf.cover',
                [
                    'rekomendasi' => $rekomendasi,
                    'stats' => $stats,
                ],
                'a4',
                'portrait',
            );

            $lampiranPdf = $this->renderPdf(
                'cruds.rekomendasi.pdf.data',
                [
                    'rekomendasi' => $rekomendasi,
                    'stats' => $stats,
                ],
                'a4',
                'landscape',
            );

            $merged = $this->mergePdfs([$coverPdf, $lampiranPdf]);
        } catch (\Throwable $e) {
            Log::error('Gagal membuat PDF rekomendasi', [
                'rekomendasi_id' => $rekomendasi->id,
                'kode' => $rekomendasi->kode,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Gagal membuat PDF rekomendasi.');
        }

        $filename = Str::of($rekomendasi->kode)->replace(['/', '\\', ' '], '-') . '.pdf';

        return response($merged, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    private function buildStats(Collection $tenagaKerjas, $tanggal): array
    {
        $maleCount = $tenagaKerjas->filter(fn($tk) => $this->isGender($tk->gender ?? null, self::MALE_GENDERS))->count();

        $femaleCount = $tenagaKerjas->filter(fn($tk) => $this->isGender($tk->gender ?? null, self::FEMALE_GENDERS))->count();

        $tanggalCarbon = $tanggal instanceof Carbon ? $tanggal : ($tanggal ? Carbon::parse($tanggal) : now());

        return [
            'tanggal' => $tanggalCarbon->translatedFormat('d F Y'),
            'total' => $tenagaKerjas->count(),
            'laki' => $maleCount,
            'perempuan' => $femaleCount,
        ];
    }

    private function renderPdf(string $view, array $data, string $paper, string $orientation): string
    {
        return Pdf::loadView($view, $data)->setPaper($paper, $orientation)->output();
    }

    private function mergePdfs(array $pdfs): string
    {
        $merger = new Merger();
        foreach ($pdfs as $pdf) {
            $merger->addRaw($pdf);
        }

        return $merger->merge();
    }

    private function isGender(?string $value, array $needles): bool
    {
        $normalized = strtolower(trim((string) $value));

        return in_array($normalized, $needles, true);
    }

    private function resolveSelectedIds(Request $request): array
    {
        if ($request->isMethod('get')) {
            return $this->normalizeIds((array) $request->old('tenaga_kerja_ids', []));
        }

        $validated = $request->validate([
            'selected_ids' => ['required', 'array', 'min:1'],
            'selected_ids.*' => ['integer', 'exists:tenaga_kerjas,id'],
        ]);

        return $this->normalizeIds($validated['selected_ids']);
    }

    private function normalizeIds(array $ids): array
    {
        return collect($ids)->map(fn($id) => (int) $id)->filter(fn($id) => $id > 0)->unique()->values()->all();
    }
}
