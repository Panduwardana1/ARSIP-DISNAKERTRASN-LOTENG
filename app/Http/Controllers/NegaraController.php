<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Negara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\NegaraRequest;
use Illuminate\Http\RedirectResponse;

class NegaraController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->input('q', '');

        $negara = Negara::query()
            ->select('id', 'nama', 'kode_iso')
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
        $data = $request->validated();

        try {
            Negara::create($data);

            return redirect()
                ->route('sirekap.negara.index')
                ->with('success', 'Berhasil ditambahkan');
        } catch (Throwable $t) {
            Log::error('Gagal membuat data baru', [
                'message' => $t->getMessage(),
                'payload' => $data,
            ]);
            report($t);

            return back()
                ->withInput()
                ->withErrors(['error' => $t->getMessage()]);
        }
    }

    public function edit(Negara $negara)
    {
        return view('cruds.negara.edit', compact('negara'));
    }

    public function update(NegaraRequest $request, Negara $negara): RedirectResponse
    {
        $data = $request->validated();

        try {
            $negara->update($data);

            return redirect()->route('sirekap.negara.index')->with('success', 'Berhasil diperbarui');
        } catch (Throwable $t) {
            Log::error('Gagal mengupdate data', [
                'message' => $t->getMessage(),
                'negara_id' => $negara->id,
                'payload' => $negara,
            ]);

            report($t);

            return back()
                ->withInput()
                ->withErrors(['error' => $t->getMessage()]);
        }
    }
}
