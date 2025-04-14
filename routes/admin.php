<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WeatherStationController;
use App\Http\Controllers\Admin\RainfallDataController;
use App\Http\Controllers\Admin\FloodPredictionController;
use App\Http\Controllers\Admin\FloodWarningParameterController;
use App\Http\Middleware\CheckRole;

// Grup route untuk admin
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Grup route untuk fitur weather management
    Route::prefix('weather')->name('weather.')->group(function () {
        
        // Weather Stations
        Route::resource('stations', WeatherStationController::class);
        
        // Rainfall Data
        Route::resource('rainfall', RainfallDataController::class);
        
        // Flood Predictions
        Route::resource('predictions', FloodPredictionController::class);
        
        // Flood Warning Parameters
        Route::resource('parameters', FloodWarningParameterController::class)->except(['destroy']);
    });
});