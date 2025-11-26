<?php

use App\Http\Controllers\Public\FoodspotController;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function () {
    Route::get('/foodspots', [FoodspotController::class, 'index'])->name('foodspots.index');
    Route::get('/foodspots/{foodspot}', [FoodspotController::class, 'show'])->name('foodspots.show');
});
