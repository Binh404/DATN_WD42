<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LichSuYeuCauTuyenDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lich_su_duyet_yeu_cau_tuyen_dung')->insert([
            [
                'yeu_cau_id' => 3,
                'nguoi_duyet_id' => 3,
                'hanh_dong' => 'duyet',
                'ghi_chu' => 'Duyệt yêu cầu nhanh để bổ sung nhân sự kịp thời.',
                'thoi_gian' => now(),
                'created_at' => now(),
            ],
            [
                'yeu_cau_id' => 4,
                'nguoi_duyet_id' => 3,
                'hanh_dong' => 'tu_choi',
                'ghi_chu' => 'Chưa cần tuyển thêm nhân viên marketing.',
                'thoi_gian' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}
