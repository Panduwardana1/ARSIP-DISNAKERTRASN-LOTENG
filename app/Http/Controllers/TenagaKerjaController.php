<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenagaKerjaRequest;
use App\Http\Requests\UpdateTenagaKerjaRequest;
use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\TenagaKerja;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenagaKerjaQuery = TenagaKerja::with(['pendidikan', 'lowongan.agensi'])
            ->latest();

        if ($keyword = request('keyword')) {
            $tenagaKerjaQuery->where(function ($query) use ($keyword) {
                $query
                    ->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('nik', 'like', '%' . $keyword . '%')
                    ->orWhere('desa', 'like', '%' . $keyword . '%')
                    ->orWhere('kecamatan', 'like', '%' . $keyword . '%');
            });
        }

        $tenagaKerjas = $tenagaKerjaQuery->paginate(15)->withQueryString();

        return view('cruds.cpmi.index', compact('tenagaKerjas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendidikans = Pendidikan::orderBy('level')->orderBy('nama')->get();
        $lowongans = Lowongan::with(['agensi'])->where('is_aktif', 'aktif')->orderBy('nama')->get();

        return view('cruds.cpmi.create', compact('pendidikans', 'lowongans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenagaKerjaRequest $request)
    {
        $tenagaKerja = TenagaKerja::create($request->validated());

        return redirect()
            ->route('sirekap.cpmi.show', $tenagaKerja)
            ->with('success', 'Data tenaga kerja berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->load(['pendidikan', 'lowongan.agensi', 'lowongan.perusahaan']);

        $riwayatRekap = $tenagaKerja->rekaps()
            ->with(['lowongan.agensi'])
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('cruds.cpmi.show', [
            'tenagaKerja' => $tenagaKerja,
            'riwayatRekap' => $riwayatRekap,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->load(['pendidikan', 'lowongan']);

        $pendidikans = Pendidikan::orderBy('level')->orderBy('nama')->get();
        $lowongans = Lowongan::with(['agensi'])
            ->where('is_aktif', 'aktif')
            ->orderBy('nama')
            ->get();

        return view('cruds.cpmi.edit', compact('tenagaKerja', 'pendidikans', 'lowongans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenagaKerjaRequest $request, TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->update($request->validated());

        return redirect()
            ->route('sirekap.cpmi.show', $tenagaKerja)
            ->with('success', 'Data CPMI berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKerja $tenagaKerja)
    {
        if ($tenagaKerja->rekaps()->exists()) {
            return back()->withErrors([
                'destroy' => 'Tidak bisa menghapus karena tenaga kerja sudah memiliki riwayat rekap.',
            ]);
        }

        $tenagaKerja->delete();

        return redirect()
            ->route('sirekap.cpmi.index')
            ->with('success', 'Data tenaga kerja berhasil dihapus.');
    }
}
