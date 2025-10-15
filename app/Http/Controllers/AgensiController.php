<?php

namespace App\Http\Controllers;

use App\Models\Agensi;
use Illuminate\Http\Request;

class AgensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agensiQuery = Agensi::query()->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $agensiQuery->where(function ($query) use ($search) {
                $query->where('nama_agensi', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        $agensi = $agensiQuery->paginate(15)->withQueryString();

        return view('cruds.agensi.index', compact('agensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.agensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_agensi' => ['required', 'string', 'max:150'],
            'lokasi' => ['nullable', 'string', 'max:150'],
        ]);

        Agensi::create($data);

        return redirect()
            ->route('disnakertrans.agensi.index')
            ->with('success', 'Data agensi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agensi $agensi)
    {
        return view('cruds.agensi.show', compact('agensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agensi $agensi)
    {
        return view('cruds.agensi.edit', compact('agensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agensi $agensi)
    {
        $data = $request->validate([
            'nama_agensi' => ['required', 'string', 'max:150'],
            'lokasi' => ['nullable', 'string', 'max:150'],
        ]);

        $agensi->update($data);

        return redirect()
            ->route('disnakertrans.agensi.edit', $agensi)
            ->with('success', 'Data agensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agensi $agensi)
    {
        $agensi->delete();

        return redirect()
            ->route('disnakertrans.agensi.index')
            ->with('success', 'Data agensi berhasil dihapus.');
    }
}
