<?php

namespace Database\Seeders;

use App\Models\PhanCong;
use App\Models\CongViec;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhanCongCongViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy user đầu tiên làm nguoi_giao_id và nguoi_nhan_id
        $nguoi_giao = User::find(1);  // Giả sử ID của admin
        $nguoi_nhan_1 = User::find(3);  // Giả sử ID của nhân viên
        $nguoi_nhan_2 = User::find(4);  // Giả sử ID của nhân viên khác

        // Đảm bảo có công việc tồn tại
        $congviec_id = CongViec::first()->id ?? 1;  // Lấy công việc đầu tiên nếu có, nếu không thì dùng giá trị mặc định

        $phancongs = [
            [
                'nguoi_giao_id' => $nguoi_giao->id ?? 1,  // Lấy ID của người giao từ cơ sở dữ liệu
                'nguoi_nhan_id' => $nguoi_nhan_1->id ?? 3,  // Lấy ID của người nhận từ cơ sở dữ liệu
                'phong_ban_id' => 2,  // Giả sử ID của phòng ban
                'cong_viec_id' => $congviec_id,  // ID công việc từ cơ sở dữ liệu
            ],
            [
                'nguoi_giao_id' => $nguoi_giao->id ?? 2,  // Lấy ID của người giao từ cơ sở dữ liệu
                'nguoi_nhan_id' => $nguoi_nhan_2->id ?? 4,  // Lấy ID của người nhận từ cơ sở dữ liệu
                'phong_ban_id' => 1,  // Giả sử ID của phòng ban
                'cong_viec_id' => $congviec_id,  // ID công việc từ cơ sở dữ liệu
            ],
            [
                'nguoi_giao_id' => $nguoi_giao->id ?? 1,  // Lấy ID của người giao từ cơ sở dữ liệu
                'nguoi_nhan_id' => 5,  // Giả sử ID của nhân viên
                'phong_ban_id' => 3,  // Giả sử ID của phòng ban
                'cong_viec_id' => $congviec_id,  // ID công việc từ cơ sở dữ liệu
            ]
        ];

        foreach ($phancongs as $phancongs) {
            PhanCong::create($phancongs);
        }
    }
}
