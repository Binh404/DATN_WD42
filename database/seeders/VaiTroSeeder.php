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
                'ten_hien_thi' => 'Super Admin',
                'ten' => 'SUPER_ADMIN',
                'mo_ta' => 'Quyền cao nhất của hệ thống, có thể truy cập tất cả chức năng',
                'la_vai_tro_he_thong' => true,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten_hien_thi' => 'Quản trị viên',
                'ten' => 'ADMIN',
                'mo_ta' => 'Quản trị hệ thống, quản lý người dùng và cài đặt',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten_hien_thi' => 'Trưởng phòng nhân sự',
                'ten' => 'HR_MANAGER',
                'mo_ta' => 'Quản lý toàn bộ hoạt động nhân sự, tuyển dụng, lương và chấm công',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten_hien_thi' => 'Nhân viên nhân sự',
                'ten' => 'HR_STAFF',
                'mo_ta' => 'Thực hiện các công việc nhân sự cơ bản',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten_hien_thi' => 'Quản lý dự án',
                'ten' => 'PROJECT_MANAGER',
                'mo_ta' => 'Quản lý dự án, phân công công việc và theo dõi tiến độ',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten_hien_thi' => 'Trưởng phòng',
                'ten' => 'DEPARTMENT_HEAD',
                'mo_ta' => 'Quản lý nhân viên trong phòng ban, duyệt nghỉ phép và chấm công',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'ten_hien_thi' => 'Kế toán trưởng',
                'ten' => 'CHIEF_ACCOUNTANT',
                'mo_ta' => 'Quản lý tài chính, lương và các báo cáo tài chính',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'ten_hien_thi' => 'Nhân viên kế toán',
                'ten' => 'ACCOUNTANT',
                'mo_ta' => 'Thực hiện công việc kế toán, tính lương',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'ten_hien_thi' => 'Nhân viên',
                'ten' => 'EMPLOYEE',
                'mo_ta' => 'Nhân viên thông thường, chỉ có quyền cơ bản',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'ten_hien_thi' => 'Thực tập sinh',
                'ten' => 'INTERN',
                'mo_ta' => 'Thực tập sinh, quyền hạn chế',
                'la_vai_tro_he_thong' => false,
                'trang_thai' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
