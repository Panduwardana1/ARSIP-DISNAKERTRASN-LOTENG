<?php

namespace App\Http\Controllers;

use App\Http\Requests\PendidikanRequest;
use App\Models\Pendidikan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    public function index(Request $request): View
    {
        $search = (string) $request->input('q', '');

        $pendidikans = Pendidikan::query()
            ->select('id', 'nama', 'label', 'created_at')
            ->withCount('tenagaKerjas')
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('nama', 'like', '%' . $search . '%');
                })
            )
            ->orderBy('nama')
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
        try {
            Pendidikan::create($request->validated());

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Pendidikan baru berhasil ditambahkan.');
        } catch (\Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Gagal menambahkan data pendidikan.']);
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
                ->with('success', 'Pendidikan berhasil diperbarui.');
        } catch (\Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => 'Gagal memperbarui data pendidikan.']);
        }
    }

    public function destroy(Pendidikan $pendidikan): RedirectResponse
    {
        try {
            $pendidikan->delete();

            return redirect()
                ->route('sirekap.pendidikan.index')
                ->with('success', 'Pendidikan berhasil dihapus.');
        } catch (\Throwable $t) {
            report($t);

            return back()
                ->withErrors(['app' => 'Gagal menghapus data pendidikan.']);
        }
    }
}
