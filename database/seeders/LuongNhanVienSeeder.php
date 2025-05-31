<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use App\Models\BangLuong;
use App\Models\NguoiDung;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LuongNhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create('vi_VN');

        // Lấy danh sách bang_luong_id và nguoi_dung_id có sẵn
        $bangLuongIds = BangLuong::pluck('id')->toArray();
        $nguoiDungIds = NguoiDung::pluck('id')->toArray();

        if (empty($bangLuongIds) || empty($nguoiDungIds)) {
            $this->command->info('Cần có dữ liệu trong bảng bang_luong và nguoi_dung trước');
            return;
        }

        $luongNhanVienData = [];

        foreach ($bangLuongIds as $bangLuongId) {
            // Tạo lương cho một số nhân viên ngẫu nhiên
            $selectedNhanVien = $faker->randomElements($nguoiDungIds, $faker->numberBetween(5, min(15, count($nguoiDungIds))));

            foreach ($selectedNhanVien as $nguoiDungId) {
                $luongCoBan = $faker->numberBetween(8000000, 25000000);
                $tongPhuCap = $faker->numberBetween(500000, 3000000);
                $tongKhauTru = $faker->numberBetween(800000, 2500000);
                $tongLuong = $luongCoBan + $tongPhuCap;
                $luongThucNhan = $tongLuong - $tongKhauTru;

                $luongNhanVienData[] = [
                    'bang_luong_id' => $bangLuongId,
                    'nguoi_dung_id' => $nguoiDungId,
                    'luong_co_ban' => $luongCoBan,
                    'tong_phu_cap' => $tongPhuCap,
                    'tong_khau_tru' => $tongKhauTru,
                    'tong_luong' => $tongLuong,
                    'luong_thuc_nhan' => $luongThucNhan,
                    'so_ngay_cong' => $faker->randomFloat(1, 20, 26),
                    'gio_tang_ca' => $faker->randomFloat(1, 0, 40),
                    'ghi_chu' => $faker->optional(0.3)->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert dữ liệu theo batch để tối ưu performance
        $chunks = array_chunk($luongNhanVienData, 100);
        foreach ($chunks as $chunk) {
            DB::table('luong_nhan_vien')->insert($chunk);
        }

        $this->command->info('Đã tạo ' . count($luongNhanVienData) . ' bản ghi lương nhân viên');
    }
}
