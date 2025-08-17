<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LuongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('luong')->insert([
            [
                'nguoi_dung_id' => 1,
                'hop_dong_lao_dong_id' => 1,
                'luong_co_ban' => 50000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'hop_dong_lao_dong_id' => 2,
                'luong_co_ban' => 30000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'hop_dong_lao_dong_id' => 3,
                'luong_co_ban' => 8000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'hop_dong_lao_dong_id' => 4,
                'luong_co_ban' => 16000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'hop_dong_lao_dong_id' => 5,
                'luong_co_ban' => 9000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 6,
                'hop_dong_lao_dong_id' => 6,
                'luong_co_ban' => 9000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 7,
                'hop_dong_lao_dong_id' => 7,
                'luong_co_ban' => 10000000,
                'phu_cap' => 1000000,
                'tien_thuong' => 500000,
                'tien_phat' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
