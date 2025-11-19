<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenagaKerjaRequest;
use App\Models\Agency;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Negara;
use App\Models\Pendidikan;
use App\Models\Perusahaan;
use App\Models\TenagaKerja;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TenagaKerjaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', ''));
        $status = (string) $request->input('status', '');

        $tenagaKerjas = TenagaKerja::query()
            ->select([
                'id',
                'nama',
                'nik',
                'gender',
                'pendidikan_id',
                'perusahaan_id',
                'agency_id',
                'negara_id',
                'created_at',
            ])
            ->with([
                'pendidikan:id,nama,label',
                'perusahaan:id,nama',
                'agency:id,nama,lowongan',
                'negara:id,nama',
            ])
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nik', 'like', '%' . $search . '%');
                })
            )
            ->when(
                $status !== '',
                fn ($query) => $query->where('is_active', $status)
            )
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('cruds.tenaga_kerja.index', [
            'tenagaKerjas' => $tenagaKerjas,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('cruds.tenaga_kerja.create', $this->formSelections());
    }

    public function store(TenagaKerjaRequest $request): RedirectResponse
    {
        try {
            DB::transaction(fn () => TenagaKerja::create($request->validated()));

            return redirect()
                ->route('sirekap.tenaga-kerja.index')
                ->with('success', 'Tenaga kerja berhasil ditambahkan.');
        } catch (Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Gagal menambahkan data tenaga kerja.']);
        }
    }

    public function show(TenagaKerja $tenagaKerja): View
    {
        $tenagaKerja->load([
            'desa.kecamatan',
            'pendidikan',
            'perusahaan',
            'agency',
            'negara',
        ]);

        return view('cruds.tenaga_kerja.show', compact('tenagaKerja'));
    }

    public function edit(TenagaKerja $tenagaKerja): View
    {
        return view('cruds.tenaga_kerja.create', array_merge(
            ['tenagaKerja' => $tenagaKerja],
            $this->formSelections()
        ));
    }

    public function update(TenagaKerjaRequest $request, TenagaKerja $tenagaKerja): RedirectResponse
    {
        try {
            DB::transaction(fn () => $tenagaKerja->update($request->validated()));

            return redirect()
                ->route('sirekap.tenaga-kerja.index')
                ->with('success', 'Tenaga kerja berhasil diperbarui.');
        } catch (Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Gagal memperbarui data tenaga kerja.']);
        }
    }

    public function destroy(TenagaKerja $tenagaKerja): RedirectResponse
    {
        try {
            $tenagaKerja->delete();

            return redirect()
                ->route('sirekap.tenaga-kerja.index')
                ->with('success', 'Tenaga kerja berhasil dihapus.');
        } catch (Throwable $t) {
            report($t);

            return back()->withErrors(['app' => 'Gagal menghapus data tenaga kerja.']);
        }
    }

    /**
     * Kumpulan data referensi untuk form create/update.
     *
     * @return array<string, mixed>
     */
    private function formSelections(): array
    {
        return [
            'perusahaans' => Perusahaan::query()->select('id', 'nama')->orderBy('nama')->get(),
            'kecamatans' => Kecamatan::query()->select('id', 'nama')->orderBy('nama')->get(),
            'desas' => Desa::query()->select('id', 'nama', 'kecamatan_id')->orderBy('nama')->get(),
            'pendidikans' => Pendidikan::query()->select('id', 'nama', 'label')->orderBy('nama')->get(),
            'agencies' => Agency::query()->select('id', 'nama', 'lowongan')->orderBy('nama')->get(),
            'negaras' => Negara::query()->select('id', 'nama')->orderBy('nama')->get(),
            'genders' => TenagaKerja::GENDERS,
        ];
    }
}
