<?php

namespace App\Http\Controllers;

use App\Imports\TenagaKerjaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ImportController extends Controller
{
    public function import(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx,xls', 'max:5120'],
        ]);

        $import = new TenagaKerjaImport();

        try {
            Excel::import($import, $validated['file']);
        } catch (\Throwable $e) {
            Log::error('Gagal memproses import tenaga kerja.', ['exception' => $e]);

            return Redirect::back()->withErrors([
                'file' => 'File tidak dapat diproses. Pastikan format file sesuai template.',
            ]);
        }

        $problemDetails = collect([
            $import->hasFailures() ? $import->formattedFailures() : null,
            $import->hasErrors() ? $import->formattedErrors() : null,
        ])->filter()->implode(' | ');

        if ($import->successfulRows() === 0) {
            return Redirect::back()->withErrors([
                'file' => $problemDetails !== ''
                    ? $problemDetails
                    : 'Tidak ada baris valid yang berhasil diimpor.',
            ]);
        }

        if ($problemDetails !== '') {
            return Redirect::back()
                ->with(
                    'warning',
                    "Berhasil mengimpor {$import->successfulRows()} baris, tetapi sebagian data gagal diproses."
                )
                ->withErrors(['file' => $problemDetails]);
        }

        return Redirect::back()->with(
            'success',
            "Berhasil mengimpor {$import->successfulRows()} data tenaga kerja."
        );
    }
}
