<?php

use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\FoodspotController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'hasRole:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('foodspots', FoodspotController::class)->names('foodspots');
    Route::delete('foodspots/{foodspot}/images', [FoodspotController::class, 'destroyImage'])
        ->middleware('auth')
        ->name('foodspots.images.destroy');

});
