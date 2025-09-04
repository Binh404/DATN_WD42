<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhuCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('phu_cap')->insert([
              [
                'ten' => 'Phụ cấp ăn trua',
                'ma' => 'PC_AN_TRUA',
                'mo_ta' => 'Phụ cấp tiền ăn trưa hàng ngày cho nhân viên',
                'loai_phu_cap' => 'co_dinh',
                'so_tien_mac_dinh' => 50000,
                'cach_tinh' => 'so_tien_co_dinh',
                'chiu_thue' => false,
                'dieu_kien_ap_dung' => json_encode(['tat_ca_nhan_vien' => true]),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Phụ cấp xăng xe',
                'ma' => 'PC_XANG_XE',
                'mo_ta' => 'Phụ cấp chi phí đi lại bằng xe máy',
                'loai_phu_cap' => 'theo_cap_bac',
                'so_tien_mac_dinh' => 1000000,
                'cach_tinh' => 'so_tien_co_dinh',
                'chiu_thue' => true,
                'dieu_kien_ap_dung' => json_encode(['cap_quan_ly_tro_len' => true]),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Phụ cấp trách nhiệm',
                'ma' => 'PC_TRACH_NHIEM',
                'mo_ta' => 'Phụ cấp cho các vị trí có trách nhiệm quản lý',
                'loai_phu_cap' => 'theo_cap_bac',
                'so_tien_mac_dinh' => 0,
                'cach_tinh' => 'phan_tram_luong_cb',
                'chiu_thue' => true,
                'dieu_kien_ap_dung' => json_encode(['truong_phong_tro_len' => true]),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Phụ cấp điện thoại',
                'ma' => 'PC_DIEN_THOAI',
                'mo_ta' => 'Hỗ trợ chi phí điện thoại công việc',
                'loai_phu_cap' => 'co_dinh',
                'so_tien_mac_dinh' => 300000,
                'cach_tinh' => 'so_tien_co_dinh',
                'chiu_thue' => false,
                'dieu_kien_ap_dung' => json_encode(['nhan_vien_van_phong' => true]),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
         ]);
    }
}
