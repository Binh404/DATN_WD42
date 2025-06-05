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
                'ten' => 'admin',
                'ten_hien_thi' => 'Super Admin',
                'mo_ta' => 'Quyền cao nhất của hệ thống, có thể truy cập tất cả chức năng',
                'la_vai_tro_he_thong' => true,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten' => 'hr',
                'ten_hien_thi' => 'Quản trị viên',
                'mo_ta' => 'Quản trị hệ thống, quản lý người dùng và cài đặt',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten' => 'employee',
                'ten_hien_thi' => 'Trưởng phòng nhân sự',
                'mo_ta' => 'Quản lý toàn bộ hoạt động nhân sự, tuyển dụng, lương và chấm công',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten' => 'HR_STAFF',
                'ten_hien_thi' => 'Nhân viên nhân sự',
                'mo_ta' => 'Thực hiện các công việc nhân sự cơ bản',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten' => 'PROJECT_MANAGER',
                'ten_hien_thi' => 'Quản lý dự án',
                'mo_ta' => 'Quản lý dự án, phân công công việc và theo dõi tiến độ',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten' => 'DEPARTMENT_HEAD',
                'ten_hien_thi' => 'Trưởng phòng',
                'mo_ta' => 'Quản lý nhân viên trong phòng ban, duyệt nghỉ phép và chấm công',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'ten' => 'CHIEF_ACCOUNTANT',
                'ten_hien_thi' => 'Kế toán trưởng',
                'mo_ta' => 'Quản lý tài chính, lương và các báo cáo tài chính',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
