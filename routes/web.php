<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\NegaraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TenagaKerjaExportController;
use SebastianBergmann\CodeCoverage\Test\TestSize\TestSize;

// Redirect root ke dashboard jika sudah login, jika belum ke halaman login
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('sirekap.dashboard.index')
        : redirect()->route('login');
});

// Rute untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'createAuth'])->name('login.process');
});

// Logout bisa diakses melalui POST (utama) atau GET (fallback) setelah login
Route::match(['post', 'get'], '/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'activitylog'])->group(function () {
    // Semua rute aplikasi di bawah prefix /sirekap
    Route::prefix('/sirekap')->name('sirekap.')->group(function () {
        // Manajemen master data (hanya user dengan izin manage_master)
        Route::middleware('permission:manage_master')->group(function () {
            Route::resource('/tenaga-kerja', TenagaKerjaController::class);
            Route::resource('/desa', DesaController::class);
            Route::resource('/kecamatan', KecamatanController::class);
            Route::resource('/perusahaan', PerusahaanController::class);
            Route::resource('/agency', AgencyController::class);
            Route::resource('/negara', NegaraController::class);
            Route::resource('/pendidikan', PendidikanController::class);
            Route::post('/import', [ImportController::class, 'import'])->name('import');
            Route::get('/export', [TenagaKerjaExportController::class, 'index'])->name('export.index');
            Route::post('/export/download', [TenagaKerjaExportController::class, 'export'])->name('export.download');
        });

        // Dashboard hanya untuk user dengan izin view_dashboard
        Route::middleware('permission:view_dashboard')->group(function () {
            Route::resource('/dashboard', DashboardController::class);
            Route::get('/dashboard/chart/data', [DashboardController::class, 'chartTenagaKerja'])->name('dashboard.chart');
            Route::get('/dashboard/chart/gender', [DashboardController::class, 'chartTenagaKerjaGender'])->name('dashboard.chart.gender');
        });

        Route::resource('/user/profile', UserProfileController::class)
            ->only(['index', 'edit', 'update'])
            ->names('user.profile')
            ->parameters(['profile' => 'user']);
        Route::delete('/user/profile/{user}/photo', [UserProfileController::class, 'destroyPhoto'])
            ->name('user.profile.photo.destroy');

        Route::middleware('permission:manage_users')->group(function () {
            Route::resource('/users', UserController::class)->except(['show']);
        });

        // Log aktivitas aplikasi
        Route::middleware(['permission:view_activity_log', 'role:admin'])->group(function () {
            Route::get('/logs', [LogActivityController::class, 'index'])->name('logs.index');
            Route::delete('/logs/{activity}', [LogActivityController::class, 'destroy'])->name('logs.destroy');
            Route::delete('/logs', [LogActivityController::class, 'clear'])->name('logs.clear');
        });

        Route::middleware('permission:manage_rekomendasi')->group(function () {
            Route::resource('/author', AuthorController::class);
        });

        Route::prefix('/rekomendasi')->name('rekomendasi.')->middleware('permission:manage_rekomendasi|manage_master')->group(function () {
            Route::get('/', [RekomendasiController::class, 'index'])->name('index');
            Route::get('/data', [RekomendasiController::class, 'data'])->name('data');
            Route::match(['get', 'post'], '/preview', [RekomendasiController::class, 'preview'])->name('preview');
            Route::post('/', [RekomendasiController::class, 'store'])->name('store');
            Route::get('/{rekomendasi}/export', [RekomendasiController::class, 'export'])->name('export');
        });
    });
});
