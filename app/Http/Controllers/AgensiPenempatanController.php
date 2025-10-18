<?php

namespace App\Http\Controllers;

use App\Models\AgensiPenempatan;
use Illuminate\Http\Request;

class AgensiPenempatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AgensiPenempatan::query();
        $cari = $request->input('keyword') ?? $request->input('seacrch');

        if ($cari) {
            $query->where(function ($subQuery) use ($cari) {
                $subQuery->where('nama', 'like', '%' . $cari . '%');
            });
        }

        $agensiPenempatan = $query->latest()->paginate(10)->withQueryString();
        return view('cruds.agensi_penempatan.index', compact(['agensi' => $agensiPenempatan]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cruds.agensi_penempatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AgensiPenempatan $agensiPenempatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AgensiPenempatan $agensiPenempatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AgensiPenempatan $agensiPenempatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AgensiPenempatan $agensiPenempatan)
    {
        //
    }
}
