<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\TenagaKerjaExportController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\NegaraController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TestingDesignController;
use App\Http\Controllers\UserProfileController;

// ? Redirect /
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::prefix('/sirekap')->name('sirekap.')->group(function () {
    Route::resource('/tenaga-kerja', TenagaKerjaController::class);
    // desa controller
    Route::resource('/desa', DesaController::class);
    // kecamatan controller
    Route::resource('/kecamatan', KecamatanController::class);
    // perusahaan controller
    Route::resource('/perusahaan', PerusahaanController::class);
    // agency controller
    Route::resource('/agency', AgencyController::class);
    // negara controller
    Route::resource('/negara', NegaraController::class);
    // pendidikan controller
    Route::resource('/pendidikan', PendidikanController::class);
    // dashboard controller
    Route::resource('/dashboard', DashboardController::class);
    // profiel controller
    Route::resource('/user/profile', UserProfileController::class);
    // import controller
    Route::post('/import', [ImportController::class, 'import'])->name('import');
    // export controller
    Route::get('/export', [TenagaKerjaExportController::class, 'index'])->name('export.index');
    Route::post('/export/download', [TenagaKerjaExportController::class, 'export'])->name('export.download');

    //! rekomendasi controller
    Route::resource('/author', AuthorController::class);

    Route::prefix('/rekomendasi')->name('rekomendasi.')->group(function () {
        Route::get('/', [RekomendasiController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/preview', [RekomendasiController::class, 'preview'])->name('preview');
        Route::post('/', [RekomendasiController::class, 'store'])->name('store');
        Route::get('/{rekomendasi}/export', [RekomendasiController::class, 'export'])->name('export');
    });
});

Route::resource('/testing', TestingDesignController::class);
