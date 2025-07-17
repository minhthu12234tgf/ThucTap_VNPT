<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidentController;

// Add default login route for auth middleware
Route::get('/login', function () {
    return redirect()->route('auth.login.form');
})->name('login');

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

    // Protected routes (require authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/incident-report', [IncidentController::class, 'index'])->name('incident.report');
        Route::post('/incident-report', [IncidentController::class, 'store'])->name('incident.report.store');
    });
});

Route::get('/', [DashboardController::class, 'index']);
Route::post('/', [DashboardController::class, 'send']);