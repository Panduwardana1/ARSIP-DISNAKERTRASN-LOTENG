<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgensiPenempatanRequest;
use App\Http\Requests\UpdateAgensiPenempatanRequest;
use App\Models\AgensiPenempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AgensiPenempatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'keyword' => trim((string) $request->input('keyword', '')),
            'status' => $request->input('status'),
        ];

        $agensiPenempatan = AgensiPenempatan::query()
            ->filter($filters)
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.agensi_penempatan.index', [
            'agensiPenempatan' => $agensiPenempatan,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.agensi_penempatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgensiPenempatanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('agensi/logo', 'public');
        }

        $agensi = AgensiPenempatan::create($data);

        return redirect()
            ->route('sirekap.agensi.show', $agensi)
            ->with('success', 'Agensi penempatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AgensiPenempatan $agensi)
    {
        return view('cruds.agensi_penempatan.show', compact('agensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgensiPenempatan $agensi)
    {
        return view('cruds.agensi_penempatan.edit', compact('agensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgensiPenempatanRequest $request, AgensiPenempatan $agensi)
    {
        $data = $request->validated();

        $removeGambar = $request->boolean('remove_gambar');

        if ($request->hasFile('gambar')) {
            if ($agensi->gambar && Storage::disk('public')->exists($agensi->gambar)) {
                Storage::disk('public')->delete($agensi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('agensi/logo', 'public');
        } elseif ($removeGambar && $agensi->gambar) {
            if (Storage::disk('public')->exists($agensi->gambar)) {
                Storage::disk('public')->delete($agensi->gambar);
            }
            $data['gambar'] = null;
        }

        unset($data['remove_gambar']);

        $agensi->update($data);

        return redirect()
            ->route('sirekap.agensi.show', $agensi)
            ->with('success', 'Agensi penempatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgensiPenempatan $agensi)
    {
        try {
            if ($agensi->gambar && Storage::disk('public')->exists($agensi->gambar)) {
                Storage::disk('public')->delete($agensi->gambar);
            }

            $agensi->delete();

            return redirect()
                ->route('sirekap.agensi.index')
                ->with('success', 'Agensi penempatan berhasil dihapus.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'destroy' => 'Data agensi tidak dapat dihapus saat ini. Silakan coba lagi.',
            ]);
        }
    }
}
