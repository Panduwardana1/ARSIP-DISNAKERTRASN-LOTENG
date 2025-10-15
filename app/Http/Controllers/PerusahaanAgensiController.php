<?php

namespace App\Http\Controllers;

use App\Models\Agensi;
use App\Models\Perusahaan;
use App\Models\PerusahaanAgensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerusahaanAgensiController extends Controller
{
    private const STATUS_OPTIONS = ['aktif', 'nonaktif'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PerusahaanAgensi::query()
            ->with(['perusahaan', 'agensi'])
            ->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereHas('perusahaan', function ($sub) use ($search) {
                    $sub->where('nama_perusahaan', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('agensi', function ($sub) use ($search) {
                        $sub->where('nama_agensi', 'like', '%' . $search . '%');
                    })
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $kemitraan = $query->paginate(15)->withQueryString();

        return view('cruds.perusahaan_agensi.index', compact('kemitraan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaans = Perusahaan::orderBy('nama_perusahaan')->pluck('nama_perusahaan', 'id');
        $agensis = Agensi::orderBy('nama_agensi')->pluck('nama_agensi', 'id');
        $statusOptions = self::STATUS_OPTIONS;

        return view('cruds.perusahaan_agensi.create', compact('perusahaans', 'agensis', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'perusahaan_id' => [
                'required',
                'exists:perusahaans,id',
                Rule::unique('perusahaan_agensis', 'perusahaan_id')->where(function ($q) use ($request) {
                    return $q->where('agensi_id', $request->input('agensi_id'));
                }),
            ],
            'agensi_id' => ['required', 'exists:agensis,id'],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $data['status'] = strtolower($data['status']);

        PerusahaanAgensi::create($data);

        return redirect()
            ->route('disnakertrans.perusahaan-agensi.index')
            ->with('success', 'Data kemitraan perusahaan-agensi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerusahaanAgensi $perusahaanAgensi)
    {
        $perusahaanAgensi->loadMissing(['perusahaan', 'agensi']);

        return view('cruds.perusahaan_agensi.show', compact('perusahaanAgensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerusahaanAgensi $perusahaanAgensi)
    {
        $perusahaanAgensi->loadMissing(['perusahaan', 'agensi']);

        $perusahaans = Perusahaan::orderBy('nama_perusahaan')->pluck('nama_perusahaan', 'id');
        $agensis = Agensi::orderBy('nama_agensi')->pluck('nama_agensi', 'id');
        $statusOptions = self::STATUS_OPTIONS;

        return view('cruds.perusahaan_agensi.edit', compact('perusahaanAgensi', 'perusahaans', 'agensis', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerusahaanAgensi $perusahaanAgensi)
    {
        $data = $request->validate([
            'perusahaan_id' => [
                'required',
                'exists:perusahaans,id',
                Rule::unique('perusahaan_agensis', 'perusahaan_id')
                    ->where(function ($q) use ($request) {
                        return $q->where('agensi_id', $request->input('agensi_id'));
                    })
                    ->ignore($perusahaanAgensi->id),
            ],
            'agensi_id' => ['required', 'exists:agensis,id'],
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        $data['status'] = strtolower($data['status']);

        $perusahaanAgensi->update($data);

        return redirect()
            ->route('disnakertrans.perusahaan-agensi.edit', $perusahaanAgensi)
            ->with('success', 'Data kemitraan perusahaan-agensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerusahaanAgensi $perusahaanAgensi)
    {
        $perusahaanAgensi->delete();

        return redirect()
            ->route('disnakertrans.perusahaan-agensi.index')
            ->with('success', 'Data kemitraan perusahaan-agensi berhasil dihapus.');
    }

}
