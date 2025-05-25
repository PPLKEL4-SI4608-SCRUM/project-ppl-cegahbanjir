<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WeatherStationController;
use App\Http\Controllers\Admin\RainfallDataController;
use App\Http\Controllers\Admin\FloodPredictionController;
use App\Http\Controllers\Admin\FloodWarningParameterController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\HandleUsersController;
use App\Http\Controllers\Admin\FloodMapController;
use App\Http\Controllers\Admin\DisasterReportStatisticsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\DisasterReportController as AdminDisasterReportController; 
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
        Route::post('rainfall/update-category', [RainfallDataController::class, 'updateCategory'])
            ->name('rainfall.update-category');

        // Flood Predictions
        Route::resource('predictions', FloodPredictionController::class);

        // Flood Warning Parameters
        Route::resource('parameters', FloodWarningParameterController::class)->except(['destroy']);

        // Disaster Reports Statistics
        Route::get('disaster-statistics', [DisasterReportStatisticsController::class, 'index'])->name('disaster-statistics');
         // Notificaiton
         Route::resource('notification', NotificationController::class);
    });

    // ✅ Artikel Rekomendasi
    Route::resource('artikels', ArtikelController::class);

    // ✅ Pengguna
    // Route untuk pengelolaan pengguna
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [HandleUsersController::class, 'index'])->name('index');
        Route::delete('/{user}', [HandleUsersController::class, 'destroy'])->name('destroy');
    });

    // Interactive Map
    Route::resource('flood-maps', FloodMapController::class);
    // Laporan Bencana
    Route::get('/laporan-bencana', [AdminDisasterReportController::class, 'index'])->name('disaster-reports.index');
    Route::patch('/laporan-bencana/{id}/accept', [AdminDisasterReportController::class, 'accept'])->name('disaster-reports.accept');
    Route::patch('/laporan-bencana/{id}/reject', [AdminDisasterReportController::class, 'reject'])->name('disaster-reports.reject');
});
