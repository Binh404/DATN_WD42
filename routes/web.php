<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard.index');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');