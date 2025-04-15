<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisasterReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ Dashboard utama
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

require __DIR__.'/auth.php';
