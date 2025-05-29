<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CongViecController;

Route::get('/', function () {
    return view('admin.dashboard.index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

// Admin Phòng Ban
Route::get('/phongban', [PhongBanController::class, 'index']);
Route::get('/phongban/create', [PhongBanController::class, 'create']);
Route::post('/phongban/store', [PhongBanController::class, 'store']);
Route::get('/phongban/show/{id}', [PhongBanController::class, 'show']);
Route::get('/phongban/edit/{id}', [PhongBanController::class, 'edit']);
Route::put('/phongban/update/{id}', [PhongBanController::class, 'update']);
Route::delete('/phongban/delete/{id}', [PhongBanController::class, 'destroy']);



// Admin Công Việc
Route::get('/congviec', [CongViecController::class, 'index']);




// Admin Vai Trò
Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/vaitro/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');



Route::get('/employee', function () {
    return view('layoutsEmploye.master');
});

Route::prefix('employee')->group(function () {

    Route::get('/advance', function () {
        return view('employe.advance');
    });
    Route::get('/attendance', function () {
        return view('employe.attendance');
    });
    Route::get('/dashboard', function () {
        return view('employe.dashboard');
    });
    Route::get('/leave', function () {
        return view('employe.leave');
    });
    Route::get('/notification', function () {
        return view('employe.notification');
    });
    Route::get('/profile', function () {
        return view('employe.profile');
    });
    Route::get('/salary', function () {
        return view('employe.salary');
    });
    Route::get('/task', function () {
        return view('employe.task');
    });
});