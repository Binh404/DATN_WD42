<?php

namespace Database\Seeders;

use App\Models\PhanCong;
use App\Models\CongViec;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PhanCongCongViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('phan_cong_cong_viec')->insert([
            [
                'nguoi_giao_id' => 1, // Giả sử có người dùng với ID 1
                'nguoi_nhan_id' => 2,
                'cong_viec_id' => 1,
                'phong_ban_id' => 1,
                'vai_tro_trong_cv' => 'chu_tri',
                'ghi_chu' => 'Trưởng nhóm phát triển, chịu trách nhiệm chính',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_giao_id' => 1,
                'nguoi_nhan_id' => 3,
                'cong_viec_id' => 1,
                'phong_ban_id' => 1,
                'vai_tro_trong_cv' => 'phoi_hop',
                'ghi_chu' => 'Hỗ trợ phát triển frontend',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_giao_id' => 2,
                'nguoi_nhan_id' => 4,
                'cong_viec_id' => 2,
                'phong_ban_id' => 2,
                'vai_tro_trong_cv' => 'chu_tri',
                'ghi_chu' => 'Designer chính cho dự án',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            ]);
    }
}