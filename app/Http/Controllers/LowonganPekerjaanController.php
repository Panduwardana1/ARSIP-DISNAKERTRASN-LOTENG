<?php

namespace App\Http\Controllers;

use App\Models\LowonganPekerjaan;
use Illuminate\Http\Request;

class LowonganPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LowonganPekerjaan::query()->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nama_pekerjaan', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        $lowongan = $query->paginate(15)->withQueryString();

        return view('cruds.lowongan_pekerjaan.index', compact('lowongan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.lowongan_pekerjaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pekerjaan' => ['required', 'string', 'max:255'],
            'kontrak_kerja' => ['nullable', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string'],
        ]);

        LowonganPekerjaan::create($data);

        return redirect()
            ->route('disnakertrans.lowongan-pekerjaan.index')
            ->with('success', 'Data lowongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LowonganPekerjaan $lowonganPekerjaan)
    {
        return view('cruds.lowongan_pekerjaan.show', compact('lowonganPekerjaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LowonganPekerjaan $lowonganPekerjaan)
    {
        return view('cruds.lowongan_pekerjaan.edit', compact('lowonganPekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LowonganPekerjaan $lowonganPekerjaan)
    {
        $data = $request->validate([
            'nama_pekerjaan' => ['required', 'string', 'max:255'],
            'kontrak_kerja' => ['nullable', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $lowonganPekerjaan->update($data);

        return redirect()
            ->route('disnakertrans.lowongan-pekerjaan.edit', $lowonganPekerjaan)
            ->with('success', 'Data lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LowonganPekerjaan $lowonganPekerjaan)
    {
        $lowonganPekerjaan->delete();

        return redirect()
            ->route('disnakertrans.lowongan-pekerjaan.index')
            ->with('success', 'Data lowongan berhasil dihapus.');
    }
}
