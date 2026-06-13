<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/

Route::middleware(['guest:karyawan'])->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/proseslogin', [AuthController::class, 'proseslogin'])
        ->name('proseslogin');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:karyawan'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/dashboard', [DashboardController::class, 'admin']);

    Route::get('/admin/rekap', [DashboardController::class, 'rekap']);
    Route::get('/admin/rekap/exportpdf', [DashboardController::class, 'exportpdfrekap']);

    Route::get('/admin/karyawan', [DashboardController::class, 'karyawan']);
    Route::get('/admin/karyawan/tambah', [DashboardController::class, 'tambahkaryawan']);
    Route::post('/admin/karyawan/store', [DashboardController::class, 'storekaryawan']);
    Route::get('/admin/karyawan/edit/{nik}', [DashboardController::class, 'editkaryawan']);
    Route::post('/admin/karyawan/update/{nik}', [DashboardController::class, 'updatekaryawan']);
    Route::get('/admin/karyawan/delete/{nik}', [DashboardController::class, 'deletekaryawan']);

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/proseslogout', [AuthController::class, 'logout']);

    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/editprofile', [PresensiController::class, 'updateprofile']);

    Route::get('/laporan', [PresensiController::class, 'laporan']);
    Route::get('/laporan/exportpdf', [PresensiController::class, 'exportpdf']);

    Route::get('/calendar', function () {
        return view('presensi.calendar');
    });
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect('/');
});