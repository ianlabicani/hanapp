<?php

use App\Http\Controllers\Public\FoodspotController;
use App\Http\Controllers\Public\ReviewController;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function () {

    Route::get('/about', function () {
        return view('public.about');
    })->name('about');
    Route::get('/foodspots', [FoodspotController::class, 'index'])->name('foodspots.index');
    Route::get('/foodspots/{foodspot}', [FoodspotController::class, 'show'])->name('foodspots.show');

    // Reviews (auth required)
    Route::middleware('auth')->group(function () {
        Route::post('/foodspots/{foodspot}/reviews', [ReviewController::class, 'store'])->name('foodspots.reviews.store');
        Route::delete('/foodspots/{foodspot}/reviews/{review}', [ReviewController::class, 'destroy'])->name('foodspots.reviews.destroy');
    });
});
