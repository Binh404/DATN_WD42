<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class PhongBanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacadesDB::table('phong_ban')->insert([
            // Phòng ban cấp cao
            [
                'id' => 1,
                'ten_phong_ban' => 'Ban Giám Đốc',
                'ma_phong_ban' => 'BGD',
                'mo_ta' => 'Ban lãnh đạo công ty',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 1,
                'phong_ban_cha_id' => null,
                'ngan_sach' => 5000000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten_phong_ban' => 'Phòng Nhân Sự',
                'ma_phong_ban' => 'HR',
                'mo_ta' => 'Quản lý nhân sự và tuyển dụng',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 1,
                'phong_ban_cha_id' => 1,
                'ngan_sach' => 500000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten_phong_ban' => 'Phòng Kế Toán',
                'ma_phong_ban' => 'KT',
                'mo_ta' => 'Quản lý tài chính và kế toán',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 1,
                'phong_ban_cha_id' => 1,
                'ngan_sach' => 800000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten_phong_ban' => 'Phòng Công Nghệ Thông Tin',
                'ma_phong_ban' => 'IT',
                'mo_ta' => 'Phát triển và vận hành hệ thống IT',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 1,
                'phong_ban_cha_id' => 1,
                'ngan_sach' => 1500000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten_phong_ban' => 'Phòng Marketing',
                'ma_phong_ban' => 'MKT',
                'mo_ta' => 'Marketing và truyền thông',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 1,
                'phong_ban_cha_id' => 1,
                'ngan_sach' => 1000000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten_phong_ban' => 'Phòng Kinh Doanh',
                'ma_phong_ban' => 'SALES',
                'mo_ta' => 'Bán hàng và chăm sóc khách hàng',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 1,
                'phong_ban_cha_id' => 1,
                'ngan_sach' => 2000000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Phòng ban tại chi nhánh HCM
            [
                'id' => 7,
                'ten_phong_ban' => 'Phòng Kinh Doanh HCM',
                'ma_phong_ban' => 'SALES_HCM',
                'mo_ta' => 'Bán hàng tại khu vực phía Nam',
                'truong_phong_id' => null,
                'chi_nhanh_id' => 2,
                'phong_ban_cha_id' => 6,
                'ngan_sach' => 800000000,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
