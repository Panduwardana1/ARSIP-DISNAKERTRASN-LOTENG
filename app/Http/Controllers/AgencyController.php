<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Models\Agency;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q'));

        $agencies = Agency::query()
            ->with('perusahaan')
            ->withCount('tenagaKerjas')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.agency.index', compact('agencies', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaans = $this->perusahaanOptions();

        return view('cruds.agency.create', compact('perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgencyRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            Agency::create($validated);

            return redirect()
                ->route('sirekap.agency.index')
                ->with('success', 'Agency berhasil ditambahkan.');
        } catch (Throwable $e) {
            Log::warning('Gagal menyimpan data agency.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['db' => 'Terjadi kesalahan saat menyimpan data agency.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency)
    {
        $agency->load([
            'perusahaan',
            'tenagaKerjas' => fn ($query) => $query->orderBy('nama')->with('perusahaan'),
        ])->loadCount('tenagaKerjas');

        return view('cruds.agency.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        $perusahaans = $this->perusahaanOptions();

        return view('cruds.agency.edit', compact('agency', 'perusahaans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgencyRequest $request, Agency $agency): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $agency->update($validated);

            return redirect()
                ->route('sirekap.agency.index')
                ->with('success', 'Agency berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::warning('Gagal memperbarui data agency.', [
                'exception' => $e,
                'agency_id' => $agency->id,
            ]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['db' => 'Terjadi kesalahan saat memperbarui data agency.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency): RedirectResponse
    {
        if ($agency->tenagaKerjas()->exists()) {
            return Redirect::back()->withErrors([
                'destroy' => 'Agency tidak dapat dihapus karena masih digunakan oleh data lain.',
            ]);
        }

        try {
            $agency->delete();

            return redirect()
                ->route('sirekap.agency.index')
                ->with('success', 'Data agency telah dihapus.');
        } catch (Throwable $e) {
            Log::warning('Gagal menghapus data agency.', [
                'exception' => $e,
                'agency_id' => $agency->id,
            ]);

            return Redirect::back()->withErrors([
                'db' => 'Terjadi kesalahan saat menghapus data agency.',
            ]);
        }
    }

    private function perusahaanOptions()
    {
        return Perusahaan::query()
            ->orderBy('nama')
            ->get(['id', 'nama']);
    }
}
