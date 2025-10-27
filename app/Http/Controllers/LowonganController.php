<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLowonganRequest;
use App\Http\Requests\UpdateLowonganRequest;
use App\Models\AgensiPenempatan;
use App\Models\Destinasi;
use App\Models\Lowongan;
use App\Models\PerusahaanIndonesia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $lowongans = Lowongan::query()
            ->with(['agensi', 'perusahaan', 'destinasi'])
            ->filter(['keyword' => $keyword])
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.lowongan.index', [
            'lowongans' => $lowongans,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.lowongan.create', $this->formDependencies());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLowonganRequest $request)
    {
        $data = $request->validated();

        $lowongan = DB::transaction(fn() => Lowongan::create($data));

        return redirect()
            ->route('sirekap.lowongan.show', $lowongan)
            ->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lowongan $lowongan)
    {
        $lowongan->load(['agensi', 'perusahaan', 'destinasi']);

        return view('cruds.lowongan.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        $lowongan->load(['agensi', 'perusahaan', 'destinasi']);

        return view('cruds.lowongan.edit', array_merge(
            ['lowongan' => $lowongan],
            $this->formDependencies()
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLowonganRequest $request, Lowongan $lowongan)
    {
        $data = $request->validated();

        DB::transaction(fn() => $lowongan->update($data));

        return redirect()
            ->route('sirekap.lowongan.show', $lowongan)
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lowongan $lowongan)
    {
        try {
            $lowongan->delete();

            return redirect()
                ->route('sirekap.lowongan.index')
                ->with('success', 'Lowongan berhasil dihapus.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'destroy' => 'Data lowongan tidak dapat dihapus saat ini. Silakan coba lagi.',
            ]);
        }
    }

    private function formDependencies(): array
    {
        return [
            'daftarAgensi' => AgensiPenempatan::query()
                ->orderBy('nama')
                ->pluck('nama', 'id'),
            'daftarPerusahaan' => PerusahaanIndonesia::query()
                ->orderBy('nama')
                ->pluck('nama', 'id'),
            'daftarDestinasi' => Destinasi::query()
                ->orderBy('nama')
                ->pluck('nama', 'id'),
            'statusOptions' => Lowongan::statusOptions(),
        ];
    }
}
