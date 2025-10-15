<?php

namespace App\Http\Controllers;

use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PendidikanController extends Controller
{
    private const LEVEL_OPTIONS = ['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pendidikan::query()->orderBy('level')->orderBy('nama');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('level', 'like', '%' . $search . '%');
            });
        }

        $pendidikan = $query->paginate(15)->withQueryString();

        return view('cruds.pendidikan.index', compact('pendidikan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levels = self::LEVEL_OPTIONS;

        return view('cruds.pendidikan.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:pendidikans,kode'],
            'nama' => ['required', 'string', 'max:100', 'unique:pendidikans,nama'],
            'level' => ['required', Rule::in(self::LEVEL_OPTIONS)],
        ]);

        Pendidikan::create($data);

        return redirect()
            ->route('disnakertrans.pendidikan.index')
            ->with('success', 'Data pendidikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendidikan $pendidikan)
    {
        return view('cruds.pendidikan.show', compact('pendidikan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendidikan $pendidikan)
    {
        $levels = self::LEVEL_OPTIONS;

        return view('cruds.pendidikan.edit', compact('pendidikan', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendidikan $pendidikan)
    {
        $data = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                Rule::unique('pendidikans', 'kode')->ignore($pendidikan->id),
            ],
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('pendidikans', 'nama')->ignore($pendidikan->id),
            ],
            'level' => ['required', Rule::in(self::LEVEL_OPTIONS)],
        ]);

        $pendidikan->update($data);

        return redirect()
            ->route('disnakertrans.pendidikan.edit', $pendidikan)
            ->with('success', 'Data pendidikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendidikan $pendidikan)
    {
        $pendidikan->delete();

        return redirect()
            ->route('disnakertrans.pendidikan.index')
            ->with('success', 'Data pendidikan berhasil dihapus.');
    }
}
