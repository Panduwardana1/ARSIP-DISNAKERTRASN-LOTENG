<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agencies = Agency::query()
            ->withCount(['perusahaans', 'tenagaKerjas'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim($request->input('q'));
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('nama', 'like', "%{$term}%")
                        ->orWhere('country', 'like', "%{$term}%")
                        ->orWhere('kota', 'like', "%{$term}%")
                        ->orWhere('lowongan', 'like', "%{$term}%");
                });
            })
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('cruds.agency.index', compact('agencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.agency.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgencyRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Agency::create($request->validated());
            });

            return redirect()
                ->route('sirekap.agency.index')
                ->with('success', 'DATA AGENCY BERHASIL DITAMBAHKAN');
        } catch (QueryException $e) {
            Log::warning('DB error on Agency@store', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except(['_token']),
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDb($e, 'Gagal menyimpan data agency')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Agency@store: '.$e->getMessage(), [
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
    public function show(Agency $agency)
    {
        $agency->load([
            'perusahaans' => fn ($query) => $query->orderBy('nama'),
            'tenagaKerjas' => fn ($query) => $query->orderBy('nama')->with('perusahaan'),
        ])->loadCount(['perusahaans', 'tenagaKerjas']);

        return view('cruds.agency.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        return view('cruds.agency.edit', compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgencyRequest $request, Agency $agency)
    {
        try {
            DB::transaction(function () use ($request, $agency) {
                $agency->update($request->validated());
            });

            return redirect()
                ->route('sirekap.agency.show', $agency)
                ->with('success', 'DATA AGENCY BERHASIL DIPERBARUI');
        } catch (QueryException $e) {
            Log::warning('DB error on Agency@update', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $agency->id,
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDb($e, 'Gagal memperbarui data agency')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Agency@update: '.$e->getMessage(), [
                'id' => $agency->id,
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
    public function destroy(Agency $agency)
    {
        if ($agency->perusahaans()->exists() || $agency->tenagaKerjas()->exists()) {
            return back()->withErrors([
                'destroy' => 'Agency tidak dapat dihapus karena masih digunakan oleh data lain.',
            ]);
        }

        try {
            DB::transaction(function () use ($agency) {
                $agency->delete();
            });

            return redirect()
                ->route('sirekap.agency.index')
                ->with('success', 'Data agency telah dihapus.');
        } catch (QueryException $e) {
            Log::warning('DB error on Agency@destroy', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $agency->id,
            ]);

            return back()->withErrors([
                'db' => $this->mapDb($e, 'Gagal menghapus data agency'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Agency@destroy: '.$e->getMessage(), [
                'id' => $agency->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'app' => 'Terjadi kesalahan tak terduga saat menghapus data.',
            ]);
        }
    }

    protected function mapDb(QueryException $exception, string $fallback): string
    {
        $driverCode = $exception->errorInfo[1] ?? null;
        $sqlState = $exception->getCode();

        if ($driverCode === 1062) {
            return 'Data bentrok: nama agency sudah digunakan.';
        }

        if (in_array($driverCode, [1451, 1452], true)) {
            return 'Relasi tidak valid: agency masih terhubung dengan data lain.';
        }

        if ($sqlState === '23000') {
            return 'Gagal karena melanggar aturan integritas data.';
        }

        return $fallback.'.';
    }
}
