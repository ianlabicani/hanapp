<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoodspotController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'hasRole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('foodspots', FoodspotController::class)->names('foodspots');

        Route::delete('foodspots/{foodspot}/images', [FoodspotController::class, 'destroyImage'])
            ->name('foodspots.images.destroy');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    });
