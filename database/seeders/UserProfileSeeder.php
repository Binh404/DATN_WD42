<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_profiles')->insert([
            [
                'user_id' => 1,
                'ho_ten' => 'Admin User',
                'so_dien_thoai' => '0900000001',
                'dia_chi' => 'Hà Nội',
                'ngay_sinh' => '1990-01-01',
                'gioi_tinh' => 'male',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'ho_ten' => 'Manager User',
                'so_dien_thoai' => '0900000002',
                'dia_chi' => 'Hồ Chí Minh',
                'ngay_sinh' => '1992-02-02',
                'gioi_tinh' => 'female',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'ho_ten' => 'Normal User',
                'so_dien_thoai' => '0900000003',
                'dia_chi' => 'Đà Nẵng',
                'ngay_sinh' => '1995-03-03',
                'gioi_tinh' => 'other',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 