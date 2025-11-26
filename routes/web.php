<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.welcome');
})->name('welcome');

Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    } elseif ($user->hasRole('pending_owner')) {
        return redirect()->route('pending-owner');
    } elseif ($user->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pending-owner', function (Request $request) {
    $user = $request->user();

    // If not pending_owner, redirect to dashboard
    if (! $user->hasRole('pending_owner')) {
        return redirect()->route('dashboard');
    }

    return view('pending-owner');
})->middleware(['auth', 'verified'])->name('pending-owner');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/owner.php';
require __DIR__.'/public.php';
require __DIR__.'/admin.php';
require __DIR__.'/user.php';
