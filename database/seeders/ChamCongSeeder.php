<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChamCongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();
        $chamCongs = [];

        // Tạo dữ liệu chấm công cho 30 ngày gần đây
        for ($i = 0; $i < 100; $i++) {
            $ngay = $today->copy()->subDays($i);

            // Bỏ qua thứ 7 và chủ nhật
            if ($ngay->isWeekend()) continue;

            $chamCongs[] = [
                'nguoi_dung_id' => 1,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:15:00',
                'gio_ra' => '17:45:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 15,
                'phut_ve_som' => 0,
                'trang_thai' => 'di_muon',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 5',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 5',
                'dia_chi_ip' => '192.168.1.100',
                'ghi_chu' => 'Đi muộn do kẹt xe',
                'trang_thai_duyet' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $chamCongs[] = [
                'nguoi_dung_id' => 2,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:00:00',
                'gio_ra' => '17:30:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 0,
                'phut_ve_som' => 0,
                'trang_thai' => 'binh_thuong',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 3',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 3',
                'dia_chi_ip' => '192.168.1.101',
                'ghi_chu' => '',
                'trang_thai_duyet' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $chamCongs[] = [
                'nguoi_dung_id' => 3,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:00:00',
                'gio_ra' => '17:30:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 0,
                'phut_ve_som' => 0,
                'trang_thai' => 'binh_thuong',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 3',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 3',
                'dia_chi_ip' => '192.168.1.101',
                'ghi_chu' => '',
                'trang_thai_duyet' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ];
            $chamCongs[] = [
                'nguoi_dung_id' => 4,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:00:00',
                'gio_ra' => '17:30:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 0,
                'phut_ve_som' => 0,
                'trang_thai' => 'binh_thuong',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 3',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 3',
                'dia_chi_ip' => '192.168.1.101',
                'ghi_chu' => '',
                'trang_thai_duyet' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ];
            $chamCongs[] = [
                'nguoi_dung_id' => 5,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:00:00',
                'gio_ra' => '17:30:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 0,
                'phut_ve_som' => 0,
                'trang_thai' => 'binh_thuong',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 3',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 3',
                'dia_chi_ip' => '192.168.1.101',
                'ghi_chu' => '',
                'trang_thai_duyet' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ];
            $chamCongs[] = [
                'nguoi_dung_id' => 6,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:00:00',
                'gio_ra' => '17:30:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 0,
                'phut_ve_som' => 0,
                'trang_thai' => 'binh_thuong',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 3',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 3',
                'dia_chi_ip' => '192.168.1.101',
                'ghi_chu' => '',
                'trang_thai_duyet' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ];
            $chamCongs[] = [
                'nguoi_dung_id' => 7,
                'ngay_cham_cong' => $ngay->format('Y-m-d'),
                'gio_vao' => '08:00:00',
                'gio_ra' => '17:30:00',
                'so_gio_lam' => 8.5,
                'so_cong' => 1.0,
                'gio_tang_ca' => 0.5,
                'phut_di_muon' => 0,
                'phut_ve_som' => 0,
                'trang_thai' => 'binh_thuong',
                'vi_tri_check_in' => 'Tòa nhà ABC, Tầng 3',
                'vi_tri_check_out' => 'Tòa nhà ABC, Tầng 3',
                'dia_chi_ip' => '192.168.1.101',
                'ghi_chu' => '',
                'trang_thai_duyet' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('cham_cong')->insert($chamCongs);

    }
}
