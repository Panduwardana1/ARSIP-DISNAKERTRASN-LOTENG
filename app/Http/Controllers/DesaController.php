<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use App\Http\Requests\DesaRequest;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = Desa::query()
            ->with('kecamatan')
            ->when($request->filled('q'), function ($qq) use ($request) {
                $term = trim($request->input('q'));
                $qq->where(function ($w) use ($term) {
                    $w->where('nama', 'like', "%{$term}%");
                });
            })
            ->orderBy('nama');

        $desas = $q->paginate(10)->withQueryString();

        return view('cruds.desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.desa.create', [
            'kecamatans' => Kecamatan::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesaRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Desa::create($request->validated());
            });

            return redirect()
                    ->route('sirekap.desa.index')
                    ->with('success', 'Data baru berhasil ditambahkan');
        } catch (QueryException $e) {
            Log::warning("DB error pada Desa@store", [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except('_token'),
            ]);

            return back()->withInput()->withErrors(['db' => $this->mapDbError($e, 'Gagal menyimpan data')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error pada Desa@store: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return back()
                ->withInput()->withErrors(['app' => 'Terjadi Kesalahan tak terduga.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        return view('cruds.desa.edit', [
            'desa' => $desa->load('kecamatan'),
            'kecamatans' => Kecamatan::orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesaRequest $request, Desa $desa)
    {
        try {
            DB::transaction(function () use ($request, $desa) {
                $desa->update($request->validated());
            });

            return redirect()
                ->route('sirekap.desa.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (QueryException $e) {
            Log::warning("DB Error pada Desa@update", [
                'sqlState'  => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id'        => $desa->id,
                'payload'   => $request->except('_token'),
            ]);

            return back()
                    ->withInput()
                    ->withErrors(['db' => $this->mapDbError($e, 'Gagal memperbarui data')]);
        } catch (\Throwable $e) {
            Log::error('Terjadi kesalahan pada Desa@update: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return back()
                    ->withInput()
                    ->withErrors(['app' => 'Terjadi Kesalahan tak terduga.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $desa)
    {

        try {
            $desa->delete();
            return redirect()
                ->route('sirekap.desa.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            Log::warning('DB Error on Desa@destroy',[
                    'sqlState' => $e->getCode(),
                    'errorInfo' => $e->errorInfo ?? null,
                    'id' => $desa->id,]);
            return back()
                ->withInput()
                ->withErrors(['db' => 'Gagal menghapus data']);
        } catch (\Throwable $e) {
            Log::error('Fatal error on desa@destroy: '. $e->getMessage());
        // redirect
            return back()
                    ->withInput()
                    ->withErrors(['app' => 'Terjadi kesalahan tak terduga']);
        }
    }

    // terjemahan pesan error
    private function mapDbError(QueryException $e, string $fallback) : string {
        $sqlState = $e->getCode();
        $driverCode = $e->errorInfo[1] ?? null;

        if($driverCode === 1062 ) {
            return 'Data bentrok: Kombinasi kecamatan, nama, dan tipe sudah digunakan.';
        }

        // 1452: Cannot add or update a child row: a foreign key constraint fails (kecamatan_id tidak valid)
        if ($driverCode === 1452) {
            return 'Relasi tidak valid: Kecamatan yang dipilih tidak ditemukan.';
        }

        // 23000: generic integrity constraint violation
        if ($sqlState === '23000') {
            return 'Gagal karena melanggar aturan integritas data.';
        }

        return $fallback.'.';
    }
}
