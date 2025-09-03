<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LuongNhanVien;
use App\Models\BangLuong;

class UpdateLuongNhanVienThangNamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cập nhật dữ liệu cũ để có thông tin tháng/năm lương
        $luongNhanViens = LuongNhanVien::whereNull('luong_thang')
            ->orWhereNull('luong_nam')
            ->get();

        foreach ($luongNhanViens as $luong) {
            // Lấy thông tin từ bảng bang_luong
            $bangLuong = BangLuong::find($luong->bang_luong_id);
            
            if ($bangLuong) {
                $luong->update([
                    'luong_thang' => $bangLuong->thang,
                    'luong_nam' => $bangLuong->nam
                ]);
            } else {
                // Nếu không có bang_luong, sử dụng created_at
                $luong->update([
                    'luong_thang' => $luong->created_at->month,
                    'luong_nam' => $luong->created_at->year
                ]);
            }
        }

        $this->command->info('Đã cập nhật thông tin tháng/năm lương cho ' . $luongNhanViens->count() . ' bản ghi.');
    }
}
