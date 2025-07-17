<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::post('/', [DashboardController::class, 'send']);
Route::get('/test', function () {
    return view('pages.user.usertemp');
});
