<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;

Route::get('/', function () {
    return view('admin.dashboard.index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

// Admin routes
Route::get('/phongban', [PhongBanController::class, 'index'])->name('phongban.index');
Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/vaitro/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');
