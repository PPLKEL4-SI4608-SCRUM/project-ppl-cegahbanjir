<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\WeatherDashboardController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\User\MapDashboardController;


// ✅ Redirect ke login saat buka root
Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ Dashboard utama
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Cuaca untuk user
Route::get('/cuaca-user', [WeatherDashboardController::class, 'index'])->name('user.weather.dashboard');
Route::get('/map', [MapDashboardController::class, 'index'])->name('user.map');


// ✅ Group route dengan middleware auth
Route::middleware('auth')->group(function () {
    // ✅ Laporan Bencana
    Route::get('/laporan', [DisasterReportController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [DisasterReportController::class, 'store'])->name('laporan.store');
    Route::put('/laporan/{id}', [DisasterReportController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [DisasterReportController::class, 'destroy'])->name('laporan.destroy');

    // ✅ Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Route auth (login, register, etc)
require __DIR__.'/auth.php';
