<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaiLieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tai_lieu')->insert([
            [
                'id' => 1,
                'nguoi_dung_id' => 1,
                'ung_vien_id' => null,
                'loai_tai_lieu' => 'hop_dong',
                'tieu_de' => 'Hợp đồng lao động',
                'mo_ta' => 'Hợp đồng lao động chính thức',
                'ten_file_goc' => 'hop_dong_nguyen_van_a.pdf',
                'duong_dan_file' => '/storage/documents/hop_dong_nguyen_van_a.pdf',
                'kich_thuoc_file' => 1024000,
                'loai_mime' => 'application/pdf',
                'bao_mat' => true,
                'ngay_het_han' => null,
                'nguoi_tai_len_id' => 1,
                'thoi_gian_tai_len' => now(),
                'trang_thai' => 'hop_le',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nguoi_dung_id' => 2,
                'ung_vien_id' => null,
                'loai_tai_lieu' => 'bang_cap',
                'tieu_de' => 'Bằng đại học',
                'mo_ta' => 'Bằng tốt nghiệp đại học',
                'ten_file_goc' => 'bang_dai_hoc_tran_thi_b.jpg',
                'duong_dan_file' => '/storage/documents/bang_dai_hoc_tran_thi_b.jpg',
                'kich_thuoc_file' => 2048000,
                'loai_mime' => 'image/jpeg',
                'bao_mat' => false,
                'ngay_het_han' => null,
                'nguoi_tai_len_id' => 2,
                'thoi_gian_tai_len' => now(),
                'trang_thai' => 'hop_le',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nguoi_dung_id' => 3,
                'ung_vien_id' => null,
                'loai_tai_lieu' => 'chung_chi',
                'tieu_de' => 'Chứng chỉ TOEIC',
                'mo_ta' => 'Chứng chỉ TOEIC 850 điểm',
                'ten_file_goc' => 'toeic_le_van_c.pdf',
                'duong_dan_file' => '/storage/documents/toeic_le_van_c.pdf',
                'kich_thuoc_file' => 512000,
                'loai_mime' => 'application/pdf',
                'bao_mat' => false,
                'ngay_het_han' => '2026-12-31',
                'nguoi_tai_len_id' => 3,
                'thoi_gian_tai_len' => now(),
                'trang_thai' => 'hop_le',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nguoi_dung_id' => null,
                'ung_vien_id' => 1,
                'loai_tai_lieu' => 'cv',
                'tieu_de' => 'CV ứng viên',
                'mo_ta' => 'Hồ sơ xin việc',
                'ten_file_goc' => 'cv_pham_van_d.pdf',
                'duong_dan_file' => '/storage/cv/cv_pham_van_d.pdf',
                'kich_thuoc_file' => 800000,
                'loai_mime' => 'application/pdf',
                'bao_mat' => false,
                'ngay_het_han' => null,
                'nguoi_tai_len_id' => 1,
                'thoi_gian_tai_len' => now(),
                'trang_thai' => 'hop_le',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nguoi_dung_id' => 4,
                'ung_vien_id' => null,
                'loai_tai_lieu' => 'khac',
                'tieu_de' => 'Giấy khám sức khỏe',
                'mo_ta' => 'Giấy khám sức khỏe định kỳ',
                'ten_file_goc' => 'kham_suc_khoe_hoang_thi_e.pdf',
                'duong_dan_file' => '/storage/documents/kham_suc_khoe_hoang_thi_e.pdf',
                'kich_thuoc_file' => 300000,
                'loai_mime' => 'application/pdf',
                'bao_mat' => true,
                'ngay_het_han' => '2025-12-31',
                'nguoi_tai_len_id' => 4,
                'thoi_gian_tai_len' => now(),
                'trang_thai' => 'hop_le',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
