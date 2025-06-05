<?php

use App\Http\Middleware\CheckRole;

use App\Http\Controllers\employee\BangLuongController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
