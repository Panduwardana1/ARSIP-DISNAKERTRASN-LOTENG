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

        $ok         = $import->successCount();
        $bad        = $import->failureCount();
        $failures   = $import->failures();
        $hasFail    = $bad > 0;
        $hasSuccess = $ok > 0;

        if ($dryRun) {
            $message = "Preview selesai. Valid: {$ok} baris";
            $message .= $hasFail ? " | Bermasalah: {$bad}" : ". Semua baris valid.";

            return back()->with([
                'info'            => $message,
                'failures'        => $failures,
                'import_context'  => true,
            ]);
        }

        if (!$hasSuccess && !$hasFail) {
            return back()->with([
                'warning'         => 'File tidak memuat data yang dapat diproses.',
                'failures'        => $failures,
                'import_context'  => true,
            ]);
        }

        if (!$hasSuccess && $hasFail) {
            return back()->with([
                'error'           => 'Import gagal. Data tidak masuk karena terjadi kesalahan (data tidak sesuai atau NIK sudah ada).',
                'failures'        => $failures,
                'import_context'  => true,
            ]);
        }

        if ($hasSuccess && $hasFail) {
            return back()->with([
                'warning'         => "Import selesai sebagian. Berhasil: {$ok} baris | Gagal: {$bad} baris. Cek detail kesalahan di bawah.",
                'failures'        => $failures,
                'import_context'  => true,
            ]);
        }

        return back()->with([
            'success'         => "Import selesai. Berhasil menyimpan {$ok} baris.",
            'failures'        => $failures,
            'import_context'  => true,
        ]);
    }
}
