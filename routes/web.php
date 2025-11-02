<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\RekomendasiExportController;
use App\Http\Controllers\TenagaKerjaImportController;
use App\Http\Controllers\PerusahaanIndonesiaController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\Testing;

// ? Redirect /
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::resource('/testing', Testing::class );

Route::prefix('/sirekap')->name('sirekap.')->group(function () {
    // tenaga kerja controller
    Route::resource('/tenaga-kerja', TenagaKerjaController::class);
    // desa controller
    Route::resource('/desa', DesaController::class);
    // kecamatan controller
    Route::resource('/kecamatan', KecamatanController::class);
    // perusahaan controller
    Route::resource('/perusahaan', PerusahaanController::class);
    // agency controller
    Route::resource('/agency', AgencyController::class);
    // pendidikan controller
    Route::resource('/pendidikan', PendidikanController::class);
});

// Route::prefix('rekomendasi-paspor')
//     ->group(function () {
//         Route::get('/cetak', [RekomendasiExportController::class, 'index'])->name('rekomendasi.index');
//         Route::post('/preview', [RekomendasiExportController::class, 'storePreview'])->name('rekomendasi.preview.store');
//         Route::get('/preview', [RekomendasiExportController::class, 'preview'])->name('rekomendasi.preview');
//         Route::get('/export', [RekomendasiExportController::class, 'redirectExport']);
//         Route::post('/export', [RekomendasiExportController::class, 'export'])->name('rekomendasi.export');
//         Route::get('/rekomendasi/preview-pdf', [RekomendasiExportController::class, 'previewPdf'])->name('rekomendasi.previewPdf');
//     });
