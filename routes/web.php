<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Routing\Router;

// Group route cho Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/getEmployeeAndRequests', [DashboardController::class, 'getEmployeeAndRequests'])->name('get.requests');
});

// Group route cho User
Route::prefix('user')->name('user.')->group(function () {
    
});

// Route home page
Route::get('/', [HomeController::class, 'index'])->name('home');