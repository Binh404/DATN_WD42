<?php

use App\Http\Controllers\Admin\ChamCongAdminController;
use App\Http\Controllers\Admin\DangKyTangCaAdminController;
use App\Http\Controllers\Admin\ThucHienTangCaAdminController;
use App\Http\Controllers\employee\ChamCongController;
use App\Http\Controllers\employee\DangKyTangCaController;
use App\Http\Middleware\CheckRole;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChucVuController;

use App\Http\Middleware\CheckHoSoNguoiDung;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Employee\HoSoController;
use App\Http\Controllers\Admin\CongViecController;
use App\Http\Controllers\Admin\DonTuController;
use App\Http\Controllers\Admin\LoaiNghiPhepController;
use App\Http\Controllers\Admin\PhongBanController;
use App\Http\Controllers\Client\UngTuyenController;
use App\Http\Controllers\Admin\DuyetDonTuController;
use App\Http\Controllers\Auth\PasswordOTPController;
use App\Http\Controllers\employee\ProfileController;
use App\Http\Middleware\PreventLoginCacheMiddleware;

use App\Http\Controllers\Admin\HoSoNhanVienController;
use App\Http\Controllers\Admin\LichSuDuyetDonXinNghiController;
use App\Http\Controllers\employee\BangLuongController;
use App\Http\Middleware\RedirectIfAuthenticatedCustom;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\client\TinTuyenDungController;
use App\Http\Controllers\Admin\YeuCauTuyenDungController;

use App\Http\Controllers\Admin\HopDongLaoDongController;

use App\Http\Controllers\Client\NghiPhepController;
use App\Http\Controllers\Admin\LuongController;


Route::middleware(['auth'])->group(function () {
    Route::post('/send-otp', [PasswordOTPController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/verify-otp', function () {
        return view('profile.password-otp');
    })->name('password.otp-form');
    Route::post('/verify-otp', [PasswordOTPController::class, 'verifyOtp'])->name('password.verify-otp');
});

// Admin routes
Route::middleware(['auth', PreventBackHistory::class, CheckRole::class . ':admin'])->group(function () {
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

    //Quản lý chấm công
    Route::get('/chamcong', [ChamCongAdminController::class, 'index'])->name('admin.chamcong.index');
    Route::get('/create', [ChamCongAdminController::class, 'create'])->name('admin.chamcong.create');
    Route::post('/chamcong/{id}/pheDuyet', [ChamCongAdminController::class, 'pheDuyet'])->name('admin.chamcong.pheDuyet');
    Route::get('/chamcong/{id}', [ChamCongAdminController::class, 'show'])->name('admin.chamcong.show');
    Route::delete('/chamcong/delete/{id}', [ChamCongAdminController::class, 'destroy'])->name('admin.chamcong.destroy');
    Route::get('/chamcong/{id}/edit', [ChamCongAdminController::class, 'edit'])->name('admin.chamcong.edit');
    Route::put('/chamcong/{id}/update', [ChamCongAdminController::class, 'update'])->name('admin.chamcong.update');
    Route::get('/chamcongPheDuyet', [ChamCongAdminController::class, 'xemPheDuyet'])->name('admin.chamcong.xemPheDuyet');
    Route::post('/chamcong/phe-duyet/bulk-action', [ChamCongAdminController::class, 'bulkAction'])->name('admin.phe-duyet.bulk-action');
    // Route xuất Excel với filter hiện tại
    Route::get('cham-cong/export', [ChamCongAdminController::class, 'export'])
        ->name('chamcong.export');

    // Route xuất báo cáo (Excel/PDF)
    Route::post('cham-cong/export-report', [ChamCongAdminController::class, 'exportReport'])
        ->name('chamcong.exportReport');
    Route::get('chamCongPheDuyetTangCa', [DangKyTangCaAdminController::class, 'index'])->name('admin.chamcong.xemPheDuyetTangCa');
    Route::get('chamCongPheDuyetTangCa/{id}', [DangKyTangCaAdminController::class, 'show'])->name('admin.chamcong.xemChiTietDonTangCa');
    Route::post('chamCongPheDuyetTangCa/{id}/pheDuyet', [DangKyTangCaAdminController::class, 'pheDuyet'])->name('admin.chamcong.pheDuyetTangCaTrangThai');
    // Route::delete('chamCongPheDuyetTangCa/{id}/destroy', [DangKyTangCaAdminController::class, 'destroy'])->name('admin.chamcong.destroyTangCa');
    Route::post('/chamcong/phe-duyet-tang-ca/bulk-action', [DangKyTangCaAdminController::class, 'bulkAction'])->name('admin.phe-duyet-tang-ca.bulk-action');
    //danh sách tăng ca
    Route::get('chamCong/danhSachTangCa', [ThucHienTangCaAdminController::class, 'index'])->name('admin.chamcong.danhSachTangCa');
    Route::get('chamCong/danhSachTangCa/{id}', [ThucHienTangCaAdminController::class, 'show'])->name('admin.chamcong.xemChiTietTangCa');
    Route::get('danhSachTangCa/{id}/edit', [ThucHienTangCaAdminController::class, 'edit'])->name('admin.chamcong.editTangCa');
    Route::put('danhSachTangCa/{id}/update', [ThucHienTangCaAdminController::class, 'update'])->name('admin.chamcong.updateTangCa');
    Route::delete('danhSachTangCa/{id}/destroy', [ThucHienTangCaAdminController::class, 'destroy'])->name('admin.chamcong.destroyTangCa');

});

