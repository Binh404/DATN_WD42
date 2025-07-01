<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        // 1. Cơ sở tổ chức
        ChiNhanhSeeder::class,
        PhongBanSeeder::class,
        ChucVuSeeder::class,

        // 2. Phân quyền - phải chạy trước User
        NhomQuyenSeeder::class,
        QuyenSeeder::class,
        VaiTroSeeder::class,
        VaiTroQuyenSeeder::class,

        // 3. Người dùng
        NguoiDungSeeder::class,
        NguoiDungVaiTroSeeder::class,
        NguoiDungQuyenSeeder::class,
        HoSoNguoiDungSeeder::class,

        // 4. Hợp đồng, phụ cấp, lương
        HopDongLaoDongSeeder::class,
        PhuCapSeeder::class,
        PhuCapNhanVienSeeder::class,
        BangLuongSeeder::class,
        LuongNhanVienSeeder::class,

        // 5. Kỹ năng
        KyNangSeeder::class,
        KyNangNhanVienSeeder::class,

        // 6. Chấm công & nghỉ phép
        LoaiNghiPhepSeeder::class,
        SoDuNghiPhepNhanVienSeeder::class,
        ChamCongSeeder::class,
        // DonXinNghiSeeder::class,

        // 7. Công việc
        CongViecSeeder::class,
        PhanCongCongViecSeeder::class,

        // 8. Tuyển dụng
        TinTuyenDungSeeder::class,
        UngVienSeeder::class,

        // 9. Tài liệu
        TaiLieuSeeder::class,
    ]);
}

}