<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\WeatherDashboardController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RekomendasiController;
use App\Http\Controllers\User\MapDashboardController;
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
use App\Http\Controllers\Admin\FloodHistoryController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Api\RainfallApiController;

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

    Route::get('/about', function () {
        return view('user.about');
    })->name('about');
});

Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('weather')->name('weather.')->group(function () {
        Route::resource('stations', WeatherStationController::class);
        Route::resource('rainfall', RainfallDataController::class);
        Route::get('rainfall/api-current', [RainfallApiController::class, 'getCurrentRainfall'])
            ->name('rainfall.api-current');
        Route::post('rainfall/update-category', [RainfallDataController::class, 'updateCategory'])
            ->name('rainfall.update-category');
        Route::resource('predictions', FloodPredictionController::class);
        Route::resource('parameters', FloodWarningParameterController::class)->except(['destroy']);
        Route::get('disaster-statistics', [DisasterReportStatisticsController::class, 'index'])->name('disaster-statistics');
        Route::resource('notification', NotificationController::class);
    });

    Route::resource('artikels', ArtikelController::class);

    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [HandleUsersController::class, 'index'])->name('index');
        Route::delete('/{user}', [HandleUsersController::class, 'destroy'])->name('destroy');
    });

    Route::resource('flood-maps', FloodMapController::class);
    Route::get('/laporan-bencana', [AdminDisasterReportController::class, 'index'])->name('disaster-reports.index');
    Route::patch('/laporan-bencana/{id}/accept', [AdminDisasterReportController::class, 'accept'])->name('disaster-reports.accept');
    Route::patch('/laporan-bencana/{id}/reject', [AdminDisasterReportController::class, 'reject'])->name('disaster-reports.reject');

    Route::resource('flood_history', FloodHistoryController::class);
});

require __DIR__.'/auth.php';