<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonXinNghiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('don_xin_nghi')->insert([
             [
                'ma_don_nghi' => 'DXN001',
                'nguoi_dung_id' => 1,
                'loai_nghi_phep_id' => 1,
                'ngay_bat_dau' => '2024-06-01',
                'ngay_ket_thuc' => '2024-06-03',
                'so_ngay_nghi' => 3.0,
                'ly_do' => 'Nghỉ phép thường niên',
                'tai_lieu_ho_tro' => null,
                'lien_he_khan_cap' => 'Nguyễn Văn B',
                'sdt_khan_cap' => '0987654321',
                'ban_giao_cho_id' => 2,
                'ghi_chu_ban_giao' => 'Bàn giao công việc A và B',
                'trang_thai' => 'da_duyet',
                'nguoi_duyet_id' => 3,
                'thoi_gian_duyet' => '2024-05-28 14:30:00',
                // 'ly_do_tu_choi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_don_nghi' => 'DXN002',
                'nguoi_dung_id' => 2,
                'loai_nghi_phep_id' => 2,
                'ngay_bat_dau' => '2024-06-15',
                'ngay_ket_thuc' => '2024-06-15',
                'so_ngay_nghi' => 1.0,
                'ly_do' => 'Đi khám bệnh',
                'tai_lieu_ho_tro' => '{"giay_hen_kham": "hen_kham_001.pdf"}',
                'lien_he_khan_cap' => 'Trần Thị C',
                'sdt_khan_cap' => '0912345678',
                'ban_giao_cho_id' => 1,
                'ghi_chu_ban_giao' => 'Hoàn thành báo cáo trước khi nghỉ',
                'trang_thai' => 'cho_duyet',
                'nguoi_duyet_id' => null,
                'thoi_gian_duyet' => null,
                // 'ly_do_tu_choi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_don_nghi' => 'DXN003',
                'nguoi_dung_id' => 4,
                'loai_nghi_phep_id' => 1,
                'ngay_bat_dau' => '2024-05-20',
                'ngay_ket_thuc' => '2024-05-22',
                'so_ngay_nghi' => 3.0,
                'ly_do' => 'Về quê thăm gia đình',
                'tai_lieu_ho_tro' => null,
                'lien_he_khan_cap' => 'Lê Văn D',
                'sdt_khan_cap' => '0901234567',
                'ban_giao_cho_id' => 5,
                'ghi_chu_ban_giao' => 'Đã hoàn thành tất cả công việc',
                'trang_thai' => 'tu_choi',
                'nguoi_duyet_id' => 3,
                'thoi_gian_duyet' => '2024-05-18 10:15:00',
                // 'ly_do_tu_choi' => 'Thời gian nghỉ trùng với dự án quan trọng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_don_nghi' => 'DXN004',
                'nguoi_dung_id' => 3,
                'loai_nghi_phep_id' => 3,
                'ngay_bat_dau' => '2024-07-01',
                'ngay_ket_thuc' => '2024-07-05',
                'so_ngay_nghi' => 5.0,
                'ly_do' => 'Nghỉ hè với gia đình',
                'tai_lieu_ho_tro' => null,
                'lien_he_khan_cap' => 'Phạm Thị E',
                'sdt_khan_cap' => '0923456789',
                'ban_giao_cho_id' => 1,
                'ghi_chu_ban_giao' => 'Bàn giao dự án X và follow up khách hàng Y',
                'trang_thai' => 'huy_bo',
                'nguoi_duyet_id' => null,
                'thoi_gian_duyet' => null,
                // 'ly_do_tu_choi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ma_don_nghi' => 'DXN005',
                'nguoi_dung_id' => 5,
                'loai_nghi_phep_id' => 1,
                'ngay_bat_dau' => '2024-06-10',
                'ngay_ket_thuc' => '2024-06-12',
                'so_ngay_nghi' => 3.0,
                'ly_do' => 'Tham dự đám cưới bạn bè',
                'tai_lieu_ho_tro' => '{"thiep_cuoi": "thiep_001.jpg"}',
                'lien_he_khan_cap' => 'Hoàng Văn F',
                'sdt_khan_cap' => '0934567890',
                'ban_giao_cho_id' => 2,
                'ghi_chu_ban_giao' => 'Chuyển giao nhiệm vụ support khách hàng',
                'trang_thai' => 'da_duyet',
                // 'nguoi_duyet_id' => 3,
                'thoi_gian_duyet' => '2024-06-05 16:20:00',
                // 'ly_do_tu_choi' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
