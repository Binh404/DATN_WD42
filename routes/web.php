<?php

use App\Http\Middleware\CheckRole;

use App\Http\Controllers\employee\BangLuongController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CongViecController;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\Client\UngTuyenController;
use App\Http\Middleware\PreventLoginCacheMiddleware;
use App\Http\Middleware\RedirectIfAuthenticatedCustom;
use App\Http\Controllers\client\TinTuyenDungController;





// Admin routes
Route::middleware(['auth',PreventBackHistory::class, CheckRole::class . ':admin'])->group(function () {
    // Route::get('/phongban', [PhongBanController::class, 'index']);
    // các route khác dành cho admin...
  Route::get('/admin/dashboard', function () {
        return view('admin.dashboard.index');
        })->name('admin.dashboard');;
    // Admin Phòng Ban
    // Route::get('/phongban', [PhongBanController::class, 'index']);
    // Route::get('/phongban/create', [PhongBanController::class, 'create']);
    // Route::post('/phongban/store', [PhongBanController::class, 'store']);
    // Route::get('/phongban/show/{id}', [PhongBanController::class, 'show']);
    // Route::get('/phongban/edit/{id}', [PhongBanController::class, 'edit']);
    // Route::put('/phongban/update/{id}', [PhongBanController::class, 'update']);
    Route::delete('/phongban/delete/{id}', [PhongBanController::class, 'destroy']);


    // Admin Công Việc
    // Route::get('/congviec', [CongViecController::class, 'index']);
    // Route::get('/congviec/create', [CongViecController::class, 'create']);
    // Route::post('/congviec/store', [CongViecController::class, 'store']);
    // Route::get('/congviec/show/{id}', [CongViecController::class, 'show']);
    // Route::get('/congviec/edit/{id}', [CongViecController::class, 'edit']);
    // Route::put('/congviec/update/{id}', [CongViecController::class, 'update']);
    Route::delete('/congviec/delete/{id}', [CongViecController::class, 'destroy']);

    // Admin Vai Trò
    // Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
    // Route::post('/vaitro/roles', [RoleController::class, 'store'])->name('roles.store');
    // Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');
    Route::delete('/vaitro/delete/{id}', [RoleController::class, 'destroy']);

    //Admin Profile
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// HR routes
Route::middleware(['auth',PreventBackHistory::class,  CheckRole::class . ':admin,hr'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('hr.dashboard');
    // Admin Phòng Ban
    Route::get('/phongban', [PhongBanController::class, 'index']);
    Route::get('/phongban/create', [PhongBanController::class, 'create']);
    Route::post('/phongban/store', [PhongBanController::class, 'store']);
    Route::get('/phongban/show/{id}', [PhongBanController::class, 'show']);
    Route::get('/phongban/edit/{id}', [PhongBanController::class, 'edit']);
    Route::put('/phongban/update/{id}', [PhongBanController::class, 'update']);

    // Admin Công Việc
    Route::get('/congviec', [CongViecController::class, 'index']);
    Route::get('/congviec/create', [CongViecController::class, 'create']);
    Route::post('/congviec/store', [CongViecController::class, 'store']);
    Route::get('/congviec/show/{id}', [CongViecController::class, 'show']);
    Route::get('/congviec/edit/{id}', [CongViecController::class, 'edit']);
    Route::put('/congviec/update/{id}', [CongViecController::class, 'update']);

    // Admin Ứng Tuyển
    Route::get('/ungvien', [UngTuyenController::class, 'index']);
    Route::delete('/ungvien/delete/{id}', [UngTuyenController::class, 'destroy']);
    Route::get('/ungvien/show/{id}', [UngTuyenController::class, 'show']);



    // Admin Vai Trò
    Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/vaitro/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/vaitro/edit/{id}', [CongViecController::class, 'edit']);

    // HR Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employee routes
Route::prefix('employee')->middleware(['auth',PreventBackHistory::class, CheckRole::class . ':employee'])->group(function () {

    Route::get('/dashboard', function () {
        return view('employe.dashboard');
    })->name('employee.dashboard');

    Route::get('/advance', function () {
        return view('employe.advance');
    });

    Route::get('/attendance', function () {
        return view('employe.attendance');
    });

    Route::get('/leave', function () {
        return view('employe.leave');
    });

    Route::get('/notification', function () {
        return view('employe.notification');
    });

    // Bang Luong
    Route::get('/salary',[BangLuongController::class, 'index'])->name('bangluong.index');
    Route::get('/salary/{id}', [BangLuongController::class, 'show'])->name('salary.show');
    Route::get('/task', function () {
        return view('employe.task');
    });

    // EM Profile , đặt tên khác để không bị trùng
    Route::get('/profile', [ProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('employee.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('employee.profile.destroy');
});

Route::get('/chuc-vus/{phongBanId}', [ChucVuController::class, 'getByPhongBan']);


Route::middleware([RedirectIfAuthenticatedCustom::class, PreventLoginCacheMiddleware::class])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/login', function () {
        return view('auth.login');
    });
});

require __DIR__ . '/auth.php';

// Trang giới thiệu và tuyển dụng Routes
Route::prefix('homepage')->group(function () {

    Route::get('/', function () {
        return view('homePage.home');
    });
    Route::get('/about', function () {
        return view('homePage.about');
    });

    Route::get('/job', [TinTuyenDungController::class, 'getJob'])->name('tuyendung.job');
    Route::get('/job/{id}', [TinTuyenDungController::class,'getJobDetail'])->name('tuyendung.getJobDetail');
    Route::post('/apply', [TinTuyenDungController::class, 'applyJob'])->name('job.apply');


});

// Client Application
    Route::post('/ungtuyen/store', [UngTuyenController::class, 'store']);
