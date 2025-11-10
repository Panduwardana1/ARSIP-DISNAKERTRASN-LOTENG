<?php

namespace App\Http\Controllers;

use App\Exports\TenagaKerjaExport;
use App\Http\Requests\TenagaKerjaExportRequest;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TenagaKerjaExportController extends Controller
{
    public function index()
    {
        return view('tenagakerja.export');
    }

    public function export(TenagaKerjaExportRequest $request): BinaryFileResponse
    {
        $filters = collect($request->validated())
            ->reject(fn ($value) => $value === null || $value === '')
            ->toArray();

        $filename = 'export_tenaga_kerja_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new TenagaKerjaExport($filters), $filename);
    }
}
