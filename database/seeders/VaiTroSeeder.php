<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaiTroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vai_tro')->insert([
             [
                'id' => 1,
                'ten_hien_thi' => 'Quản trị viên',
                'ten' => 'ADMIN',
                'mo_ta' => 'Quyền cao nhất của hệ thống, có thể truy cập tất cả chức năng',
                'la_vai_tro_he_thong' => true,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten_hien_thi' => 'Quản lý nhân sự',
                'ten' => 'HR',
                'mo_ta' => 'Quản lý toàn bộ hoạt động nhân sự, tuyển dụng, lương và chấm công',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten_hien_thi' => 'Trưởng phòng',
                'ten' => 'DEPARTMENT',
                'mo_ta' => '',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten_hien_thi' => 'Nhân viên',
                'ten' => 'EMPLOYEE',
                'mo_ta' => 'Thực hiện các công sự cơ bản',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
