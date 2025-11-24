<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PerusahaanRequest;
use Illuminate\Support\Facades\Redirect;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));

        $perusahaans = Perusahaan::query()
            ->select('id', 'nama', 'pimpinan', 'email', 'alamat', 'gambar', 'created_at')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('cruds.perusahaan.index', compact('perusahaans', 'search'));
    }
    public function create()
    {
        return view('cruds.perusahaan.create');
    }

    public function store(PerusahaanRequest $request) : RedirectResponse {
        $validated = $request->validated();

        try {
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs('perusahaan', $fileName, 'public');

                $validated['gambar'] = $path;
            }

            Perusahaan::create($validated);

            return redirect()->route('sirekap.perusahaan.index')->with('success', 'Data perusahaan berhasil disimpan.');
        } catch(Throwable $e) {
            Log::warning('Gagal menyimpan data perusahaan.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['message' => 'Terjadi kesalahan saat menyimpan data perusahaan.']);
    }

    public function show(Perusahaan $perusahaan) {
        return view('cruds.perusahaan.show', compact('perusahaan'));
    }

    public function edit(Perusahaan $perusahaan) {
        return view('cruds.perusahaan.edit', compact('perusahaan'));
    }

    public function update(PerusahaanRequest $request, Perusahaan $perusahaan) : RedirectResponse
    {
        $validated = $request->validated();

        try {
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs('perusahaan', $fileName, 'public');

                $validated['gambar'] = $path;

                if ($perusahaan->gambar && Storage::disk('public')->exists($perusahaan->gambar)) {
                    Storage::disk('public')->delete($perusahaan->gambar);
                }
            }

            $perusahaan->update($validated);

            return redirect()->route('sirekap.perusahaan.index')->with('success', 'Data perusahaan berhasil diperbarui.');
        } catch (Throwable $e) {
            Log::warning('Gagal memperbarui data perusahaan.', ['exception' => $e]);
        }

        return Redirect::back()
            ->withInput()
            ->withErrors(['message' => 'Terjadi kesalahan saat memperbarui data perusahaan.']);
    }

    public function destroy(Request $request, Perusahaan $perusahaan) : RedirectResponse
    {
        $request->validate([
            'confirm_delete' => ['required', 'accepted'],
        ], [
            'confirm_delete.accepted' => 'Anda harus mengonfirmasi penghapusan data perusahaan.',
        ]);
        if ($perusahaan->tenagaKerja()->exists()) {
            return Redirect::back()
                ->withErrors(['message' => 'Perusahaan masih memiliki data tenaga kerja dan tidak dapat dihapus.']);
        }
        try {
            if ($perusahaan->gambar && Storage::disk('public')->exists($perusahaan->gambar)) {
                Storage::disk('public')->delete($perusahaan->gambar);
            }
            $perusahaan->delete();
            return redirect()->route('sirekap.perusahaan.index')->with('success', 'Data perusahaan berhasil dihapus.');
        } catch (Throwable $e) {
            Log::warning('Gagal menghapus data perusahaan.', ['exception' => $e]);
        }
        return Redirect::back()
            ->withErrors(['message' => 'Terjadi kesalahan saat menghapus data perusahaan.']);
    }
}
