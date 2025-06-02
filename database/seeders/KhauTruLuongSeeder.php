<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KhauTruLuongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('khau_tru_luong')->insert([
            [
                'luong_nhan_vien_id' => 1,
                'loai_khau_tru' => 'bhxh',
                'so_tien' => 2000000,
                'ghi_chu' => 'BHXH 8% lương cơ bản',
                'created_at' => now(),
            ],
            [
                'luong_nhan_vien_id' => 1,
                'loai_khau_tru' => 'bhyt',
                'so_tien' => 375000,
                'ghi_chu' => 'BHYT 1.5% lương cơ bản',
                'created_at' => now(),
            ],
            [
                'luong_nhan_vien_id' => 1,
                'loai_khau_tru' => 'bhtn',
                'so_tien' => 250000,
                'ghi_chu' => 'BHTN 1% lương cơ bản',
                'created_at' => now(),
            ],
            [
                'luong_nhan_vien_id' => 1,
                'loai_khau_tru' => 'thue_tncn',
                'so_tien' => 575000,
                'ghi_chu' => 'Thuế TNCN theo bậc thuế',
                'created_at' => now(),
            ]
         ]);
    }
}
