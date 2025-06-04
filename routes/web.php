<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CongViecController;
use App\Http\Controllers\Admin\DonTuController;
use App\Http\Controllers\Admin\DuyetDonTuController;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\Admin\YeuCauTuyenDungController;
use App\Http\Controllers\client\TuyenDungController;

use App\Http\Controllers\ChucVuController;

Route::get('/chuc-vus/{phongBanId}', [ChucVuController::class, 'getByPhongBan']);

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



// Route::get('/', function () {
//     return view('admin.dashboard.index');
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

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


// Admin duyệt yêu cầu
Route::prefix('admin')->name('admin.')->group(function () {
    // đơn yêu cầu tuyển dụng
    Route::get('dontuyendung', [DuyetDonTuController::class, 'danhSachDonTuyenDung'])->name('dontuyendung.index');
    Route::post('dontuyendung/{id}/duyet', [DuyetDonTuController::class, 'duyetDonTuyenDung'])->name('dontuyendung.duyet');
    Route::post('dontuyendung/{id}/tuchoi', [DuyetDonTuController::class, 'tuChoiDonTuyenDung'])->name('dontuyendung.tuchoi');
});

// HRM
Route::prefix('hr')->name('hr.')->group(function () {
    // tuyển dụng
    Route::resource('captrenthongbao', YeuCauTuyenDungController::class)->names('captrenthongbao');
});



// Trưởng phòng
Route::prefix('department')->name('department.')->group(function () {
    // yêu cầu tuyển dụng
    Route::resource('yeucautuyendung', YeuCauTuyenDungController::class)->names('yeucautuyendung');
    Route::patch('yeucautuyendung/{id}/cancel', [YeuCauTuyenDungController::class, 'cancel'])->name('yeucautuyendung.cancel');
});



// Admin Vai Trò
Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/vaitro/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');


// Employee Routes
Route::prefix('employee')->group(function () {

    Route::get('/advance', function () {
        return view('employe.advance');
    });
    Route::get('/attendance', function () {
        return view('employe.attendance');
    });
    Route::get('', function () {
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
