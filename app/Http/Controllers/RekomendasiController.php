<?php

namespace App\Http\Controllers;

use App\Http\Requests\RekomendasiRequest;
use App\Models\ArsipRekomendasi;
use App\Models\Author;
use App\Models\Rekomendasi;
use App\Models\TenagaKerja;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class RekomendasiController extends Controller
{
    public function index(Request $request): View
    {
        $tenagaKerjas = TenagaKerja::query()
            ->with(['perusahaan:id,nama', 'negara:id,nama'])
            ->whereDoesntHave('rekomendasis')
            ->when(
                $request->filled('q'),
                fn ($query) => $query->where(function ($subQuery) use ($request) {
                    $keyword = '%' . $request->input('q') . '%';
                    $subQuery->where('nama', 'like', $keyword)
                        ->orWhere('nik', 'like', $keyword);
                })
            )
            ->orderBy('nama')
            ->paginate(25)
            ->withQueryString();

        return view('rekomendasi.index', compact('tenagaKerjas'));
    }

    public function preview(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('get')) {
            // $oldIds = $request->session()->getOldInput('tenaga_kerja_ids', []);

            if (empty($oldIds)) {
                /** @var ViewErrorBag|null $errorBag */
                $errorBag = $request->session()->get('errors');

                return redirect()
                    ->route('sirekap.rekomendasi.index')
                    ->withErrors(optional($errorBag)->getBag('default') ?? []);
            }

            $request->merge([
                'tenaga_kerja_ids' => $oldIds,
                // 'tanggal' => $request->session()->getOldInput('tanggal'),
            ]);
        }

        $validated = $request->validate([
            'tenaga_kerja_ids' => ['required', 'array', 'min:1'],
            'tenaga_kerja_ids.*' => ['integer', 'distinct', 'exists:tenaga_kerjas,id'],
            'tanggal' => ['nullable', 'date'],
        ]);
// Terjadi kesalahan saat menyimpan rekomendasi. Coba lagi.
        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        $selectedIds = collect($validated['tenaga_kerja_ids'])->unique()->values();

        $tenagaKerjaIds = TenagaKerja::query()
            ->whereIn('id', $selectedIds)
            ->whereDoesntHave('rekomendasis')
            ->pluck('id');

        if ($tenagaKerjaIds->isEmpty()) {
            return redirect()
                ->route('sirekap.rekomendasi.index')
                ->withErrors(['tenaga_kerja_ids' => 'Semua tenaga kerja yang dipilih sudah memiliki rekomendasi.']);
        }

        if ($tenagaKerjaIds->count() !== $selectedIds->count()) {
            session()->flash('warning', 'Sebagian tenaga kerja telah memiliki rekomendasi dan tidak ditampilkan.');
        }

        $tenagaKerjas = TenagaKerja::query()
            ->with(['perusahaan:id,nama', 'negara:id,nama'])
            ->whereIn('id', $tenagaKerjaIds)
            ->orderBy('nama')
            ->get();

        $authors = Author::query()
            ->select('id', 'nama', 'nip', 'jabatan')
            ->orderBy('nama')
            ->get();

        $kode = Rekomendasi::generateKode($tanggal);

        return view('rekomendasi.preview', [
            'tenagaKerjas' => $tenagaKerjas,
            'authors' => $authors,
            'kode' => $kode,
            'tanggal' => $tanggal,
        ]);
    }

    public function store(RekomendasiRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $rekomendasi = DB::transaction(function () use ($validated) {
                $tenagaKerjaIds = collect($validated['tenaga_kerja_ids'])->unique()->values();

                /** @var \Illuminate\Support\Collection<int, int> $availableIds */
                $availableIds = TenagaKerja::query()
                    ->whereIn('id', $tenagaKerjaIds)
                    ->whereDoesntHave('rekomendasis')
                    ->lockForUpdate()
                    ->pluck('id');

                if ($availableIds->count() !== $tenagaKerjaIds->count()) {
                    throw ValidationException::withMessages([
                        'tenaga_kerja_ids' => 'Beberapa tenaga kerja sudah memiliki rekomendasi.',
                    ]);
                }

                $kodeBaru = Rekomendasi::generateKode($validated['tanggal'], true);

                $rekomendasi = Rekomendasi::query()->create([
                    'kode' => $kodeBaru,
                    'tanggal' => $validated['tanggal'],
                    'total' => $availableIds->count(),
                    'author_id' => $validated['author_id'],
                    // 'user_verifikasi_id' => auth()->id(),
                ]);

                $availableIds->chunk(500)->each(
                    fn ($chunk) => $rekomendasi->tenagaKerjas()->attach($chunk->all())
                );

                return $rekomendasi;
            });
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Gagal menyimpan rekomendasi paspor.', [
                'exception' => $exception,
                // 'user_id' => auth()->id(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan saat menyimpan rekomendasi. Coba lagi.']);
        }

        return redirect()
            ->route('sirekap.rekomendasi.index')
            ->with('success', 'Rekomendasi berhasil dibuat. Silakan cetak dokumen melalui tombol Export.')
            ->with('rekomendasi_baru', $rekomendasi->id);
    }

    public function export(Rekomendasi $rekomendasi): BinaryFileResponse
    {
        $rekomendasi->loadMissing([
            'author',
            'userVerifikasi',
            'tenagaKerjas.perusahaan',
            'tenagaKerjas.negara',
        ]);

        $tenagaKerjas = $rekomendasi->tenagaKerjas->sortBy('nama')->values();

        $pdf = Pdf::loadView('rekomendasi.pdf.cover', [
            'rekomendasi' => $rekomendasi,
            'tenagaKerjas' => $tenagaKerjas,
        ])->setPaper('a4', 'portrait');

        $filename = sprintf('rekomendasi-%s.pdf', Str::slug($rekomendasi->kode, '-'));
        $storageDirectory = storage_path('pdf/rekomendasi');

        if (! File::isDirectory($storageDirectory)) {
            File::makeDirectory($storageDirectory, 0755, true);
        }

        $absolutePath = $storageDirectory . DIRECTORY_SEPARATOR . $filename;

        File::put($absolutePath, $pdf->output());

        ArsipRekomendasi::create([
            'rekomendasi_id' => $rekomendasi->id,
            'file_path' => 'storage/pdf/rekomendasi/' . $filename,
            'dicetak_pada' => now(),
            // 'dicetak_oleh' => auth()->id(),
        ]);

        return response()->download($absolutePath, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
