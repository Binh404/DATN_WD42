<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HopDongLaoDongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('hop_dong_lao_dong')->insert([
                 [
                'nguoi_dung_id' => 1,
                'so_hop_dong' => 'HD001-2024',
                'loai_hop_dong' => 'khong_xac_dinh_thoi_han',
                'ngay_bat_dau' => '2024-01-15',
                'ngay_ket_thuc' => null,
                'luong_co_ban' => 15000000,
                'duong_dan_file' => '/storage/hop-dong/HD001-2024.pdf',
                'dieu_khoan' => 'Thực hiện đúng quy định của công ty, bảo mật thông tin.',
                'trang_thai' => 'hieu_luc',
                'nguoi_ky_id' => 2,
                'thoi_gian_ky' => '2024-01-15 09:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'so_hop_dong' => 'HD002-2024',
                'loai_hop_dong' => 'xac_dinh_thoi_han',
                'ngay_bat_dau' => '2024-02-01',
                'ngay_ket_thuc' => '2025-01-31',
                'luong_co_ban' => 12000000,
                'duong_dan_file' => '/storage/hop-dong/HD002-2024.pdf',
                'dieu_khoan' => 'Hợp đồng 1 năm, có thể gia hạn theo thỏa thuận.',
                'trang_thai' => 'hieu_luc',
                'nguoi_ky_id' => 2,
                'thoi_gian_ky' => '2024-02-01 14:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'so_hop_dong' => 'HD003-2024',
                'loai_hop_dong' => 'thu_viec',
                'ngay_bat_dau' => '2024-03-01',
                'ngay_ket_thuc' => '2024-04-30',
                'luong_co_ban' => 8000000,
                'duong_dan_file' => '/storage/hop-dong/HD003-2024.pdf',
                'dieu_khoan' => 'Thử việc 2 tháng, lương 80% mức chính thức.',
                'trang_thai' => 'het_han',
                'nguoi_ky_id' => 2,
                'thoi_gian_ky' => '2024-03-01 10:15:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'so_hop_dong' => 'HD004-2024',
                'loai_hop_dong' => 'mua_vu',
                'ngay_bat_dau' => '2024-06-01',
                'ngay_ket_thuc' => '2024-08-31',
                'luong_co_ban' => 10000000,
                'duong_dan_file' => '/storage/hop-dong/HD004-2024.pdf',
                'dieu_khoan' => 'Hợp đồng mùa vụ 3 tháng, làm việc theo dự án.',
                'trang_thai' => 'hieu_luc',
                'nguoi_ky_id' => 1,
                'thoi_gian_ky' => '2024-06-01 08:45:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
    ]);
    }
}
