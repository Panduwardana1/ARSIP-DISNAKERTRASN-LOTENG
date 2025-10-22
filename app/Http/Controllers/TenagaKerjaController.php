<?php

namespace App\Http\Controllers;

use App\Exports\TenagaKerjaExport;
use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\TenagaKerja;
use App\Http\Requests\StoreTenagaKerjaRequest;
use App\Http\Requests\UpdateTenagaKerjaRequest;
use App\Http\Requests\Request\Index\TenagaKerjaIndexRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
                'lowongan' => fn($query) => $query
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
        $tenagaKerja->load([
            'pendidikan:id,nama',
            'lowongan' => fn($query) => $query
                ->select('id', 'nama', 'perusahaan_id', 'agensi_id', 'destinasi_id')
                ->with([
                    'perusahaan:id,nama',
                    'agensi:id,nama',
                    'destinasi:id,nama',
                ]),
        ]);

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

    public function exportMonthly(Request $request)
    {
        $validated = $request->validate([
            'month' => ['required', 'integer', 'between:1,12'],
            'year'  => ['required', 'integer', 'min:2000', 'max:2100'],
            'agensi_id'     => ['nullable', 'integer', 'exists:agensi_penempatans,id'],
            'perusahaan_id' => ['nullable', 'integer', 'exists:perusahaan_indonesias,id'],
            'destinasi_id'  => ['nullable', 'integer', 'exists:destinasis,id'],
        ]);

        $start = Carbon::createFromDate($validated['year'], $validated['month'], 1)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $filters = [
            'agensi_id'     => $validated['agensi_id']     ?? null,
            'perusahaan_id' => $validated['perusahaan_id'] ?? null,
            'destinasi_id'  => $validated['destinasi_id']  ?? null,
        ];

        $fileName = sprintf('REKAP_CPMI_%04d_%02d.xlsx', $validated['year'], $validated['month']);

        return Excel::download(new TenagaKerjaExport($start, $end, $filters), $fileName);
    }
}
