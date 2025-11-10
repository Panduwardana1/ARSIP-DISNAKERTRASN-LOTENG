<?php

namespace App\Http\Controllers;

use App\Models\Negara;
use Illuminate\Http\Request;
use App\Http\Requests\NegaraRequest;
use Illuminate\Http\RedirectResponse;

class NegaraController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->input('q', '');

        $negara = Negara::query()
            ->select('id', 'nama', 'kode_iso', 'is_active')
            ->when(
                $search !== '',
                fn ($query) => $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('kode_iso', 'like', '%' . $search . '%');
                })
            )
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('cruds.negara.index', [
            'negara' => $negara,
            'search' => $search,
        ]);
    }

    public function create() {
        return view('cruds.negara.create');
    }

    public function store(NegaraRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $validated['is_active'] ??= 'Aktif';

            Negara::create($validated);

            return redirect()->route('sirekap.negara.index')->with('success', 'Berhasil ditambahkan');
        } catch (\Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => $t->getMessage()]);
        }
    }

    public function edit(Negara $negara)
    {
        return view('cruds.negara.edit', compact('negara'));
    }

    public function update(NegaraRequest $request, Negara $negara): RedirectResponse
    {
        $updateData = $request->validated();

        try {
            $negara->update($updateData);

            return redirect()->route('sirekap.negara.index')->with('success', 'Berhasil diperbarui');
        } catch (\Throwable $t) {
            report($t);

            return back()
                ->withInput()
                ->withErrors(['app' => $t->getMessage()]);
        }
    }
}
