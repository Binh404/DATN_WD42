<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('admin.dashboard.index');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

// Admin routes
Route::get('/phongban', [PhongBanController::class, 'index'])->name('phongban.index');

