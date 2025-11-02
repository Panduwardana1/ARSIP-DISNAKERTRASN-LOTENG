<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use App\Http\Requests\KecamatanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $q = Kecamatan::query()
            ->when($request->filled('q'), function ($qq) use ($request) {
                $term = trim($request->input('q'));
                $qq->where(function ($w) use ($term) {
                    $w->where('nama', 'like', "%{$term}%")
                        ->orWhere('kode', 'like', "%{$term}%");
                });
            })
            ->orderBy('nama');

        $kecamatans = $q->paginate(20)->withQueryString();

        return view('cruds.kecamatan.index', compact('kecamatans'));
    }

    public function create()
    {
        return view('cruds.kecamatan.create');
    }

    public function store(KecamatanRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Kecamatan::create($request->validated());
            });

            return redirect()
                ->route('sirekap.kecamatan.index')
                ->with('success', 'Data kecamatan berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::warning('DB error on Kecamatan@store', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except(['_token']),
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDbError($e, 'Gagal menyimpan data kecamatan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Kecamatan@store: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan tak terduga saat menyimpan data.']);
        }
    }

    public function show(Kecamatan $kecamatan)
    {
        return view('cruds.kecamatan.show', compact('kecamatan'));
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('cruds.kecamatan.edit', compact('kecamatan'));
    }

    public function update(KecamatanRequest $request, Kecamatan $kecamatan)
    {
        try {
            DB::transaction(function () use ($request, $kecamatan) {
                $kecamatan->update($request->validated());
            });

            return redirect()
                ->route('sirekap.kecamatan.index')
                ->with('success', 'Data kecamatan berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::warning('DB error on Kecamatan@update', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $kecamatan->id,
                'payload' => $request->except(['_token']),
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDbError($e, 'Gagal memperbarui data kecamatan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Kecamatan@update: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan tak terduga saat memperbarui data.']);
        }
    }

    public function destroy(Kecamatan $kecamatan)
    {
        try {
            $kecamatan->delete();

            return redirect()
                ->route('sirekap.kecamatan.index')
                ->with('success', 'Data kecamatan berhasil dihapus.');
        } catch (QueryException $e) {
            Log::warning('DB error on Kecamatan@destroy', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $kecamatan->id,
            ]);

            return back()
                ->withErrors(['db' => $this->mapDbError($e, 'Gagal menghapus data kecamatan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Kecamatan@destroy: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withErrors(['app' => 'Terjadi kesalahan tak terduga saat menghapus data.']);
        }
    }

    private function mapDbError(QueryException $exception, string $fallback): string
    {
        $sqlState = $exception->getCode();
        $driverCode = $exception->errorInfo[1] ?? null;

        return match (true) {
            $driverCode === 1062 => 'Data bentrok: nama atau kode kecamatan sudah digunakan.',
            $driverCode === 1451 => 'Data tidak dapat dihapus karena masih terkait data lain.',
            $sqlState === '23000' => 'Gagal karena melanggar aturan integritas data.',
            default => $fallback,
        };
    }
}
