<?php

namespace Database\Seeders;

use App\Models\CongViec;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CongViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $congviecs = [
            [
                'ten_cong_viec' => 'Phân tích yêu cầu hệ thống',
                'mo_ta' => 'Phân tích yêu cầu và thiết kế hệ thống phần mềm.',
                'trang_thai' => 'Chưa bắt đầu',
                'do_uu_tien' => 'Cao',
                'ngay_bat_dau' => now(),
                'deadline' => now()->addDays(7),
                'ngay_hoan_thanh' => null,
            ],
            [
                'ten_cong_viec' => 'Thiết kế giao diện người dùng',
                'mo_ta' => 'Thiết kế giao diện và trải nghiệm người dùng cho phần mềm.',
                'trang_thai' => 'Đang làm',
                'do_uu_tien' => 'Trung bình',
                'ngay_bat_dau' => now(),
                'deadline' => now()->addDays(10),
                'ngay_hoan_thanh' => null,
            ],
            [
                'ten_cong_viec' => 'Lập trình chức năng',
                'mo_ta' => 'Phát triển các tính năng của phần mềm theo yêu cầu.',
                'trang_thai' => 'Hoàn thành',
                'do_uu_tien' => 'Cao',
                'ngay_bat_dau' => now()->subDays(5),
                'deadline' => now()->subDays(2),
                'ngay_hoan_thanh' => now()->subDays(2),
            ]
        ];
        foreach ($congviecs as $congviec) {
            CongViec::create($congviec);
        }
    }
}
