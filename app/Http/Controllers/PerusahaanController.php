<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerusahaanRequest;
use App\Models\Agency;
use App\Models\Perusahaan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perusahaans = Perusahaan::query()
            ->with('agency')
            ->withCount('tenagaKerja')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim($request->input('q'));
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('nama', 'like', "%{$term}%")
                        ->orWhere('pimpinan', 'like', "%{$term}%");
                });
            })
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('cruds.perusahaan.index', compact('perusahaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $agencies = Agency::orderBy('nama')->get(['id', 'nama']);

        return view('cruds.perusahaan.create', compact('agencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerusahaanRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->validated();
                $data['gambar'] = $request->file('gambar')->store('perusahaan', 'public');

                Perusahaan::create($data);
            });

            return redirect()
                ->route('sirekap.perusahaan.index')
                ->with('success', 'DATA BERHASIL DITAMBAHKAN');
        } catch (QueryException $e) {
            Log::warning('DB error on Perusahaan@store', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'payload' => $request->except(['_token', 'gambar']),
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDb($e, 'Gagal menyimpan data perusahaan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Perusahaan@store: '.$e->getMessage(), [
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
    public function show(Perusahaan $perusahaan)
    {
        $perusahaan->load([
            'agency:id,nama',
            'tenagaKerja' => fn ($query) => $query->orderBy('nama'),
        ])->loadCount('tenagaKerja');

        return view('cruds.perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan)
    {
        $perusahaan->load('agency:id,nama');
        $agencies = Agency::orderBy('nama')->get(['id', 'nama']);

        return view('cruds.perusahaan.edit', compact('perusahaan', 'agencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerusahaanRequest $request, Perusahaan $perusahaan)
    {
        try {
            DB::transaction(function () use ($request, $perusahaan) {
                $data = $request->validated();

                if ($request->hasFile('gambar')) {
                    if ($perusahaan->gambar && Storage::disk('public')->exists($perusahaan->gambar)) {
                        Storage::disk('public')->delete($perusahaan->gambar);
                    }
                    $data['gambar'] = $request->file('gambar')->store('perusahaan', 'public');
                } else {
                    unset($data['gambar']);
                }

                $perusahaan->update($data);
            });

            return redirect()
                ->route('sirekap.perusahaan.show', $perusahaan)
                ->with('success', 'DATA BERHASIL DIPERBARUI');
        } catch (QueryException $e) {
            Log::warning('DB error on Perusahaan@update', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $perusahaan->id,
            ]);

            return back()
                ->withInput()
                ->withErrors(['db' => $this->mapDb($e, 'Gagal memperbarui data perusahaan')]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Perusahaan@update: '.$e->getMessage(), [
                'id' => $perusahaan->id,
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
    public function destroy(Perusahaan $perusahaan)
    {
        try {
            DB::transaction(function () use ($perusahaan) {
                $perusahaan->delete();
            });

            return redirect()
                ->route('sirekap.perusahaan.index')
                ->with('success', 'Data perusahaan telah diarsipkan.');
        } catch (QueryException $e) {
            Log::warning('DB error on Perusahaan@destroy', [
                'sqlState' => $e->getCode(),
                'errorInfo' => $e->errorInfo ?? null,
                'id' => $perusahaan->id,
            ]);

            return back()->withErrors([
                'db' => $this->mapDb($e, 'Gagal menghapus data perusahaan'),
            ]);
        } catch (\Throwable $e) {
            Log::error('Fatal error on Perusahaan@destroy: '.$e->getMessage(), [
                'id' => $perusahaan->id,
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
            return 'Data bentrok: nama perusahaan dalam agency tersebut atau email sudah digunakan.';
        }

        if (in_array($driverCode, [1451, 1452], true)) {
            return 'Relasi tidak valid: pastikan agency yang dipilih tersedia.';
        }

        if ($sqlState === '23000') {
            return 'Gagal karena melanggar aturan integritas data.';
        }

        return $fallback.'.';
    }
}
