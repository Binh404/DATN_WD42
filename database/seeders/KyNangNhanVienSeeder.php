<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KyNangNhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('ky_nang_nhan_vien')->insert([
            [
                'nguoi_dung_id' => 1,
                'ky_nang_id' => 1,
                'trinh_do' => 'chuyen_gia',
                'so_nam_kinh_nghiem' => 5.5,
                'chung_chi' => 'Laravel Certified Developer',
                'ngay_cap_chung_chi' => '2023-06-15',
                'ngay_het_han' => '2026-06-15',
                'da_xac_minh' => true,
                'nguoi_xac_minh_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'ky_nang_id' => 3,
                'trinh_do' => 'nang_cao',
                'so_nam_kinh_nghiem' => 4.0,
                'chung_chi' => 'MySQL Database Administrator',
                'ngay_cap_chung_chi' => '2023-03-20',
                'ngay_het_han' => '2025-09-05',

                'da_xac_minh' => true,
                'nguoi_xac_minh_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'ky_nang_id' => 2,
                'trinh_do' => 'trung_cap',
                'so_nam_kinh_nghiem' => 2.5,
                'chung_chi' => 'React Developer Certificate',
                'ngay_cap_chung_chi' => '2024-01-10',
                'ngay_het_han' => '2025-09-05',

                'da_xac_minh' => true,
                'nguoi_xac_minh_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'ky_nang_id' => 4,
                'trinh_do' => 'co_ban',
                'so_nam_kinh_nghiem' => 1.0,
                'chung_chi' => 'UX Design Fundamentals',
                'ngay_cap_chung_chi' => '2024-09-05',
                'ngay_het_han' => '2025-09-05',
                'da_xac_minh' => false,
                'nguoi_xac_minh_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
         ]);
    }
}
