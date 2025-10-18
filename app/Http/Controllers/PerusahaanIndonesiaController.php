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
        $query = PerusahaanIndonesia::query();
        $cari = $request->input('keyword') ?? $request->input('search');

        if ($cari) {
            $query->where(function ($subQuery) use ($cari) {
                $subQuery->where('nama', 'like', '%' . $cari . '%')
                    ->orWhere('nama_pimpinan', 'like', '%' . $cari . '%');
            });
        }

        $perusahaans = $query->latest()->paginate(15)->withQueryString();

        return view('cruds.perusahaan.index', compact('perusahaans', 'cari'));
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
