<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class ChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacadesDB::table('chuc_vu')->insert([
            [
                'id' => 1,
                'ten' => 'Giám Đốc',
                'ma' => 'GD',
                'mo_ta' => 'Giám đốc công ty',
                'phong_ban_id' => 1,
                'cap_do' => 10,
                'luong_toi_thieu' => 50000000,
                'luong_toi_da' => 100000000,
                'trach_nhiem' => json_encode(['Điều hành công ty', 'Đưa ra quyết định chiến lược', 'Quản lý tổng thể']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học', 'Kinh nghiệm quản lý 10+ năm', 'Kỹ năng lãnh đạo']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten' => 'Trưởng Phòng Nhân Sự',
                'ma' => 'TP_HR',
                'mo_ta' => 'Trưởng phòng nhân sự',
                'phong_ban_id' => 2,
                'cap_do' => 8,
                'luong_toi_thieu' => 25000000,
                'luong_toi_da' => 40000000,
                'trach_nhiem' => json_encode(['Quản lý nhân sự', 'Tuyển dụng', 'Đào tạo']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học chuyên ngành HR', 'Kinh nghiệm 5+ năm']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten' => 'Nhân Viên Nhân Sự',
                'ma' => 'NV_HR',
                'mo_ta' => 'Nhân viên phòng nhân sự',
                'phong_ban_id' => 2,
                'cap_do' => 5,
                'luong_toi_thieu' => 12000000,
                'luong_toi_da' => 20000000,
                'trach_nhiem' => json_encode(['Hỗ trợ tuyển dụng', 'Quản lý hồ sơ nhân viên']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học', 'Kinh nghiệm 1-3 năm']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten' => 'Trưởng Phòng IT',
                'ma' => 'TP_IT',
                'mo_ta' => 'Trưởng phòng công nghệ thông tin',
                'phong_ban_id' => 4,
                'cap_do' => 8,
                'luong_toi_thieu' => 30000000,
                'luong_toi_da' => 50000000,
                'trach_nhiem' => json_encode(['Quản lý hệ thống IT', 'Phát triển phần mềm', 'Bảo mật thông tin']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học IT', 'Kinh nghiệm 7+ năm', 'Kỹ năng lãnh đạo']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten' => 'Lập Trình Viên Senior',
                'ma' => 'DEV_SR',
                'mo_ta' => 'Lập trình viên cấp cao',
                'phong_ban_id' => 4,
                'cap_do' => 7,
                'luong_toi_thieu' => 20000000,
                'luong_toi_da' => 35000000,
                'trach_nhiem' => json_encode(['Phát triển ứng dụng', 'Code review', 'Mentor junior']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học IT', 'Kinh nghiệm 5+ năm', 'Thành thạo nhiều ngôn ngữ lập trình']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten' => 'Lập Trình Viên',
                'ma' => 'DEV',
                'mo_ta' => 'Lập trình viên',
                'phong_ban_id' => 4,
                'cap_do' => 5,
                'luong_toi_thieu' => 12000000,
                'luong_toi_da' => 25000000,
                'trach_nhiem' => json_encode(['Phát triển ứng dụng', 'Bảo trì hệ thống']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học IT', 'Kinh nghiệm 1-4 năm']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'ten' => 'Trưởng Phòng Kế Toán',
                'ma' => 'TP_KT',
                'mo_ta' => 'Trưởng phòng kế toán',
                'phong_ban_id' => 3,
                'cap_do' => 8,
                'luong_toi_thieu' => 25000000,
                'luong_toi_da' => 40000000,
                'trach_nhiem' => json_encode(['Quản lý tài chính', 'Lập báo cáo', 'Kiểm soát chi phí']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học Kế toán', 'Có chứng chỉ CPA', 'Kinh nghiệm 5+ năm']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'ten' => 'Nhân Viên Kế Toán',
                'ma' => 'NV_KT',
                'mo_ta' => 'Nhân viên kế toán',
                'phong_ban_id' => 3,
                'cap_do' => 5,
                'luong_toi_thieu' => 10000000,
                'luong_toi_da' => 18000000,
                'trach_nhiem' => json_encode(['Ghi sổ kế toán', 'Lập báo cáo tài chính']),
                'yeu_cau' => json_encode(['Tốt nghiệp Đại học Kế toán', 'Kinh nghiệm 1-3 năm']),
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
