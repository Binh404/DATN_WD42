<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhuCapNhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('phu_cap_nhan_vien')->insert([
            [
                'nguoi_dung_id' => 1,
                'phu_cap_id' => 1,
                'so_tien' => 50000,
                'ngay_hieu_luc' => '2024-01-01',
                'trang_thai' => 'hieu_luc',
                'ghi_chu' => 'Phụ cấp ăn trua tiêu chuẩn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'phu_cap_id' => 2,
                'so_tien' => 1200000,
                'ngay_hieu_luc' => '2024-01-01',
                'trang_thai' => 'hieu_luc',
                'ghi_chu' => 'Phụ cấp xăng xe cho quản lý',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'phu_cap_id' => 1,
                'so_tien' => 50000,
                'ngay_hieu_luc' => '2024-03-01',
                'trang_thai' => 'hieu_luc',
                'ghi_chu' => 'Phụ cấp ăn trua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'phu_cap_id' => 4,
                'so_tien' => 300000,
                'ngay_hieu_luc' => '2024-03-01',
                'trang_thai' => 'hieu_luc',
                'ghi_chu' => 'Phụ cấp điện thoại',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}