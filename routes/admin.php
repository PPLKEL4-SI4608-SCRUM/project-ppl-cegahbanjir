<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WeatherStationController;
use App\Http\Controllers\Admin\RainfallDataController;
use App\Http\Controllers\Admin\FloodPredictionController;
use App\Http\Controllers\Admin\FloodWarningParameterController;
use App\Http\Controllers\Admin\DisasterReportController as AdminDisasterReportController; // Tambahkan controller admin laporan bencana
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Api\RainfallApiController;

// Grup route untuk admin
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Grup route untuk fitur weather management
    Route::prefix('weather')->name('weather.')->group(function () {
        Route::get('rainfall/api-current', [RainfallApiController::class, 'getCurrentRainfall'])
            ->name('rainfall.api-current');

        // Weather Stations
        Route::resource('stations', WeatherStationController::class);

        // Rainfall Data
        Route::resource('rainfall', RainfallDataController::class);

        // Flood Predictions
        Route::resource('predictions', FloodPredictionController::class);

        // Flood Warning Parameters
        Route::resource('parameters', FloodWarningParameterController::class)->except(['destroy']);
    });

    // Laporan Bencana
    Route::get('/laporan-bencana', [AdminDisasterReportController::class, 'index'])->name('disaster-reports.index');
    Route::patch('/laporan-bencana/{id}/accept', [AdminDisasterReportController::class, 'accept'])->name('disaster-reports.accept');
    Route::patch('/laporan-bencana/{id}/reject', [AdminDisasterReportController::class, 'reject'])->name('disaster-reports.reject');
});
