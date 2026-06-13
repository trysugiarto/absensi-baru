<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::match(['get', 'post'], '/proseslogin', [AuthController::class, 'proseslogin'])
    ->name('proseslogin');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:karyawan'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/admin/dashboard', [DashboardController::class, 'admin']);

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/presensi/create', [PresensiController::class, 'create']);

    Route::post('/presensi/store', [PresensiController::class, 'store']);

    Route::get('/laporan', [PresensiController::class, 'laporan']);

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