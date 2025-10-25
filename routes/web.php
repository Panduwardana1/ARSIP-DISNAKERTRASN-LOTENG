<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\AgensiPenempatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekomendasiExportController;
use App\Http\Controllers\TenagaKerjaImportController;
use App\Http\Controllers\PerusahaanIndonesiaController;

// ? Redirect /
// Route::get('/', fn() => redirect()->route('auth.login'));

// Route::prefix('/auth')->name('auth.')->group(function () {
//     Route::get('/login', [AuthController::class, 'index'])->name('login');
// });

Route::prefix('/sirekappasmi')->name('sirekap.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Inport & Export
    Route::post('pekerja/import', [TenagaKerjaImportController::class, 'import'])->name('pekerja.import');
    Route::get('cpmi/export/data', [TenagaKerjaController::class, 'exportMonthly'])->name('cpmi.export');
    // CRUD Data
    Route::resource('/tenaga-kerja', TenagaKerjaController::class);
    Route::resource('/perusahaan', PerusahaanIndonesiaController::class);
    Route::resource('/agensi', AgensiPenempatanController::class);
    Route::resource('/destinasi', DestinasiController::class);
    Route::resource('/lowongan', LowonganController::class);
});

Route::prefix('rekomendasi-paspor')
    ->group(function () {
        Route::get('/cetak', [RekomendasiExportController::class, 'index'])->name('rekomendasi.index');
        Route::post('/preview', [RekomendasiExportController::class, 'storePreview'])->name('rekomendasi.preview.store');
        Route::get('/preview', [RekomendasiExportController::class, 'preview'])->name('rekomendasi.preview');
        Route::get('/export', [RekomendasiExportController::class, 'redirectExport']);
        Route::post('/export', [RekomendasiExportController::class, 'export'])->name('rekomendasi.export');
        Route::get('/rekomendasi/preview-pdf', [RekomendasiExportController::class, 'previewPdf'])->name('rekomendasi.previewPdf');
    });
