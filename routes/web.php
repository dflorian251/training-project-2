<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/locations', [LocationController::class, 'index'])->name('locations');

    Route::post('/locations/submit-location', [LocationController::class, 'store'])->name('submit-location');

    Route::get('/map', [MapController::class, 'index'])->name('map');

    Route::get('/get-locations', [MapController::class, 'getLocations']);

    Route::get('/get-users', [UserController::class, 'index'])->name('get-users');

    Route::get('/get-user/{id}', [UserController::class, 'indexUser'])->name('user.get');

    Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->name('user.delete');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'page'])->name('users.index');

        Route::get('/create-user', [UserController::class, 'createUserPage'])->name('users.create');

        Route::post('/store-user', [UserController::class, 'store'])->name('users.store');

        Route::get('/edit-user/{id}', [UserController::class, 'editUserPage'])->name('users.edit');

        Route::patch('/update-user/{id}', [UserController::class, 'update'])->name('users.update');
    });
});





require __DIR__.'/auth.php';
