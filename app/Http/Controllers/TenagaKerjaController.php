<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\TenagaKerja;
use App\Http\Requests\StoreTenagaKerjaRequest;
use App\Http\Requests\UpdateTenagaKerjaRequest;
use App\Http\Requests\Request\Index\TenagaKerjaIndexRequest;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TenagaKerjaIndexRequest $request)
    {
        $filters = $request->filters();
        $tenagaKerjas = TenagaKerja::query()
            ->with([
                'pendidikan:id,nama',
                'lowongan' => fn ($query) => $query
                    ->select('id', 'nama', 'perusahaan_id', 'agensi_id')
                    ->with([
                        'perusahaan:id,nama',
                        'agensi:id,nama',
                    ]),
            ])
            ->filter($filters)
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $pendidikans = Pendidikan::select('id', 'nama')->orderBy('nama')->get();
        $lowongans = Lowongan::select('id', 'nama')->orderBy('nama')->get();

        return view('cruds.tenaga_kerja.index', compact(
            'tenagaKerjas',
            'pendidikans',
            'lowongans',
            'filters'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.tenaga_kerja.create', [
            'pendidikans' => Pendidikan::select('id', 'nama')->orderBy('nama')->get(),
            'lowongans' => Lowongan::with([
                'perusahaan:id,nama',
                'agensi:id,nama',
            ])->orderBy('nama')->get(['id', 'nama', 'perusahaan_id', 'agensi_id']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenagaKerjaRequest $request)
    {
        $data = $request->validated();

        TenagaKerja::create($data);

        return redirect()
            ->route('sirekap.tenaga-kerja.index')
            ->with('success', 'Data baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->load(['pendidikan:id,nama', 'lowongan:id,nama']);
        return view('cruds.tenaga_kerja.show', [
            'tenagaKerja' => $tenagaKerja,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaKerja $tenagaKerja)
    {
        return view('cruds.tenaga_kerja.edit', [
            'tenagaKerja' => $tenagaKerja->load(['pendidikan:id,nama', 'lowongan:id,nama']),
            'pendidikans' => Pendidikan::select('id', 'nama')->orderBy('nama')->get(),
            'lowongans'   => Lowongan::with([
                'perusahaan:id,nama',
                'agensi:id,nama',
            ])->orderBy('nama')->get(['id', 'nama', 'perusahaan_id', 'agensi_id']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenagaKerjaRequest $request, TenagaKerja $tenagaKerja)
    {
        $data = $request->validated();

        $tenagaKerja->update($data);

        return redirect()
            ->route('sirekap.tenaga-kerja.show', $tenagaKerja)
            ->with('success', 'Data tenaga kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->delete();

        return redirect()
            ->route('sirekap.tenaga-kerja.index')
            ->with('success', 'Data tenaga kerja berhasil dihapus.');
    }
}
