<?php

namespace App\Http\Controllers;

use App\Models\AgensiLowongan;
use App\Models\LowonganPekerjaan;
use App\Models\Negara;
use App\Models\PerusahaanAgensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgensiLowonganController extends Controller
{
    private const STATUS_OPTIONS = ['aktif', 'nonaktif'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AgensiLowongan::query()
            ->with(['lowonganPekerjaan', 'negaraTujuan', 'perusahaanAgensi.perusahaan', 'perusahaanAgensi.agensi'])
            ->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereHas('lowonganPekerjaan', function ($sub) use ($search) {
                    $sub->where('nama_pekerjaan', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('negaraTujuan', function ($sub) use ($search) {
                        $sub->where('nama_negara', 'like', '%' . $search . '%')
                            ->orWhere('kode', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('perusahaanAgensi.perusahaan', function ($sub) use ($search) {
                        $sub->where('nama_perusahaan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('perusahaanAgensi.agensi', function ($sub) use ($search) {
                        $sub->where('nama_agensi', 'like', '%' . $search . '%');
                    })
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $agensiLowongan = $query->paginate(15)->withQueryString();

        return view('cruds.agensi_lowongan.index', compact('agensiLowongan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lowongan = LowonganPekerjaan::orderBy('nama_pekerjaan')->pluck('nama_pekerjaan', 'id');
        $negaras = Negara::orderBy('nama_negara')->pluck('nama_negara', 'id');
        $kemitraan = PerusahaanAgensi::with(['perusahaan', 'agensi'])
            ->orderByDesc('tanggal_mulai')
            ->get();
        $statusOptions = self::STATUS_OPTIONS;

        return view('cruds.agensi_lowongan.create', compact('lowongan', 'negaras', 'kemitraan', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lowongan_pekerjaan_id' => ['required', 'exists:lowongan_pekerjaans,id'],
            'negara_id' => ['required', 'exists:negaras,id'],
            'perusahaan_agensi_id' => ['required', 'exists:perusahaan_agensis,id'],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'tanggal_mulai' => ['required', 'date'],
        ]);

        $data['status'] = strtolower($data['status']);

        $this->assertUniqueCombination($data['lowongan_pekerjaan_id'], $data['negara_id'], $data['perusahaan_agensi_id']);

        AgensiLowongan::create($data);

        return redirect()
            ->route('disnakertrans.agensi-lowongan.index')
            ->with('success', 'Data agensi lowongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AgensiLowongan $agensiLowongan)
    {
        $agensiLowongan->loadMissing(['lowonganPekerjaan', 'negaraTujuan', 'perusahaanAgensi.perusahaan', 'perusahaanAgensi.agensi']);

        return view('cruds.agensi_lowongan.show', compact('agensiLowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgensiLowongan $agensiLowongan)
    {
        $agensiLowongan->loadMissing(['lowonganPekerjaan', 'negaraTujuan', 'perusahaanAgensi.perusahaan', 'perusahaanAgensi.agensi']);

        $lowongan = LowonganPekerjaan::orderBy('nama_pekerjaan')->pluck('nama_pekerjaan', 'id');
        $negaras = Negara::orderBy('nama_negara')->pluck('nama_negara', 'id');
        $kemitraan = PerusahaanAgensi::with(['perusahaan', 'agensi'])
            ->orderByDesc('tanggal_mulai')
            ->get();
        $statusOptions = self::STATUS_OPTIONS;

        return view('cruds.agensi_lowongan.edit', compact('agensiLowongan', 'lowongan', 'negaras', 'kemitraan', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AgensiLowongan $agensiLowongan)
    {
        $data = $request->validate([
            'lowongan_pekerjaan_id' => ['required', 'exists:lowongan_pekerjaans,id'],
            'negara_id' => ['required', 'exists:negaras,id'],
            'perusahaan_agensi_id' => ['required', 'exists:perusahaan_agensis,id'],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'tanggal_mulai' => ['required', 'date'],
        ]);

        $data['status'] = strtolower($data['status']);

        $this->assertUniqueCombination(
            $data['lowongan_pekerjaan_id'],
            $data['negara_id'],
            $data['perusahaan_agensi_id'],
            $agensiLowongan->id
        );

        $agensiLowongan->update($data);

        return redirect()
            ->route('disnakertrans.agensi-lowongan.edit', $agensiLowongan)
            ->with('success', 'Data agensi lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgensiLowongan $agensiLowongan)
    {
        $agensiLowongan->delete();

        return redirect()
            ->route('disnakertrans.agensi-lowongan.index')
            ->with('success', 'Data agensi lowongan berhasil dihapus.');
    }

    private function assertUniqueCombination(int $lowonganId, int $negaraId, int $kemitraanId, ?int $ignoreId = null): void
    {
        $rule = Rule::unique('agensi_lowongans')
            ->where(function ($query) use ($lowonganId, $negaraId, $kemitraanId) {
                return $query
                    ->where('lowongan_pekerjaan_id', $lowonganId)
                    ->where('negara_id', $negaraId)
                    ->where('perusahaan_agensi_id', $kemitraanId);
            });

        if ($ignoreId) {
            $rule->ignore($ignoreId);
        }

        validator(
            [
                'lowongan_pekerjaan_id' => $lowonganId,
                'negara_id' => $negaraId,
                'perusahaan_agensi_id' => $kemitraanId,
            ],
            [
                'lowongan_pekerjaan_id' => [$rule],
            ],
            [
                'lowongan_pekerjaan_id.unique' => 'Kombinasi lowongan, negara, dan kemitraan sudah terdaftar.',
            ]
        )->validate();
    }
}
