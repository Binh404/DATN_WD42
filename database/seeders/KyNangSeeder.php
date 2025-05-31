<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KyNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ky_nang')->insert([
            [
                'ten' => 'Laravel Framework',
                'danh_muc' => 'Backend Development',
                'mo_ta' => 'Framework PHP cho phát triển web application',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'React.js',
                'danh_muc' => 'Frontend Development',
                'mo_ta' => 'JavaScript library cho xây dựng user interface',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'MySQL Database',
                'danh_muc' => 'Database',
                'mo_ta' => 'Hệ quản trị cơ sở dữ liệu quan hệ',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'UI/UX Design',
                'danh_muc' => 'Design',
                'mo_ta' => 'Thiết kế giao diện và trải nghiệm người dùng',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Project Management',
                'danh_muc' => 'Management',
                'mo_ta' => 'Quản lý dự án và điều phối team',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Docker',
                'danh_muc' => 'DevOps',
                'mo_ta' => 'Containerization platform',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
