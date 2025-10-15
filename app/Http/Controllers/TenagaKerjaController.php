<?php

namespace App\Http\Controllers;

use App\Models\TenagaKerja;
use App\Models\Pendidikan;
use App\Models\AgensiLowongan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $query = TenagaKerja::query()
            ->with([
                'pendidikan',
                'agensiLowongan.lowonganPekerjaan',
                'agensiLowongan.perusahaanAgensi.perusahaan',
                'agensiLowongan.perusahaanAgensi.agensi',
                'agensiLowongan.negaraTujuan',
            ])
            ->latest();

        if ($req->filled('search')) {
            $search = trim((string) $req->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nomor_induk', 'like', '%' . $search . '%');
            });
        }

        $tenagaKerja = $query->paginate(15)->withQueryString();

        return view('cruds.tenaga_kerja.index', compact('tenagaKerja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendidikan = Pendidikan::orderBy('nama')->pluck('nama', 'id');
        $agensiLowongan = AgensiLowongan::with([
            'lowonganPekerjaan',
            'perusahaanAgensi.perusahaan',
            'perusahaanAgensi.agensi',
            'negaraTujuan',
        ])
            ->orderByDesc('tanggal_mulai')
            ->get();

        return view('cruds.tenaga_kerja.create', compact('pendidikan', 'agensiLowongan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nomor_induk' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:tenaga_kerjas,nomor_induk'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:150'],
            'tanggal_lahir' => ['nullable', 'date', 'before:tomorrow'],
            'email' => ['nullable', 'email', 'max:150'],
            'desa' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'alamat_lengkap' => ['required', 'string'],
            'pendidikan_id' => ['nullable', 'exists:pendidikans,id'],
            'agensi_lowongan_id' => ['nullable', 'exists:agensi_lowongans,id'],
        ]);

        TenagaKerja::create($data);

        return redirect()
            ->route('disnakertrans.pekerja.index')
            ->with('success', 'Data tenaga kerja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->loadMissing([
            'pendidikan',
            'agensiLowongan.lowonganPekerjaan',
            'agensiLowongan.perusahaanAgensi.perusahaan',
            'agensiLowongan.perusahaanAgensi.agensi',
            'agensiLowongan.negaraTujuan',
        ]);

        return view('cruds.tenaga_kerja.show', compact('tenagaKerja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaKerja $tenagaKerja)
    {
        $pendidikan = Pendidikan::orderBy('nama')->pluck('nama', 'id');
        $agensiLowongan = AgensiLowongan::with([
            'lowonganPekerjaan',
            'perusahaanAgensi.perusahaan',
            'perusahaanAgensi.agensi',
            'negaraTujuan',
        ])
            ->orderByDesc('tanggal_mulai')
            ->get();

        return view('cruds.tenaga_kerja.edit', compact('tenagaKerja', 'pendidikan', 'agensiLowongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenagaKerja $tenagaKerja)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nomor_induk' => [
                'required',
                'string',
                'size:16',
                'regex:/^[0-9]+$/',
                Rule::unique('tenaga_kerjas', 'nomor_induk')->ignore($tenagaKerja->id),
            ],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:150'],
            'tanggal_lahir' => ['nullable', 'date', 'before:tomorrow'],
            'email' => ['nullable', 'email', 'max:150'],
            'desa' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'alamat_lengkap' => ['required', 'string'],
            'pendidikan_id' => ['nullable', 'exists:pendidikans,id'],
            'agensi_lowongan_id' => ['nullable', 'exists:agensi_lowongans,id'],
        ]);

        $tenagaKerja->update($data);

        return redirect()
            ->route('disnakertrans.pekerja.edit', $tenagaKerja)
            ->with('success', 'Data tenaga kerja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->delete();

        return redirect()
            ->route('disnakertrans.pekerja.index')
            ->with('success', 'Data tenaga kerja berhasil dihapus.');
    }

    /**
     * Handle bulk import of Tenaga Kerja data.
     */
    public function import(Request $request)
    {
        // TODO: implement import handler once the specification is ready.
        return back()->with('error', 'Fitur import belum tersedia.');
    }
}
