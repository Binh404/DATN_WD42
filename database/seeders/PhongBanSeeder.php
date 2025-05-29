<?php

namespace Database\Seeders;

use App\Models\PhongBan;
use Illuminate\Database\Seeder;

class PhongBanSeeder extends Seeder
{
    public function run(): void
    {
        $phongbans = [
            [
                'ten_phong_ban' => 'Phòng Nhân sự',
                'ma_phong_ban' => 'PB001',
                'mo_ta' => 'Phụ trách công tác nhân sự, tuyển dụng và phát triển nguồn nhân lực của công ty',
                'trang_thai' => 1,
            ],
            [
                'ten_phong_ban' => 'Phòng Kỹ thuật',
                'ma_phong_ban' => 'PB002',
                'mo_ta' => 'Phụ trách các vấn đề kỹ thuật, phát triển và bảo trì hệ thống',
                'trang_thai' => 1,
            ],
            [
                'ten_phong_ban' => 'Phòng Kinh doanh',
                'ma_phong_ban' => 'PB003',
                'mo_ta' => 'Phụ trách hoạt động kinh doanh, bán hàng và phát triển thị trường',
                'trang_thai' => 1,
            ],
            [
                'ten_phong_ban' => 'Phòng Marketing',
                'ma_phong_ban' => 'PB004',
                'mo_ta' => 'Phụ trách chiến lược marketing, quảng bá thương hiệu và sản phẩm',
                'trang_thai' => 1,
            ],
            [
                'ten_phong_ban' => 'Phòng Tài chính - Kế toán',
                'ma_phong_ban' => 'PB005',
                'mo_ta' => 'Phụ trách quản lý tài chính, kế toán và ngân sách của công ty',
                'trang_thai' => 1,
            ],
            [
                'ten_phong_ban' => 'Phòng IT',
                'ma_phong_ban' => 'PB25',
                'mo_ta' => 'Phụ trách quản lý hệ thống công nghệ thông tin, bảo trì và phát triển phần mềm',
                'trang_thai' => 2,
            ],
        ];

        foreach ($phongbans as $phongban) {
            PhongBan::create($phongban);
        }
    }
} 