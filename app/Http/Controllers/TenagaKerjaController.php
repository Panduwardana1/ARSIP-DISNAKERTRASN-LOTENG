<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTenagaKerjaRequest;
use App\Http\Requests\UpdateTenagaKerjaRequest;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'keyword' => trim((string) $request->input('keyword', '')),
            'gender' => $request->input('gender'),
            'pendidikan' => $request->input('pendidikan'),
            'lowongan' => $request->input('lowongan'),
        ];

        $tenagaKerjas = TenagaKerja::with(['pendidikan', 'lowongan.agensi', 'lowongan.perusahaan'])
            ->filter($filters)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $genderOptions = TenagaKerja::genderOptions();

        $daftarPendidikan = Pendidikan::orderBy('level')
            ->orderBy('nama')
            ->pluck('nama', 'id');

        $daftarLowongan = Lowongan::with('perusahaan')
            ->orderBy('nama')
            ->get()
            ->mapWithKeys(function (Lowongan $lowongan) {
                $label = $lowongan->nama;
                if ($lowongan->perusahaan?->nama) {
                    $label .= ' - ' . $lowongan->perusahaan->nama;
                }

                return [$lowongan->id => $label];
            });

        return view('cruds.cpmi.index', compact(
            'tenagaKerjas',
            'filters',
            'genderOptions',
            'daftarPendidikan',
            'daftarLowongan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.cpmi.create', $this->formDependencies());
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

        return view('cruds.cpmi.edit', array_merge(
            ['tenagaKerja' => $tenagaKerja],
            $this->formDependencies($tenagaKerja)
        ));
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

        try {
            $tenagaKerja->delete();

            return redirect()
                ->route('sirekap.cpmi.index')
                ->with('success', 'Data tenaga kerja berhasil dihapus.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'destroy' => 'Data tenaga kerja tidak dapat dihapus saat ini. Silakan coba lagi.',
            ]);
        }
    }

    private function formDependencies(?TenagaKerja $tenagaKerja = null): array
    {
        $pendidikans = Pendidikan::orderBy('level')
            ->orderBy('nama')
            ->get();

        $lowongans = Lowongan::with(['agensi', 'perusahaan'])
            ->when($tenagaKerja && $tenagaKerja->lowongan, function ($query) use ($tenagaKerja) {
                $query->where(function ($sub) use ($tenagaKerja) {
                    $sub->where('is_aktif', Lowongan::STATUS_AKTIF)
                        ->orWhere('id', $tenagaKerja->lowongan_id);
                });
            }, function ($query) {
                $query->where('is_aktif', Lowongan::STATUS_AKTIF);
            })
            ->orderBy('nama')
            ->get();

        return [
            'pendidikans' => $pendidikans,
            'lowongans' => $lowongans,
        ];
    }
}

