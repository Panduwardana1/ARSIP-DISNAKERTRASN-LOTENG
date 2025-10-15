<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perusahaanQuery = Perusahaan::query()->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $perusahaanQuery->where(function ($query) use ($search) {
                $query->where('nama_perusahaan', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nama_pimpinan', 'like', '%' . $search . '%');
            });
        }

        $perusahaan = $perusahaanQuery->paginate(15)->withQueryString();

        return view('cruds.perusahaan.index', compact('perusahaan'));
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'string', 'email', 'max:120'],
            'nama_pimpinan' => ['nullable', 'string', 'max:120'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ]);

        Perusahaan::create($data);

        return redirect()
            ->route('disnakertrans.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
        return view('cruds.perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan)
    {
        return view('cruds.perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $data = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'string', 'email', 'max:120'],
            'nama_pimpinan' => ['nullable', 'string', 'max:120'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ]);

        $perusahaan->update($data);

        return redirect()
            ->route('disnakertrans.perusahaan.edit', $perusahaan)
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();

        return redirect()
            ->route('disnakertrans.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil dihapus.');
    }
}
