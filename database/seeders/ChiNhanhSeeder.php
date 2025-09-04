<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChiNhanhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chi_nhanh')->insert([
            [
                'id' => 1,
                'ten' => 'Chi nhánh Hà Nội',
                'ma' => 'HN001',
                'dia_chi' => '123 Đường Láng, Đống Đa, Hà Nội',
                'so_dien_thoai' => '024-3456-7890',
                'email' => 'hanoi@company.com',
                'thanh_pho' => 'Hà Nội',
                'tinh_thanh' => 'Hà Nội',
                'ma_buu_dien' => '100000',
                'quan_ly_id' => null,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten' => 'Chi nhánh TP.HCM',
                'ma' => 'HCM001',
                'dia_chi' => '456 Nguyễn Văn Cừ, Quận 5, TP.HCM',
                'so_dien_thoai' => '028-3789-0123',
                'email' => 'hcm@company.com',
                'thanh_pho' => 'TP.HCM',
                'tinh_thanh' => 'TP.HCM',
                'ma_buu_dien' => '700000',
                'quan_ly_id' => null,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten' => 'Chi nhánh Đà Nẵng',
                'ma' => 'DN001',
                'dia_chi' => '789 Hùng Vương, Hải Châu, Đà Nẵng',
                'so_dien_thoai' => '0236-3567-8901',
                'email' => 'danang@company.com',
                'thanh_pho' => 'Đà Nẵng',
                'tinh_thanh' => 'Đà Nẵng',
                'ma_buu_dien' => '550000',
                'quan_ly_id' => null,
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
