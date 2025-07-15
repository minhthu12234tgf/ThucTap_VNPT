<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::post('/getEmployeeAndRequests', [DashboardController::class, 'getEmployeeAndRequests']);