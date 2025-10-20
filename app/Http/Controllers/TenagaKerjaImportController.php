<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\TenagaKerjaImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\ValidationException;

class TenagaKerjaImportController extends Controller
{
    use SkipsFailures;

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required','file','mimes:xlsx,xls','max:20480'], // 20 MB
            'mode' => ['nullable','in:insert,upsert'],
            'dry_run' => ['nullable','boolean'], // preview tanpa simpan
        ]);

        $mode   = $request->input('mode','upsert');
        $dryRun = (bool)$request->input('dry_run', false);

        $import = new TenagaKerjaImport(mode: $mode, dryRun: $dryRun);

        try {
            Excel::import($import, $request->file('file'));
        } catch (ValidationException $e) {
            // Gagal di level schema/heading atau baris
            return back()->withErrors($e->errors())->with('schema_errors', $e->failures());
        }

        // Feedback JUJUR berdasarkan angka yang dihitung import
        $ok  = $import->successCount();
        $bad = $import->failureCount();

        if ($dryRun) {
            return back()->with([
                'info'     => "Preview selesai. Siap diimpor: {$ok} baris • Bermasalah: {$bad}",
                'failures' => $import->failures(),
            ]);
        }

        if ($ok === 0) {
            return back()->with([
                'warning'  => "Tidak ada baris yang disimpan. Cek error/format file.",
                'failures' => $import->failures(),
            ]);
        }

        return back()->with([
            'success'  => "Import selesai. Tersimpan: {$ok} • Gagal: {$bad}",
            'failures' => $import->failures(),
        ]);
    }
}
