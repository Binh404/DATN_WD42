<?php

namespace Database\Factories;

use App\Models\PhongBan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhongBanFactory extends Factory
{
    protected $model = PhongBan::class;

    public function definition(): array
    {
        $departments = [
            'Phòng Kỹ thuật',
            'Phòng Nhân sự',
            'Phòng Tài chính',
            'Phòng Marketing',
            'Phòng Kinh doanh',
            'Phòng Hành chính',
            'Phòng Đào tạo',
            'Phòng Chăm sóc khách hàng',
        ];
        
        $tenPhongBan = $this->faker->unique()->randomElement($departments);
        $maPhongBan = 'PB' . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);
        
        return [
            'ten_phong_ban' => $tenPhongBan,
            'ma_phong_ban' => $maPhongBan,
            'mo_ta' => $this->faker->paragraph(),
            'trang_thai' => $this->faker->randomElement([0, 1]),
        ];
    }
} 