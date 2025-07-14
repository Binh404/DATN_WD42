<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy ID các phòng ban theo mã
        $banGiamDocId = DB::table('phong_ban')->where('ma_phong_ban', 'BGD')->value('id');
        $phongHRId    = DB::table('phong_ban')->where('ma_phong_ban', 'HR')->value('id');
        $phongITId    = DB::table('phong_ban')->where('ma_phong_ban', 'IT')->value('id');
        $phongKTId    = DB::table('phong_ban')->where('ma_phong_ban', 'KT')->value('id');

        DB::table('chuc_vu')->insert([
            [
                'id' => 1,
                'ten' => 'Giám Đốc',
                'ma' => 'GD',
                'mo_ta' => 'Giám đốc công ty',
                'phong_ban_id' => $banGiamDocId,
                'luong_co_ban' => 30000000,
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
                'phong_ban_id' => $phongHRId,
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
                'phong_ban_id' => $phongHRId,
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
                'phong_ban_id' => $phongITId,
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
                'phong_ban_id' => $phongITId,
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
                'phong_ban_id' => $phongITId,
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
                'phong_ban_id' => $phongKTId,
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
                'phong_ban_id' => $phongKTId,
                'luong_co_ban' => 20000000,
                'he_so_luong' => 1,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}