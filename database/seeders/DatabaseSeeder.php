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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // Seeders cơ bản - chạy trước
            ChiNhanhSeeder::class,
            PhongBanSeeder::class,
            ChucVuSeeder::class,

            // User và profile
            NguoiDungSeeder::class,
            HoSoNguoiDungSeeder::class,

            // Hợp đồng và lương
            HopDongLaoDongSeeder::class,
            PhuCapSeeder::class,
            PhuCapNhanVienSeeder::class,
            BangLuongSeeder::class,
            LuongNhanVienSeeder::class,

            // Kỹ năng
            KyNangSeeder::class,
            KyNangNhanVienSeeder::class,

            // Chấm công và nghỉ phép
            LoaiNghiPhepSeeder::class,
            SoDuNghiPhepNhanVienSeeder::class,
            ChamCongSeeder::class,
            DonXinNghiSeeder::class,

            // Công việc
            CongViecSeeder::class,
            PhanCongCongViecSeeder::class,

            // Tuyển dụng
            TinTuyenDungSeeder::class,
            UngVienSeeder::class,

            // Tài liệu
            TaiLieuSeeder::class,

            // Phân quyền
            NhomQuyenSeeder::class,
            QuyenSeeder::class,
            VaiTroSeeder::class,
            VaiTroQuyenSeeder::class,
            NguoiDungVaiTroSeeder::class,
            NguoiDungQuyenSeeder::class,

        ]);
    }
}