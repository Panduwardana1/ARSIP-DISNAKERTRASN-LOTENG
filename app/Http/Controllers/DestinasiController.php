<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDestinasiRequest;
use App\Http\Requests\UpdateDestinasiRequest;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Throwable;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $destinasis = Destinasi::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery
                        ->where('nama', 'like', '%' . $keyword . '%')
                        ->orWhere('kode', 'like', '%' . strtoupper($keyword) . '%');
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.destinasi.index', [
            'destinasis' => $destinasis,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.destinasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinasiRequest $request)
    {
        $data = $request->validated();

        $destinasi = Destinasi::create($data);

        return redirect()
            ->route('sirekap.destinasi.show', $destinasi)
            ->with('success', 'Negara tujuan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destinasi $destinasi)
    {
        return view('cruds.destinasi.show', compact('destinasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destinasi $destinasi)
    {
        return view('cruds.destinasi.edit', compact('destinasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDestinasiRequest $request, Destinasi $destinasi)
    {
        $data = $request->validated();

        $destinasi->update($data);

        return redirect()
            ->route('sirekap.destinasi.show', $destinasi)
            ->with('success', 'Negara tujuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destinasi $destinasi)
    {
        try {
            $destinasi->delete();

            return redirect()
                ->route('sirekap.destinasi.index')
                ->with('success', 'Negara tujuan berhasil dihapus.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'destroy' => 'Data destinasi tidak dapat dihapus saat ini. Silakan coba lagi.',
            ]);
        }
    }
}
