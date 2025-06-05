<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NguoiDungTestSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nguoi_dung')->insert([
            'ten_dang_nhap' => 'test.nhanvien',
            'email' => 'test.nhanvien@company.com',
            'password' => Hash::make('matkhau123'),
            'vai_tro_id' => 3,
            'email_verified_at' => true,
            'remember_token' => Str::random(10),
            'trang_thai' => 1,
            'lan_dang_nhap_cuoi' => now(),
            'ip_dang_nhap_cuoi' => '127.0.0.1',
            'phong_ban_id' => 2,
            'chuc_vu_id' => 5,
            'da_hoan_thanh_ho_so' => 0,
            'dang_nhap_lan_dau' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
