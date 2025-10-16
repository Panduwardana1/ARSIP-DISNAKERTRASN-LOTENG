<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\TenagaKerjaController;
use Illuminate\Support\Facades\Route;

// ? Redirect /
Route::get('/', fn() => redirect()->route('auth.login'));

//
Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
});

Route::prefix('/sirekappasmi')->name('sirekap.')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
    Route::post('pekerja/import', [TenagaKerjaController::class, 'import'])->name('pekerja.import');
    // ? CRUD
    Route::resource('/cpmi', TenagaKerjaController::class);



});
