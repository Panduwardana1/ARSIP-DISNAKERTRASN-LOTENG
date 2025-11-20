<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DesaRequest;
use Illuminate\Support\Facades\Redirect;

class DesaController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q'));

        $desas = Desa::query()
            ->with(['kecamatan:id,nama'])
            ->withCount('tenagaKerja')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.desa.index', compact('desas', 'search'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::query()
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        return view('cruds.desa.create', compact('kecamatans'));
    }

    public function store(DesaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            Desa::create($data);

            return redirect()
                ->route('sirekap.desa.index')
                ->with('success', 'Desa baru berhasil ditambahkan.');
        } catch (Throwable $e) {
            Log::warning('Gagal menyimpan data desa.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data desa.']);
    }

    public function edit(Desa $desa)
    {
        $kecamatans = Kecamatan::query()
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        return view('cruds.desa.edit', compact('desa', 'kecamatans'));
    }

    public function update(DesaRequest $request, Desa $desa): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $desa->update($validated);

            return redirect()
                ->route('sirekap.desa.index')
                ->with('success', 'Data desa berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::warning('Gagal memperbarui data desa.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['db' => 'Terjadi kesalahan saat memperbarui data desa.']);
    }

    public function destroy(Desa $desa): RedirectResponse
    {
        if ($desa->tenagaKerja()->exists()) {
            return Redirect::back()
                ->withErrors(['app' => 'Desa masih memiliki data tenaga kerja dan tidak dapat dihapus.']);
        }

        try {
            $desa->delete();

            return redirect()
                ->route('sirekap.desa.index')
                ->with('success', 'Data desa berhasil dihapus.');
        } catch (Throwable $e) {
            Log::warning('Gagal menghapus data desa.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withErrors(['db' => 'Terjadi kesalahan saat menghapus data desa.']);
    }
}
