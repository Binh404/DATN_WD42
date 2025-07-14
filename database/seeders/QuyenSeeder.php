<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quyen')->insert([
            // Quyền quản lý người dùng
            // Quản lý người dùng
            [
                'ten' => 'user.view',
                'ten_hien_thi' => 'Xem người dùng',
                'mo_ta' => 'Xem danh sách và thông tin người dùng',
                'nhom_quyen_id' => 1,
                'phan_he' => 'users',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'user.create',
                'ten_hien_thi' => 'Tạo người dùng',
                'mo_ta' => 'Tạo mới tài khoản người dùng',
                'nhom_quyen_id' => 1,
                'phan_he' => 'users',
                'hanh_dong' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'user.edit',
                'ten_hien_thi' => 'Sửa người dùng',
                'mo_ta' => 'Chỉnh sửa thông tin người dùng',
                'nhom_quyen_id' => 1,
                'phan_he' => 'users',
                'hanh_dong' => 'edit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'user.delete',
                'ten_hien_thi' => 'Xóa người dùng',
                'mo_ta' => 'Xóa tài khoản người dùng',
                'nhom_quyen_id' => 1,
                'phan_he' => 'users',
                'hanh_dong' => 'delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Quản lý nhân sự
            [
                'ten' => 'hr.profile.view',
                'ten_hien_thi' => 'Xem hồ sơ nhân viên',
                'mo_ta' => 'Xem thông tin hồ sơ nhân viên',
                'nhom_quyen_id' => 2,
                'phan_he' => 'hr',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'hr.profile.edit',
                'ten_hien_thi' => 'Sửa hồ sơ nhân viên',
                'mo_ta' => 'Chỉnh sửa thông tin hồ sơ nhân viên',
                'nhom_quyen_id' => 2,
                'phan_he' => 'hr',
                'hanh_dong' => 'edit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'hr.contract.view',
                'ten_hien_thi' => 'Xem hợp đồng',
                'mo_ta' => 'Xem thông tin hợp đồng lao động',
                'nhom_quyen_id' => 2,
                'phan_he' => 'hr',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'hr.contract.manage',
                'ten_hien_thi' => 'Quản lý hợp đồng',
                'mo_ta' => 'Tạo, sửa, xóa hợp đồng lao động',
                'nhom_quyen_id' => 2,
                'phan_he' => 'hr',
                'hanh_dong' => 'manage',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Chấm công
            [
                'ten' => 'attendance.view',
                'ten_hien_thi' => 'Xem chấm công',
                'mo_ta' => 'Xem thông tin chấm công',
                'nhom_quyen_id' => 3,
                'phan_he' => 'attendance',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'attendance.checkin',
                'ten_hien_thi' => 'Check in/out',
                'mo_ta' => 'Thực hiện check in/out',
                'nhom_quyen_id' => 3,
                'phan_he' => 'attendance',
                'hanh_dong' => 'checkin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'attendance.approve',
                'ten_hien_thi' => 'Duyệt chấm công',
                'mo_ta' => 'Phê duyệt thông tin chấm công',
                'nhom_quyen_id' => 3,
                'phan_he' => 'attendance',
                'hanh_dong' => 'approve',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Nghỉ phép
            [
                'ten' => 'leave.view',
                'ten_hien_thi' => 'Xem đơn nghỉ phép',
                'mo_ta' => 'Xem thông tin đơn nghỉ phép',
                'nhom_quyen_id' => 4,
                'phan_he' => 'leave',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'leave.create',
                'ten_hien_thi' => 'Tạo đơn nghỉ phép',
                'mo_ta' => 'Tạo đơn xin nghỉ phép',
                'nhom_quyen_id' => 4,
                'phan_he' => 'leave',
                'hanh_dong' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'leave.approve',
                'ten_hien_thi' => 'Duyệt đơn nghỉ phép',
                'mo_ta' => 'Phê duyệt đơn xin nghỉ phép',
                'nhom_quyen_id' => 4,
                'phan_he' => 'leave',
                'hanh_dong' => 'approve',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Lương
            [
                'ten' => 'payroll.view',
                'ten_hien_thi' => 'Xem bảng lương',
                'mo_ta' => 'Xem thông tin bảng lương',
                'nhom_quyen_id' => 5,
                'phan_he' => 'payroll',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'payroll.manage',
                'ten_hien_thi' => 'Quản lý lương',
                'mo_ta' => 'Tạo và quản lý bảng lương',
                'nhom_quyen_id' => 5,
                'phan_he' => 'payroll',
                'hanh_dong' => 'manage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'payroll.approve',
                'ten_hien_thi' => 'Duyệt bảng lương',
                'mo_ta' => 'Phê duyệt bảng lương',
                'nhom_quyen_id' => 5,
                'phan_he' => 'payroll',
                'hanh_dong' => 'approve',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Tuyển dụng
            [
                'ten' => 'recruitment.view',
                'ten_hien_thi' => 'Xem tin tuyển dụng',
                'mo_ta' => 'Xem thông tin tuyển dụng',
                'nhom_quyen_id' => 6,
                'phan_he' => 'recruitment',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'recruitment.post',
                'ten_hien_thi' => 'Đăng tin tuyển dụng',
                'mo_ta' => 'Tạo và đăng tin tuyển dụng',
                'nhom_quyen_id' => 6,
                'phan_he' => 'recruitment',
                'hanh_dong' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'recruitment.manage_candidates',
                'ten_hien_thi' => 'Quản lý ứng viên',
                'mo_ta' => 'Quản lý hồ sơ ứng viên',
                'nhom_quyen_id' => 6,
                'phan_he' => 'recruitment',
                'hanh_dong' => 'manage',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Quản lý công việc
            [
                'ten' => 'task.view',
                'ten_hien_thi' => 'Xem công việc',
                'mo_ta' => 'Xem danh sách công việc',
                'nhom_quyen_id' => 7,
                'phan_he' => 'tasks',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'task.create',
                'ten_hien_thi' => 'Tạo công việc',
                'mo_ta' => 'Tạo mới công việc',
                'nhom_quyen_id' => 7,
                'phan_he' => 'tasks',
                'hanh_dong' => 'create',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'task.assign',
                'ten_hien_thi' => 'Phân công công việc',
                'mo_ta' => 'Phân công công việc cho nhân viên',
                'nhom_quyen_id' => 7,
                'phan_he' => 'tasks',
                'hanh_dong' => 'assign',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Báo cáo
            [
                'ten' => 'report.attendance',
                'ten_hien_thi' => 'Báo cáo chấm công',
                'mo_ta' => 'Xem báo cáo chấm công',
                'nhom_quyen_id' => 8,
                'phan_he' => 'reports',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'report.payroll',
                'ten_hien_thi' => 'Báo cáo lương',
                'mo_ta' => 'Xem báo cáo lương',
                'nhom_quyen_id' => 8,
                'phan_he' => 'reports',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'report.hr',
                'ten_hien_thi' => 'Báo cáo nhân sự',
                'mo_ta' => 'Xem báo cáo nhân sự',
                'nhom_quyen_id' => 8,
                'phan_he' => 'reports',
                'hanh_dong' => 'view',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Cài đặt hệ thống
            [
                'ten' => 'system.settings',
                'ten_hien_thi' => 'Cài đặt hệ thống',
                'mo_ta' => 'Quản lý cài đặt hệ thống',
                'nhom_quyen_id' => 9,
                'phan_he' => 'system',
                'hanh_dong' => 'manage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'system.roles',
                'ten_hien_thi' => 'Quản lý vai trò',
                'mo_ta' => 'Quản lý vai trò và quyền',
                'nhom_quyen_id' => 9,
                'phan_he' => 'system',
                'hanh_dong' => 'manage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'system.backup',
                'ten_hien_thi' => 'Sao lưu dữ liệu',
                'mo_ta' => 'Thực hiện sao lưu dữ liệu',
                'nhom_quyen_id' => 9,
                'phan_he' => 'system',
                'hanh_dong' => 'backup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}