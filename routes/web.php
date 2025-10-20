<?php

use App\Http\Controllers\AgensiPenempatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PerusahaanIndonesiaController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\TenagaKerjaImportController;
use App\Imports\TenagaKerjaImport;
use App\Models\Destinasi;
use Illuminate\Support\Facades\Route;

// ? Redirect /
// Route::get('/', fn() => redirect()->route('auth.login'));

// Route::prefix('/auth')->name('auth.')->group(function () {
//     Route::get('/login', [AuthController::class, 'index'])->name('login');
// });

Route::prefix('/sirekappasmi')->name('sirekap.')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('pekerja/import', [TenagaKerjaImportController::class, 'form'])->name('pekerja.form');
    Route::post('pekerja/import', [TenagaKerjaImportController::class, 'import'])->name('pekerja.import');
    // ? CRUD
    Route::resource('/tenaga-kerja', TenagaKerjaController::class);
    Route::resource('/perusahaan', PerusahaanIndonesiaController::class);
    Route::resource('/agensi', AgensiPenempatanController::class);
    Route::resource('/destinasi', DestinasiController::class);
    Route::resource('/lowongan', LowonganController::class);
});
