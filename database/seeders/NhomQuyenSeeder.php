<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NhomQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nhom_quyen')->insert([
             [
                'id' => 1,
                'ten' => 'Quản lý người dùng',
                'ma' => 'QLND',
                'mo_ta' => 'Các quyền liên quan đến quản lý người dùng và tài khoản',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten' => 'Quản lý nhân sự',
                'ma' => 'QLNS',
                'mo_ta' => 'Các quyền liên quan đến quản lý hồ sơ nhân viên và hợp đồng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten' => 'Quản lý chấm công',
                'ma' => 'QLCC',
                'mo_ta' => 'Các quyền liên quan đến chấm công và điểm danh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten' => 'Quản lý nghỉ phép',
                'ma' => 'QLNP',
                'mo_ta' => 'Các quyền liên quan đến quản lý đơn nghỉ phép',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten' => 'Quản lý lương',
                'ma' => 'QLL',
                'mo_ta' => 'Các quyền liên quan đến quản lý bảng lương và tính lương',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten' => 'Quản lý tuyển dụng',
                'ma' => 'QLTD',
                'mo_ta' => 'Các quyền liên quan đến tuyển dụng và quản lý ứng viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'ten' => 'Quản lý công việc',
                'ma' => 'QLCV',
                'mo_ta' => 'Các quyền liên quan đến quản lý và phân công công việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'ten' => 'Quản lý báo cáo',
                'ma' => 'QLBC',
                'mo_ta' => 'Các quyền liên quan đến xem và tạo báo cáo hệ thống',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'ten' => 'Quản lý hệ thống',
                'ma' => 'QLHT',
                'mo_ta' => 'Các quyền liên quan đến cài đặt và quản trị hệ thống',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
