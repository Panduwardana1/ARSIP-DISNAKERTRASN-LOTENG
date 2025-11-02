<?php

namespace App\Http\Controllers;

use App\Http\Requests\PendidikanRequest;
use App\Models\Pendidikan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pendidikans = Pendidikan::query()
            ->withCount('tenagaKerjas')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->input('q'));
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('nama', 'like', "%{$term}%")
                        ->orWhere('level', 'like', "%{$term}%");
                });
            })
            ->orderByRaw($this->levelOrderExpression())
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('cruds.pendidikan.index', [
            'pendidikans' => $pendidikans,
            'levels' => Pendidikan::LEVELS,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.pendidikan.create', [
            'levels' => Pendidikan::LEVELS,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PendidikanRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Pendidikan::create($request->validated());
            });

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Data pendidikan berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::warning('DB error on Pendidikan@store', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except(['_token']),
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDbError($e, 'Gagal menyimpan data pendidikan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Pendidikan@store: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan tak terduga.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendidikan $pendidikan)
    {
        $pendidikan->loadCount('tenagaKerjas');

        return view('cruds.pendidikan.show', [
            'pendidikan' => $pendidikan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendidikan $pendidikan)
    {
        return view('cruds.pendidikan.edit', [
            'pendidikan' => $pendidikan,
            'levels' => Pendidikan::LEVELS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PendidikanRequest $request, Pendidikan $pendidikan)
    {
        try {
            DB::transaction(function () use ($request, $pendidikan) {
                $pendidikan->update($request->validated());
            });

            return redirect()
                ->route('sirekap.pendidikan.show', $pendidikan)
                ->with('success', 'Data pendidikan berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::warning('DB error on Pendidikan@update', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $pendidikan->id,
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDbError($e, 'Gagal memperbarui data pendidikan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Pendidikan@update: '.$e->getMessage(), [
                'id' => $pendidikan->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Terjadi kesalahan tak terduga saat memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendidikan $pendidikan)
    {
        if ($pendidikan->tenagaKerjas()->exists()) {
            return back()->withErrors([
                'destroy' => 'Data pendidikan tidak dapat dihapus karena masih digunakan oleh tenaga kerja.',
            ]);
        }

        try {
            DB::transaction(function () use ($pendidikan) {
                $pendidikan->delete();
            });

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Data pendidikan telah dihapus.');
        } catch (QueryException $e) {
            Log::warning('DB error on Pendidikan@destroy', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $pendidikan->id,
            ]);

            return back()->withErrors([
                'db' => $this->mapDbError($e, 'Gagal menghapus data pendidikan'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Pendidikan@destroy: '.$e->getMessage(), [
                'id' => $pendidikan->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'app' => 'Terjadi kesalahan tak terduga saat menghapus data.',
            ]);
        }
    }

    private function mapDbError(QueryException $exception, string $fallback): string
    {
        $driverCode = $exception->errorInfo[1] ?? null;
        $sqlState = $exception->getCode();

        if ($driverCode === 1062) {
            return 'Nama pendidikan sudah digunakan.';
        }

        if (in_array($driverCode, [1451, 1452], true)) {
            return 'Relasi tidak valid: pastikan data pendidikan tidak terhubung dengan entitas lain.';
        }

        if ($sqlState === '23000') {
            return 'Gagal karena melanggar aturan integritas data.';
        }

        return $fallback.'.';
    }

    private function levelOrderExpression(): string
    {
        $levels = implode("','", Pendidikan::LEVELS);

        return "FIELD(level, '{$levels}')";
    }
}
