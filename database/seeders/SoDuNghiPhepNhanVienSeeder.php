<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoDuNghiPhepNhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('so_du_nghi_phep_nhan_vien')->insert([
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' =>2, // Nghỉ phép năm
                'nam' => 2024,

                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 5,
                'so_ngay_con_lai' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 3, // Nghỉ ốm
                'nam' => 2024,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 2,
                'so_ngay_con_lai' => 28,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 7, // Nghỉ phép năm
                'nam' => 2024,
                'so_ngay_duoc_cap' => 1,
                'so_ngay_da_dung' => 8,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2024,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 3,
                'so_ngay_con_lai' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nhan_vien_id' => 4,
                'loai_nghi_phep_id' => 5, // Nghỉ phép năm
                'nam' => 2024,
                'so_ngay_duoc_cap' => 26, // Senior có nhiều ngày phép hơn
                'so_ngay_da_dung' => 10,
                'so_ngay_con_lai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nhan_vien_id' => 5,
                'loai_nghi_phep_id' => 6, // Nghỉ phép năm
                'nam' => 2024,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}