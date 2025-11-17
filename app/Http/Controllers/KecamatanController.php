<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\KecamatanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q'));

        $kecamatans = Kecamatan::query()
            ->withCount('desas')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('kode', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.kecamatan.index', compact('kecamatans', 'search'));
    }

    public function create()
    {
        return view('cruds.kecamatan.create');
    }

    public function store(KecamatanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            Kecamatan::create($validated);

            return redirect()
                ->route('sirekap.kecamatan.index')
                ->with('success', 'Data kecamatan berhasil ditambahkan.');
        } catch (Throwable $e) {
            Log::warning('Gagal menyimpan data kecamatan.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['db' => 'Terjadi kesalahan saat menyimpan data kecamatan.']);
    }

    public function edit(Kecamatan $kecamatan)
    {
        return view('cruds.kecamatan.edit', compact('kecamatan'));
    }

    public function update(KecamatanRequest $request, Kecamatan $kecamatan): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $kecamatan->update($validated);

            return redirect()
                ->route('sirekap.kecamatan.index')
                ->with('success', 'Data kecamatan berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::warning('Gagal memperbarui data kecamatan.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['db' => 'Terjadi kesalahan saat memperbarui data kecamatan.']);
    }

    public function destroy(Kecamatan $kecamatan): RedirectResponse
    {
        if ($kecamatan->desas()->exists()) {
            return Redirect::back()
                ->withErrors(['app' => 'Kecamatan masih memiliki data desa dan tidak dapat dihapus.']);
        }

        try {
            $kecamatan->delete();

            return redirect()
                ->route('sirekap.kecamatan.index')
                ->with('success', 'Data kecamatan berhasil dihapus.');
        } catch (Throwable $e) {
            Log::warning('Gagal menghapus data kecamatan.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withErrors(['db' => 'Terjadi kesalahan saat menghapus data kecamatan.']);
    }
}
