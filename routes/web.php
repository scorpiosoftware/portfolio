<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/',                [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/content/update', [DashboardController::class, 'update'])->name('content.update');

        Route::post('/services',              [DashboardController::class, 'storeService'])->name('services.store');
        Route::put('/services/{service}',     [DashboardController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{service}',  [DashboardController::class, 'deleteService'])->name('services.delete');
    });
});
