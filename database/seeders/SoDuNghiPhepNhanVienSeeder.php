<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
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
                'loai_nghi_phep_id' =>1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3, 
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 1, // Nghỉ phép năm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 2, // Nghỉ ốm
                'nam' => 2025,
                'so_ngay_duoc_cap' => 30,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 3, // Nghỉ thai sản
                'nam' => 2025,
                'so_ngay_duoc_cap' => 180,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 4, // Nghỉ kết hôn
                'nam' => 2025,
                'so_ngay_duoc_cap' => 4,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 5, // Nghỉ tang
                'nam' => 2025,
                'so_ngay_duoc_cap' => 3,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 6, // Nghỉ nghỉ không lương
                'nam' => 2025,
                'so_ngay_duoc_cap' => 60,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'loai_nghi_phep_id' => 7, // Nghỉ đột xuất
                'nam' => 2025,
                'so_ngay_duoc_cap' => 12,
                'so_ngay_da_dung' => 0,
                'so_ngay_con_lai' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
