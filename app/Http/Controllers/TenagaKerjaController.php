<?php

namespace App\Http\Controllers;

use App\Models\TenagaKerja;
use Illuminate\Http\Request;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cruds.cpmi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(TenagaKerja $tenagaKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaKerja $tenagaKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenagaKerja $tenagaKerja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKerja $tenagaKerja)
    {
        //
    }
}
