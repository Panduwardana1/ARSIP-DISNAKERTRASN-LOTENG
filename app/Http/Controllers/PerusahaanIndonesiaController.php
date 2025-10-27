<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerusahaanIndonesiaRequest;
use App\Http\Requests\UpdatePerusahaanIndonesiaRequest;
use App\Models\PerusahaanIndonesia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerusahaanIndonesiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rawKeyword = $request->filled('keyword')
            ? $request->input('keyword')
            : $request->input('search', '');

        $keyword = trim((string) $rawKeyword);

        $perusahaans = PerusahaanIndonesia::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('nama', 'like', '%' . $keyword . '%')
                        ->orWhere('nama_pimpinan', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cruds.perusahaan.index', [
            'perusahaans' => $perusahaans,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerusahaanIndonesiaRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('perusahaan', 'public');
        }

        PerusahaanIndonesia::create($data);

        return redirect()
            ->route('sirekap.perusahaan.index')
            ->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerusahaanIndonesia $perusahaan)
    {
        return view('cruds.perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerusahaanIndonesia $perusahaan)
    {
        return view('cruds.perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerusahaanIndonesiaRequest $request, PerusahaanIndonesia $perusahaan)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($perusahaan->gambar && Storage::disk('public')->exists($perusahaan->gambar)) {
                Storage::disk('public')->delete($perusahaan->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('perusahaan', 'public');
        } else {
            $data['gambar'] = $perusahaan->gambar;
        }

        unset($data['icon']);

        $perusahaan->update($data);

        return redirect()
            ->route('sirekap.perusahaan.show', $perusahaan)
            ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerusahaanIndonesia $perusahaan)
    {
        try {
            if ($perusahaan->gambar && Storage::disk('public')->exists($perusahaan->gambar)) {
                Storage::disk('public')->delete($perusahaan->gambar);
            }

            $perusahaan->delete();

            return redirect()
                ->route('sirekap.perusahaan.index')
                ->with('success', 'Perusahaan berhasil dihapus.');
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'destroy' => 'Data perusahaan tidak dapat dihapus saat ini. Silakan coba lagi.',
            ]);
        }
    }
}
