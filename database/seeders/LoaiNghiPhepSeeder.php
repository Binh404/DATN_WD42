<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoaiNghiPhepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('loai_nghi_phep')->insert([
            [
                'ten' => 'Nghỉ phép năm',
                'ma' => 'NP_NAM',
                'mo_ta' => 'Nghỉ phép hàng năm theo quy định của công ty',
                'so_ngay_nam' => 12,
                'toi_da_ngay_lien_tiep' => 7,
                'so_ngay_bao_truoc' => 3,
                'cho_phep_chuyen_nam' => true,
                'toi_da_ngay_chuyen' => 5,
                'gioi_tinh_ap_dung' => 'tat_ca',
                'yeu_cau_giay_to' => false,
                'co_luong' => true,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Nghỉ ốm',
                'ma' => 'NGHI_OM',
                'mo_ta' => 'Nghỉ ốm có giấy bác sĩ chứng nhận',
                'so_ngay_nam' => 30,
                'toi_da_ngay_lien_tiep' => 20,
                'so_ngay_bao_truoc' => 0,
                'cho_phep_chuyen_nam' => false,
                'toi_da_ngay_chuyen' => 0,
                'gioi_tinh_ap_dung' => 'tat_ca',
                'yeu_cau_giay_to' => true,
                'co_luong' => true,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Nghỉ thai sản',
                'ma' => 'THAI_SAN',
                'mo_ta' => 'Nghỉ thai sản dành cho nữ nhân viên',
                'so_ngay_nam' => 180,
                'toi_da_ngay_lien_tiep' => 30,
                'so_ngay_bao_truoc' => 30,
                'cho_phep_chuyen_nam' => false,
                'toi_da_ngay_chuyen' => 0,
                'gioi_tinh_ap_dung' => 'nu',
                'yeu_cau_giay_to' => true,
                'co_luong' => true,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Nghỉ kết hôn',
                'ma' => 'KET_HON',
                'mo_ta' => 'Nghỉ phép kết hôn theo quy định pháp luật',
                'so_ngay_nam' => 4,
                'toi_da_ngay_lien_tiep' => 4,
                'so_ngay_bao_truoc' => 7,
                'cho_phep_chuyen_nam' => false,
                'toi_da_ngay_chuyen' => 0,
                'gioi_tinh_ap_dung' => 'tat_ca',
                'yeu_cau_giay_to' => true,
                'co_luong' => true,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Nghỉ tang',
                'ma' => 'NGHI_TANG',
                'mo_ta' => 'Nghỉ phép tang lễ người thân',
                'so_ngay_nam' => 3,
                'toi_da_ngay_lien_tiep' => 3,
                'so_ngay_bao_truoc' => 0,
                'cho_phep_chuyen_nam' => false,
                'toi_da_ngay_chuyen' => 0,
                'gioi_tinh_ap_dung' => 'tat_ca',
                'yeu_cau_giay_to' => true,
                'co_luong' => true,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Nghỉ không lương',
                'ma' => 'KHONG_LUONG',
                'mo_ta' => 'Nghỉ phép không hưởng lương',
                'so_ngay_nam' => 365,
                'toi_da_ngay_lien_tiep' => 30,
                'so_ngay_bao_truoc' => 7,
                'cho_phep_chuyen_nam' => false,
                'toi_da_ngay_chuyen' => 0,
                'gioi_tinh_ap_dung' => 'tat_ca',
                'yeu_cau_giay_to' => false,
                'co_luong' => false,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten' => 'Nghỉ đột xuất',
                'ma' => 'DOT_XUAT',
                'mo_ta' => 'Nghỉ đột xuất có lý do cấp bách',
                'so_ngay_nam' => 5,
                'toi_da_ngay_lien_tiep' => 2,
                'so_ngay_bao_truoc' => 0,
                'cho_phep_chuyen_nam' => false,
                'toi_da_ngay_chuyen' => 0,
                'gioi_tinh_ap_dung' => 'tat_ca',
                'yeu_cau_giay_to' => false,
                'co_luong' => true,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}