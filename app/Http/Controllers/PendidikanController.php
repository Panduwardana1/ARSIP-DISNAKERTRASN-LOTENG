<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PendidikanRequest;

class PendidikanController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->input('q', '');

        $pendidikans = Pendidikan::query()
            ->select('id', 'nama', 'created_at')
            ->withCount('tenagaKerjas')
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('nama', 'like', '%' . $search . '%');
                })
            )
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.pendidikan.index', [
            'pendidikans' => $pendidikans,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('cruds.pendidikan.create');
    }

    public function store(PendidikanRequest $request): RedirectResponse
    {

        $data = $request->validated();

        try {
            Pendidikan::create($data);

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Data berhasil dibuat');
        } catch (Throwable $t) {
           Log::error('Gagal membuat data', [
            'message' => $t->getMessage(),
            'payload' => $data,
           ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal membuat data baru.']);
        }
    }

    public function show(Pendidikan $pendidikan): View
    {
        $pendidikan->loadCount('tenagaKerjas');

        return view('cruds.pendidikan.show', compact('pendidikan'));
    }

    public function edit(Pendidikan $pendidikan): View
    {
        return view('cruds.pendidikan.edit', compact('pendidikan'));
    }

    public function update(PendidikanRequest $request, Pendidikan $pendidikan): RedirectResponse
    {
        try {
            $pendidikan->update($request->validated());

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Data telah diperbaharui');
        } catch (Throwable $t) {
            report($t);
            Log::error('Gagal memperbaharui data', [
                'message' => $t->getMessage(),
                'pendidikan_id' => $pendidikan->id,
                'payload' => $pendidikan,
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui data ']);
        }
    }

    public function destroy(Pendidikan $pendidikan): RedirectResponse
    {
        try {
            $pendidikan->delete();

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Pendidikan berhasil dihapus.');
        } catch (Throwable $t) {
            report($t);

            return back()
                ->withErrors(['app' => 'Gagal menghapus data pendidikan.']);
        }
    }
}
