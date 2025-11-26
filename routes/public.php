<?php

use App\Http\Controllers\PublicSite\FoodspotController as PublicFoodspotController;
use Illuminate\Support\Facades\Route;

Route::get('/foodspots', [PublicFoodspotController::class, 'index'])->name('foodspots.index');
Route::get('/foodspots/{foodspot}', [PublicFoodspotController::class, 'show'])->name('foodspots.show');
