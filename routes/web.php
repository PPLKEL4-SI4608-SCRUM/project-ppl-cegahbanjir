<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\WeatherDashboardController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RekomendasiController;
use App\Http\Controllers\User\MapDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rekomendasi/{id}', [RekomendasiController::class, 'detail']) 
        ->name('rekomendasi.show'); 

    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])
        ->name('rekomendasi.index');

    Route::get('/cuaca-user', [WeatherDashboardController::class, 'index'])
        ->name('user.weather.dashboard');

    Route::get('/map', [MapDashboardController::class, 'index'])
        ->name('user.map');
    Route::get('/api/geojson', [MapDashboardController::class, 'geojson']);

    Route::resource('laporan', DisasterReportController::class)->except(['create', 'edit']);

    Route::prefix('weather')->group(function () {
        Route::get('/', [WeatherDashboardController::class, 'index'])->name('weather.index');
        Route::get('/{id}', [WeatherDashboardController::class, 'show'])->name('weather.show');
        Route::post('/{id}', [WeatherDashboardController::class, 'store'])->name('weather.store');
    });

});

require __DIR__.'/auth.php';