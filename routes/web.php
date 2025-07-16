<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
Route::prefix('vnpt-support')->group(function () {
    // Authentication routes
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::get('/register/generate-password', [RegisterController::class, 'generateRandomPassword'])->name('register.generate-password');
        Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password.form');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
Route::get('/', [DashboardController::class, 'index']);
Route::post('/', [DashboardController::class, 'send']);
