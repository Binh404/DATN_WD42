<?php

use App\Http\Controllers\employee\BangLuongController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CongViecController;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\client\TuyenDungController;

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

// Admin Vai Trò
Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/vaitro/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');


// Employee Routes
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
    // Bang Luong
    Route::get('/salary',[BangLuongController::class, 'index'])->name('bangluong.index');
    Route::get('/salary/{id}', [BangLuongController::class, 'show'])->name('salary.show');
    Route::get('/task', function () {
        return view('employe.task');
    });
});


// Trang giới thiệu và tuyển dụng Routes
Route::prefix('homepage')->group(function () {

    Route::get('/', function () {
        return view('homePage.home');
    });
    Route::get('/about', function () {
        return view('homePage.about');
    });
    Route::get('/job', [TuyenDungController::class, 'getJob'])->name('tuyendung.job');
    Route::get('/job/{id}', [TuyenDungController::class,'getJobDetail'])->name('tuyendung.getJobDetail');


    // Route::get('/job/detail', function () {
    //     return view('homePage.detailJob');
    // });

});
