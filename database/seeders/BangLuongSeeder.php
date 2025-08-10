<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BangLuongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bang_luong')->insert([
            [
                'ma_bang_luong' => 'BL202411',
                'loai_bang_luong' => 'hang_thang',
                'nam' => 2024,
                'thang' => 11,
                // 'ngay_tra_luong' => '2024-11-30',
                'trang_thai' => 'da_tra',
                'nguoi_xu_ly_id' => 1,
                'thoi_gian_xu_ly' => '2024-11-25 10:00:00',
                'nguoi_phe_duyet_id' => 1,
                'thoi_gian_phe_duyet' => '2024-11-28 14:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_bang_luong' => 'BL202412',
                'loai_bang_luong' => 'hang_thang',
                'nam' => 2024,
                'thang' => 12,
                // 'ngay_tra_luong' => '2024-12-31',
                'trang_thai' => 'da_duyet',
                'nguoi_xu_ly_id' => 1,
                'thoi_gian_xu_ly' => '2024-12-25 09:15:00',
                'nguoi_phe_duyet_id' => 1,
                'thoi_gian_phe_duyet' => '2024-12-28 16:20:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_bang_luong' => 'TET2025',
                'loai_bang_luong' => 'thuong',
                'nam' => 2025,
                'thang' => 1,
                // 'ngay_tra_luong' => '2025-01-20',
                'trang_thai' => 'cho_duyet',
                'nguoi_xu_ly_id' => 1,
                'thoi_gian_xu_ly' => '2025-01-15 11:00:00',
                'nguoi_phe_duyet_id' => 1,
                'thoi_gian_phe_duyet' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
