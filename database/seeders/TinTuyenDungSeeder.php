<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TinTuyenDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('tin_tuyen_dung')->insert([
            [
                'id' => 1,
                'tieu_de' => 'Tuyển dụng Lập trình viên PHP',
                'ma' => 'TD001',
                'phong_ban_id' => 1,
                'chuc_vu_id' => 3,
                'chi_nhanh_id' => 1,
                'loai_hop_dong' => 'xac_dinh_thoi_han',
                'cap_do_kinh_nghiem' => 'junior',
                'kinh_nghiem_toi_thieu' => 1,
                'kinh_nghiem_toi_da' => 3,
                'luong_toi_thieu' => 10000000,
                'luong_toi_da' => 15000000,
                'so_vi_tri' => 2,
                'mo_ta_cong_viec' => 'Phát triển ứng dụng web bằng PHP Laravel',
                'phuc_loi' => json_encode(['có kinh nghiệm PHP', 'Laravel', 'MySQL']),
                'yeu_cau' => json_encode(['PHP', 'Laravel', 'MySQL', 'Javascript']),
                'ky_nang_yeu_cau' => json_encode(['PHP', 'Laravel', 'MySQL', 'Javascript']),
                'trinh_do_hoc_van' => 'Đại học',
                'han_nop_ho_so' => '2025-07-31',
                'lam_viec_tu_xa' => false,
                'tuyen_gap' => false,
                'trang_thai' => 'dang_tuyen',
                'nguoi_dang_id' => 1,
                'thoi_gian_dang' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'tieu_de' => 'Tuyển dụng Nhân viên Marketing',
                'ma' => 'TD002',
                'phong_ban_id' => 2,
                'chuc_vu_id' => 4,
                'chi_nhanh_id' => 1,
                'loai_hop_dong' => 'khong_xac_dinh_thoi_han',
                'cap_do_kinh_nghiem' => 'fresher',
                'kinh_nghiem_toi_thieu' => 0,
                'kinh_nghiem_toi_da' => 2,
                'luong_toi_thieu' => 8000000,
                'luong_toi_da' => 12000000,
                'so_vi_tri' => 1,
                'mo_ta_cong_viec' => 'Lập kế hoạch marketing, quản lý social media',
                'phuc_loi' => json_encode(['có kinh nghiệm PHP', 'Laravel', 'MySQL']),
                'yeu_cau' => json_encode(['PHP', 'Laravel', 'MySQL', 'Javascript']),
                'ky_nang_yeu_cau' => json_encode(['PHP', 'Laravel', 'MySQL', 'Javascript']),
                'trinh_do_hoc_van' => 'Cao đẳng',
                'han_nop_ho_so' => '2025-08-15',
                'lam_viec_tu_xa' => true,
                'tuyen_gap' => true,
                'trang_thai' => 'dang_tuyen',
                'nguoi_dang_id' => 2,
                'thoi_gian_dang' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'tieu_de' => 'Tuyển dụng Kế toán',
                'ma' => 'TD003',
                'phong_ban_id' => 3,
                'chuc_vu_id' => 5,
                'chi_nhanh_id' => 2,
                'loai_hop_dong' => 'xac_dinh_thoi_han',
                'cap_do_kinh_nghiem' => 'middle',
                'kinh_nghiem_toi_thieu' => 2,
                'kinh_nghiem_toi_da' => 5,
                'luong_toi_thieu' => 12000000,
                'luong_toi_da' => 18000000,
                'so_vi_tri' => 1,
                'mo_ta_cong_viec' => 'Thực hiện công tác kế toán tổng hợp',
                'phuc_loi' => json_encode(['có kinh nghiệm PHP', 'Laravel', 'MySQL']),
                'yeu_cau' => json_encode(['PHP', 'Laravel', 'MySQL', 'Javascript']),
                'ky_nang_yeu_cau' => json_encode(['PHP', 'Laravel', 'MySQL', 'Javascript']),
                'trinh_do_hoc_van' => 'Đại học',
                'han_nop_ho_so' => '2025-09-30',
                'lam_viec_tu_xa' => false,
                'tuyen_gap' => false,
                'trang_thai' => 'dang_tuyen',
                'nguoi_dang_id' => 1,
                'thoi_gian_dang' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
