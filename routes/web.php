<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\WeatherStationController;
use App\Http\Controllers\Admin\RainfallDataController;
use App\Http\Controllers\Admin\FloodPredictionController;
use App\Http\Controllers\Admin\FloodWarningParameterController;

// Grup route untuk admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
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

Route::get('/', function () {
    return view('welcome');
});
