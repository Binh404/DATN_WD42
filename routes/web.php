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

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