// HR routes
Route::middleware(['auth', PreventBackHistory::class,  CheckRole::class . ':admin,hr'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('hr.dashboard');

    // Hợp đồng lao động
    Route::prefix('hop-dong')->name('hopdong.')->group(function () {
        Route::get('/', [HopDongLaoDongController::class, 'index'])->name('index');
        Route::get('/create', [HopDongLaoDongController::class, 'create'])->name('create');
        Route::post('/', [HopDongLaoDongController::class, 'store'])->name('store');
        Route::get('/{id}', [HopDongLaoDongController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [HopDongLaoDongController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HopDongLaoDongController::class, 'update'])->name('update');
        Route::delete('/{id}', [HopDongLaoDongController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/ky', [HopDongLaoDongController::class, 'kyHopDong'])->name('ky');
        Route::post('/{id}/huy', [HopDongLaoDongController::class, 'huyHopDong'])->name('huy');
        Route::get('/{hopDong}/phu-luc/create', [HopDongLaoDongController::class, 'createPhuLuc'])->name('phuluc.create');
        Route::post('/{hopDong}/phu-luc', [HopDongLaoDongController::class, 'storePhuLuc'])->name('phuluc.store');
    });

    Route::prefix('phu-luc')->name('phuluc.')->group(function () {
        Route::get('/{phuLuc}', [\App\Http\Controllers\Admin\PhuLucHopDongController::class, 'show'])->name('show');
    });

    // Admin Phòng Ban
    Route::get('/phongban', [PhongBanController::class, 'index']);
    Route::get('/phongban/create', [PhongBanController::class, 'create']);
    Route::post('/phongban/store', [PhongBanController::class, 'store']);
    Route::get('/phongban/show/{id}', [PhongBanController::class, 'show']);
    Route::get('/phongban/edit/{id}', [PhongBanController::class, 'edit']);
    Route::put('/phongban/update/{id}', [PhongBanController::class, 'update']);

    // Admin Công Việc
    // Route::get('/congviec', [CongViecController::class, 'index']);
    // Route::get('/congviec/create', [CongViecController::class, 'create']);
    // Route::post('/congviec/store', [CongViecController::class, 'store']);
    // Route::get('/congviec/show/{id}', [CongViecController::class, 'show']);
    // Route::get('/congviec/edit/{id}', [CongViecController::class, 'edit']);
    // Route::put('/congviec/update/{id}', [CongViecController::class, 'update']);

    // // Admin Ứng Tuyển
    // Route::get('/ungvien', [UngTuyenController::class, 'index'])->name('ungvien.index');
    // Route::get('/ungvien/tiem-nang', [UngTuyenController::class, 'danhSachTiemNang'])->name('ungvien.tiem-nang');
    // Route::get('/ungvien/phong-van', [UngTuyenController::class, 'danhSachPhongVan'])->name('ungvien.phong-van');
    // Route::get('/ungvien/luu-tru', [UngTuyenController::class, 'danhSachLuuTru'])->name('ungvien.luu-tru');
    // Route::post('/ungvien/phe-duyet', [UngTuyenController::class, 'pheDuyet'])->name('ungvien.phe-duyet');
    // Route::delete('/ungvien/delete/{id}', [UngTuyenController::class, 'destroy']);
    // Route::get('/ungvien/show/{id}', [UngTuyenController::class, 'show']);
    // Route::post('/ungvien/{id}/diem-danh-gia', [UngTuyenController::class, 'luuDiemDanhGia'])->name('ungvien.luudiemdanhgia');
    // Route::get('/ungvien/phong-van', [UngTuyenController::class, 'danhSachPhongVan'])->name('ungvien.phong-van');
    // Route::post('/ungvien/{id}/cap-nhat-diem-phong-van', [UngTuyenController::class, 'capNhatDiemPhongVan'])->name('ungvien.capnhatdiemphongvan');
    // Route::get('/ungvien/emaildagui', [UngTuyenController::class, 'emailDaGui']);
    // Route::get('/ungvien/trung-tuyen', [UngTuyenController::class, 'danhSachTrungTuyen']);

    // // Route Gửi Email Phỏng Vấn N8N
    // Route::post('/ungvien/guiemailall', [UngTuyenController::class, 'guiEmailAll']);
    // // Route Gửi Email Đi Làm N8N
    // Route::post('/ungvien/dilam', [UngTuyenController::class, 'guiEmailDiLam']);



    // // Route xuất file excel phỏng vấn
    // Route::get('/ungvien/export', [UngTuyenController::class, 'exportExcel']);
    // // Route xuất file excel trúng tuyển
    // Route::get('/ungvien/trungtuyen/export', [UngTuyenController::class, 'trungTuyenExport']);



    // Admin Vai Trò
    Route::get('/vaitro', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/vaitro/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/vaitro/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/vaitro/edit/{id}', [CongViecController::class, 'edit']);

    // HR Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin HR - Hồ sơ nhân viên
    Route::prefix('/hoso')->group(function () {
        Route::get('nhanvien', [HoSoNhanVienController::class, 'indexNhanVien'])->name('hoso.nhanvien');
        Route::get('truongphong', [HoSoNhanVienController::class, 'indexTruongPhong'])->name('hoso.truongphong');
        Route::get('giamdoc', [HoSoNhanVienController::class, 'indexGiamDoc'])->name('hoso.giamdoc');
        Route::get('/create', [HoSoNhanVienController::class, 'create'])->name('hoso.create');
        Route::post('/store', [HoSoNhanVienController::class, 'store'])->name('hoso.store');
        Route::get('/edit/{id}', [HoSoNhanVienController::class, 'edit'])->name('hoso.edit');
        Route::put('/update/{id}', [HoSoNhanVienController::class, 'update'])->name('hoso.update');
        Route::delete('/delete/{id}', [HoSoNhanVienController::class, 'destroy'])->name('hoso.destroy');


        // Admin HR - Thêm tk
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store'])
            ->name('register.store');
    });

    // Admin HR - Lương
    Route::get('/luong', [LuongController::class, 'tongLuong'])->name('luong.index');
    Route::get('/phieu-luong', [LuongController::class, 'phieuLuongIndex'])->name('phieuluong.index');
    Route::get('/luong/chitiet/{user_id}/{thang}/{nam}', [LuongController::class, 'xemPhieuLuong'])->name('luong.chitiet');
    Route::get('/luong/export-pdf/{user_id}/{thang}/{nam}', [LuongController::class, 'exportPDF'])->name('luong.pdf');




});

// Employee routes
Route::prefix('employee')->middleware(['auth', PreventBackHistory::class, CheckRole::class . ':employee'])->group(function () {
    // Danh sách chấm công
    // / Chấm công routes
    Route::prefix('cham-cong')->name('cham-cong.')->group(function () {
        // Hiển thị trang chấm công
        Route::get('/', [ChamCongController::class, 'index'])->name('index');

        // API chấm công
        Route::post('/vao', [ChamCongController::class, 'chamCongVao'])->name('vao');
        Route::post('/ra', [ChamCongController::class, 'chamCongRa'])->name('ra');

        // Kiểm tra trạng thái chấm công
        Route::get('/trang-thai-full', [ChamCongController::class, 'trangThaiChamCong'])->name('trang-thai');

        // Lịch sử chấm công
        Route::get('/lich-su', [ChamCongController::class, 'lichSuChamCong'])->name('lich-su');

        // Báo cáo chấm công
        Route::get('/bao-cao', [ChamCongController::class, 'baoCaoChamCong'])->name('bao-cao');
        // Route để lấy dữ liệu chấm công theo ngày
        Route::get('/ngay/{dayId}', [ChamCongController::class, 'getChamCongByDay'])
            ->name('cham-cong.get-by-day');

        Route::post('/update-trang-thai', [ChamCongController::class, 'updateTrangThai'])->name('update-trang-thai');
        // Xuất báo cáo Excel
        // Route::get('/xuat-excel', [ChamCongController::class, 'xuatExcel'])->name('xuat-excel');
        //tạo đơn xin tăng ca
        Route::get('/tao-don-xin-tang-ca', [DangKyTangCaController::class, 'index'])->name('tao-don-xin-tang-ca');
        Route::post('/tao-don-xin-tang-ca', [DangKyTangCaController::class, 'store'])->name('tao-don-xin-tang-ca.store');
    });
});

Route::prefix('employee')->middleware(['auth', PreventBackHistory::class, CheckRole::class . ':employee'])->group(function () {

    // Route cho điền hồ sơ lần đầu
    Route::get('/complete-profile', [HoSoController::class, 'form'])
        ->name('employee.complete-profile');
    Route::post('/complete-profile', [HoSoController::class, 'store'])
        ->name('employee.complete-profile.store');

    Route::middleware([CheckHoSoNguoiDung::class])->group(function () {
        Route::get('/dashboard', function () {
            return view('employe.dashboard');
        })->name('employee.dashboard');

        Route::get('/advance', function () {
            return view('employe.advance');
        });

        Route::get('/attendance', function () {
            return view('employe.attendance');
        });

        // nghỉ phép
        Route::get('/nghi-phep', [NghiPhepController::class, 'index'])->name('nghiphep.index');
        Route::get('/nghi-phep/create', [NghiPhepController::class, 'create'])->name('nghiphep.create');
        Route::post('/nghi-phep/store', [NghiPhepController::class, 'store'])->name('nghiphep.store');
        Route::get('/nghi-phep/{id}/huy', [NghiPhepController::class, 'huyDonXinNghi'])->name('nghiphep.cancel');
        Route::get('/nghi-phep/{id}', [NghiPhepController::class, 'show'])->name('nghiphep.show');


        Route::get('/so-du-nghi-phep', [NghiPhepController::class, 'soDuNghiPhep'])->name('nghiphep.sodu');

        Route::get('/notification', function () {
            return view('employe.notification');
        });

        // Bang Luong
        Route::get('/salary', [BangLuongController::class, 'index'])->name('bangluong.index');
        Route::get('/salary/{id}', [BangLuongController::class, 'show'])->name('salary.show');
        Route::get('/task', function () {
            return view('employe.task');
        });

        // EM Profile , đặt tên khác để không bị trùng
        Route::get('/profile', [ProfileController::class, 'show'])->name('employee.profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('employee.profile.update');
    });
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
    Route::get('/job/{id}', [TinTuyenDungController::class, 'getJobDetail'])->name('tuyendung.getJobDetail');
    Route::post('/apply', [TinTuyenDungController::class, 'applyJob'])->name('job.apply');
});

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // đơn yêu cầu tuyển dụng
    Route::get('duyetdon/tuyendung', [DuyetDonTuController::class, 'danhSachDonTuyenDung'])->name('duyetdon.tuyendung.index');
    Route::get('duyetdon/tuyendung/{id}', [DuyetDonTuController::class, 'show'])->name('duyetdon.tuyendung.show');
    Route::post('duyetdon/tuyendung/{id}/duyet', [DuyetDonTuController::class, 'duyetDonTuyenDung'])->name('duyetdon.tuyendung.duyet');
    Route::post('duyetdon/tuyendung/{id}/tuchoi', [DuyetDonTuController::class, 'tuChoiDonTuyenDung'])->name('duyetdon.tuyendung.tuchoi');
});

// HR
Route::prefix('hr')->name('hr.')->group(function () {
    // tuyển dụng
    Route::get('captrenthongbao/tuyendung/danhsach', [YeuCauTuyenDungController::class, 'danhSachThongBaoTuyenDung'])->name('captrenthongbao.tuyendung.index');
    Route::get('captrenthongbao/tuyendung/{id}', [YeuCauTuyenDungController::class, 'chiTietThongBaoTuyenDung'])->name('captrenthongbao.tuyendung.show');
    Route::get('tintuyendung/create-from-request/{id}', [TinTuyenDungController::class, 'createFromRequest'])->name('tintuyendung.create-from-request');
    Route::resource('tintuyendung', TinTuyenDungController::class)->names('tintuyendung');

    // nghỉ phép
    Route::resource('loainghiphep', LoaiNghiPhepController::class)->names('loainghiphep');
});


// Trưởng phòng
Route::prefix('department')->name('department.')->group(function () {
    // quản lý yêu cầu tuyển dụng
    Route::get('yeucautuyendung/create', [YeuCauTuyenDungController::class, 'create'])->name('yeucautuyendung.create');
    Route::post('yeucautuyendung/store', [YeuCauTuyenDungController::class, 'store'])->name('yeucautuyendung.store');

    Route::get('yeucautuyendung/edit/{id}', [YeuCauTuyenDungController::class, 'edit'])->name('yeucautuyendung.edit');
    Route::put('yeucautuyendung/update/{id}', [YeuCauTuyenDungController::class, 'update'])->name('yeucautuyendung.update');

    Route::patch('yeucautuyendung/{id}/cancel', [YeuCauTuyenDungController::class, 'cancel'])->name('yeucautuyendung.cancel');

    Route::get('yeucautuyendung/show/{id}', [YeuCauTuyenDungController::class, 'chiTietYeuCauTuyenDung'])->name('yeucautuyendung.show');

    Route::get('yeucautuyendung', [YeuCauTuyenDungController::class, 'danhSachYeuCauTuyenDung'])->name('yeucautuyendung.index');

    // quản lý đơn xin nghỉ chung cho cả hr và trưởng phòng
    Route::get('don-xin-nghi', [NghiPhepController::class, 'donXinNghi'])->name('donxinnghi.danhsach');
    Route::get('don-xin-nghi/show/{id}', [NghiPhepController::class, 'chiTiet'])->name('donxinnghi.show');
    Route::get('don-xin-nghi/duyet/{id}', [LichSuDuyetDonXinNghiController::class, 'duyetDonXinNghi'])->name('donxinnghi.duyet');
    Route::post('don-xin-nghi/tuchoi', [LichSuDuyetDonXinNghiController::class, 'tuChoi'])->name('donxinnghi.tuchoi');
});

// Client Application
Route::post('/ungtuyen/store', [UngTuyenController::class, 'store']);



// // Route Gửi Email Phỏng Vấn N8N
// Route::post('/ungvien/guiemailall', [UngTuyenController::class, 'guiEmailAll']);
// // Route Gửi Email Đi Làm N8N
// Route::post('/ungvien/dilam', [UngTuyenController::class, 'guiEmailDiLam']);


// // Route xuất file excel phỏng vấn
// Route::get('/ungvien/export', [UngTuyenController::class, 'exportExcel']);
// // Route xuất file excel trúng tuyển
// Route::get('/ungvien/trungtuyen/export', [UngTuyenController::class, 'trungTuyenExport']);


Route::middleware(['auth', PreventBackHistory::class, CheckRole::class . ':hr'])->group(function () {
    // Hr Ứng Tuyển
    Route::get('/ungvien', [UngTuyenController::class, 'index'])->name('ungvien.index');
    Route::get('/ungvien/tiem-nang', [UngTuyenController::class, 'danhSachTiemNang'])->name('ungvien.tiem-nang');
    Route::get('/ungvien/phong-van', [UngTuyenController::class, 'danhSachPhongVan'])->name('ungvien.phong-van');
    Route::get('/ungvien/luu-tru', [UngTuyenController::class, 'danhSachLuuTru'])->name('ungvien.luu-tru');
    Route::post('/ungvien/phe-duyet', [UngTuyenController::class, 'pheDuyet'])->name('ungvien.phe-duyet');
    Route::delete('/ungvien/delete/{id}', [UngTuyenController::class, 'destroy']);
    Route::get('/ungvien/show/{id}', [UngTuyenController::class, 'show']);
    Route::post('/ungvien/{id}/diem-danh-gia', [UngTuyenController::class, 'luuDiemDanhGia'])->name('ungvien.luudiemdanhgia');
    Route::get('/ungvien/phong-van', [UngTuyenController::class, 'danhSachPhongVan'])->name('ungvien.phong-van');
    Route::post('/ungvien/{id}/cap-nhat-diem-phong-van', [UngTuyenController::class, 'capNhatDiemPhongVan'])->name('ungvien.capnhatdiemphongvan');
    Route::get('/ungvien/emaildagui', [UngTuyenController::class, 'emailDaGui']);
    Route::get('/ungvien/trung-tuyen', [UngTuyenController::class, 'danhSachTrungTuyen']);

    // Route Gửi Email Phỏng Vấn N8N
    Route::post('/ungvien/guiemailall', [UngTuyenController::class, 'guiEmailAll']);
    // Route Gửi Email Đi Làm N8N
    Route::post('/ungvien/dilam', [UngTuyenController::class, 'guiEmailDiLam']);


    // Route xuất file excel phỏng vấn
    Route::get('/ungvien/export', [UngTuyenController::class, 'exportExcel']);
    // Route xuất file excel trúng tuyển
    Route::get('/ungvien/trungtuyen/export', [UngTuyenController::class, 'trungTuyenExport']);
});