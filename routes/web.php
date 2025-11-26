<?php

use App\Http\Controllers\Owner\FoodspotController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    if ($user->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Owner foodspot management
Route::middleware('auth')->group(function () {
    Route::resource('owner/foodspots', FoodspotController::class)->names('owner.foodspots');
});

// Image removal for owner foodspots
Route::delete('owner/foodspots/{foodspot}/images', [FoodspotController::class, 'destroyImage'])
    ->middleware('auth')
    ->name('owner.foodspots.images.destroy');

require __DIR__.'/auth.php';
require __DIR__.'/owner.php';
