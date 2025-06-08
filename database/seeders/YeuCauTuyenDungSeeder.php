<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YeuCauTuyenDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('yeu_cau_tuyen_dung')->insert([
            [
                'ma' => 'YC001',
                'phong_ban_id' => 1,
                'nguoi_tao_id' => 1,
                'chuc_vu_id' => 1,
                'loai_hop_dong' => 'chinh_thuc',
                'so_luong' => 3,
                'luong_toi_thieu' => 12000000,
                'luong_toi_da' => 19000000,
                'trinh_do_hoc_van' => 'Đại học',
                'kinh_nghiem_toi_thieu' => 3,
                'kinh_nghiem_toi_da' => 5,
                'yeu_cau' => 'Có ngoại ngữ',
                'ky_nang_yeu_cau' => 'PHP, Laravel',
                'ghi_chu' => 'abc',
                'mo_ta_cong_viec' => 'Phát triển, bảo trì ứng dụng web.',
                'trang_thai' => 'cho_duyet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma' => 'YC002',
                'phong_ban_id' => 2,
                'nguoi_tao_id' => 1,
                'chuc_vu_id' => 3,
                'loai_hop_dong' => 'chinh_thuc',
                'so_luong' => 3,
                'luong_toi_thieu' => 12000000,
                'luong_toi_da' => 19000000,
                'trinh_do_hoc_van' => 'Đại học',
                'kinh_nghiem_toi_thieu' => 3,
                'kinh_nghiem_toi_da' => 5,
                'yeu_cau' => 'Có ngoại ngữ',
                'ky_nang_yeu_cau' => 'PHP, Laravel',
                'ghi_chu' => 'abc',
                'mo_ta_cong_viec' => 'Phát triển, bảo trì ứng dụng web.',
                'trang_thai' => 'cho_duyet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
