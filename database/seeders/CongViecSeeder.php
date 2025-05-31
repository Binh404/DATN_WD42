<?php

namespace Database\Seeders;
use App\Models\CongViec;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CongViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cong_viec')->insert([
             [
                'ten_cong_viec' => 'Phát triển module quản lý nhân sự',
                'mo_ta' => 'Xây dựng module quản lý thông tin nhân viên, hồ sơ và chấm công',
                'trang_thai' => 'dang_lam',
                'do_uu_tien' => 'cao',
                'ngay_bat_dau' => '2024-12-01 09:00:00',
                'deadline' => '2024-12-30 17:00:00',
                'tien_do' => 60,
                'ngay_hoan_thanh' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_cong_viec' => 'Thiết kế giao diện tuyển dụng',
                'mo_ta' => 'Thiết kế UI/UX cho module tuyển dụng và quản lý ứng viên',
                'trang_thai' => 'hoan_thanh',
                'do_uu_tien' => 'trung_binh',
                'ngay_bat_dau' => '2024-11-15 08:30:00',
                'deadline' => '2024-11-30 17:30:00',
                'ngay_hoan_thanh' => '2024-11-28 16:45:00',
                'tien_do' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_cong_viec' => 'Kiểm tra bảo mật hệ thống',
                'mo_ta' => 'Thực hiện audit bảo mật và penetration testing cho hệ thống HRM',
                'trang_thai' => 'chua_bat_dau',
                'do_uu_tien' => 'cao',
                'ngay_bat_dau' => '2025-01-15 09:00:00',
                'deadline' => '2025-01-25 17:00:00',
                'ngay_hoan_thanh' => null,
                'tien_do' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
