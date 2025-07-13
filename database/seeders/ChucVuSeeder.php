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
                // 'phong_ban_id' => 1, mấy cái t xóa ở dưới là những cái t cmt này tại thấy không cần thiết
                // 'cap_do' => 10,
                'luong_co_ban' => 30000000, // Salary per day
                // 'trach_nhiem' => json_encode(['Điều hành công ty', 'Đưa ra quyết định chiến lược', 'Quản lý tổng thể']),
                // 'yeu_cau' => json_encode(['Tốt nghiệp Đại học', 'Kinh nghiệm quản lý 10+ năm', 'Kỹ năng lãnh đạo']),
                'he_so_luong' => 4.0,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten' => 'Trưởng Phòng Nhân Sự',
                'ma' => 'TP_HR',
                'mo_ta' => 'Trưởng phòng nhân sự',
                'luong_co_ban' => 15000000,
                'he_so_luong' => 1.5,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten' => 'Nhân Viên Nhân Sự',
                'ma' => 'NV_HR',
                'mo_ta' => 'Nhân viên phòng nhân sự',
                'luong_co_ban' => 9000000,
                'he_so_luong' => 1,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten' => 'Trưởng Phòng IT',
                'ma' => 'TP_IT',
                'mo_ta' => 'Trưởng phòng công nghệ thông tin',
                'luong_co_ban' => 12000000,
                'he_so_luong' => 1.2,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten' => 'Lập Trình Viên Senior',
                'ma' => 'DEV_SR',
                'mo_ta' => 'Lập trình viên cấp cao',
               'luong_co_ban' => 17000000,
               'he_so_luong' => 1,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten' => 'Lập Trình Viên',
                'ma' => 'DEV',
                'mo_ta' => 'Lập trình viên',
                'luong_co_ban' => 21000000,
                'he_so_luong' => 1,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'ten' => 'Trưởng Phòng Kế Toán',
                'ma' => 'TP_KT',
                'mo_ta' => 'Trưởng phòng kế toán',
                'luong_co_ban' => 22000000,
                'he_so_luong' => 1,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'ten' => 'Nhân Viên Kế Toán',
                'ma' => 'NV_KT',
                'mo_ta' => 'Nhân viên kế toán',
                'luong_co_ban' => 20000000,
                'he_so_luong' => 1,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
