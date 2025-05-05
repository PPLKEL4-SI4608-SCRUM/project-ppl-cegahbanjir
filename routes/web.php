<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\WeatherDashboardController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RekomendasiController; // ✅ Controller artikel rekomendasi

// ✅ Redirect ke login saat membuka root
Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ Dashboard utama (tampilkan slider artikel rekomendasi)
Route::get('/dashboard', [RekomendasiController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Halaman detail tiap artikel rekomendasi
Route::get('/rekomendasi/{id}', [RekomendasiController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('rekomendasi.show');

// ✅ Halaman cuaca untuk user
Route::get('/cuaca-user', [WeatherDashboardController::class, 'index'])
    ->name('user.weather.dashboard');

// ✅ Semua route di bawah ini hanya bisa diakses user yang sudah login
Route::middleware('auth')->group(function () {
    // ✅ Laporan Bencana
    Route::get('/laporan', [DisasterReportController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [DisasterReportController::class, 'store'])->name('laporan.store');
    Route::put('/laporan/{id}', [DisasterReportController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [DisasterReportController::class, 'destroy'])->name('laporan.destroy');

    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/detail/{id}', [RekomendasiController::class, 'detail'])->name('rekomendasi.show');

    // ✅ Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Route bawaan Laravel (login, register, dll)
require __DIR__.'/auth.php';
