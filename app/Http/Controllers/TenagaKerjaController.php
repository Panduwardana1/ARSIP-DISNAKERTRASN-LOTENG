<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Agency;
use App\Models\Kecamatan;
use App\Models\Pendidikan;
use App\Models\Perusahaan;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Requests\TenagaKerjaRequest;


class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = TenagaKerja::query()
            ->with(['desa.kecamatan', 'pendidikan', 'perusahaan', 'agency'])
            ->when($request->filled('q'), function ($qq) use ($request) {
                $term = trim($request->input('q'));
                $qq->where(function ($w) use ($term) {
                    $w->where('nama', 'like', "%{$term}%")
                        ->orWhere('nik', 'like', "%{$term}%");
                });
            });

        $tenagaKerjas = $q->paginate(20)->withQueryString();

        return view('cruds.tenaga_kerja.index', compact('tenagaKerjas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.tenaga_kerja.create', [
            'kecamatans' => Kecamatan::orderBy('nama')->get(['id', 'nama']),
            'desas' => Desa::orderBy('nama')->get(['id', 'nama', 'kecamatan_id']),
            'pendidikans' => Pendidikan::orderBy('nama')->get(['id', 'nama']),
            'perusahaans' => Perusahaan::orderBy('nama')->get(['nama', 'id']),
            'agencies' => Agency::orderBy('nama')->get(['nama', 'id']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenagaKerjaRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                TenagaKerja::create($request->validated());
            });

            return redirect()
                ->route('sirekap.tenaga-kerja.index')
                ->with('success', 'DATA BERHASIL DITAMBAHKAN');
        } catch (QueryException $e) {
            Log::warning("DB error on TenagaKerja@store", [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except(['_token']),
            ]);

            return back()->withInput()->withErrors([
                'db' => $this->mapDbError($e, 'Gagal Menyimpan Data'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Tenaga Kerja@store: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi Kesalahan tak terduga.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->load(['desa.kecamatan', 'pendidikan', 'perusahaan', 'agency']);
        return view('cruds.tenaga_kerja.show', compact('tenagaKerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->load(['desa.kecamatan', 'pendidikan', 'perusahaan', 'agency']);

        return view('cruds.tenaga_kerja.edit', [
            'tenagaKerja' => $tenagaKerja,
            'kecamatans' => Kecamatan::orderBy('nama')->get(['id', 'nama']),
            'desas' => Desa::orderBy('nama')->get(['id', 'nama', 'kecamatan_id']),
            'pendidikans' => Pendidikan::orderBy('nama')->get(['id', 'nama']),
            'perusahaans' => Perusahaan::orderBy('nama')->get(['id', 'nama']),
            'agencies' => Agency::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenagaKerjaRequest $request, TenagaKerja $tenagaKerja)
    {
        try {
            DB::transaction(function () use ($request, $tenagaKerja) {
                $tenagaKerja->update($request->validated());
            });

            return redirect()
                ->route('sirekap.tenaga-kerja.show', $tenagaKerja)
                ->with('success', 'DATA BERHASIL DIPERBAHARUI');
        } catch(QueryException $e) {
            Log::warning('DB error on TenagaKerja@update', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except(['_token']),
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDbError($e, 'Gagal memperbarui data')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on TenagaKerja@update: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan tak terduga saat update data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKerja $tenagaKerja)
    {
        try {
            $tenagaKerja->delete();
            return redirect()
                ->route('sirekap.tenaga-kerja.index')
                ->with('success', 'Data ini telah diarsipkan');
        } catch (QueryException $e) {
            Log::warning('DB error on TenagaKerja@destroy', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $tenagaKerja->id
            ]);

            return back()->withErrors(['db' => $this->mapDbError($e, 'Gagal menghapus data')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on TenagaKerja@destroy: '.$e->getMessage());
            return back()->withErrors(['app' => 'Terjadi kesalahan tak terduga.']);
        }
    }

    private function mapDbError(QueryException $exception, string $fallback): string
    {
        $sqlState = $exception->getCode();
        $errorInfo = $exception->errorInfo[1] ?? null;

        return match (true) {
            $sqlState === '23000' && $errorInfo === 1062 => 'Data sudah terdaftar.',
            $sqlState === '23000' && $errorInfo === 1451 => 'Data tidak dapat dihapus karena masih digunakan.',
            default => $fallback,
        };
    }
}
