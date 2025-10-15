<?php

use App\Http\Controllers\AgensiController;
use App\Http\Controllers\AgensiLowonganController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\LowonganPekerjaanController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PerusahaanAgensiController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\TenagaKerjaController;
use Illuminate\Support\Facades\Route;

// ? Redirect /
Route::get('/', fn() => redirect()->route('auth.login'));

//
Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
});

Route::prefix('disnakertrans')->name('disnakertrans.')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::post('pekerja/import', [TenagaKerjaController::class, 'import'])->name('pekerja.import');
    // ? CRUD
    Route::resource('pekerja', TenagaKerjaController::class);
    Route::resource('perusahaan', PerusahaanController::class);
    Route::resource('agensi', AgensiController::class);
    Route::resource('pendidikan', PendidikanController::class);
    Route::resource('perusahaan-agensi', PerusahaanAgensiController::class);
    Route::resource('lowongan-pekerjaan', LowonganPekerjaanController::class);
    Route::resource('agensi-lowongan', AgensiLowonganController::class);
});
