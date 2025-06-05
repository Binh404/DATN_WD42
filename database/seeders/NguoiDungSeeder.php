<?php

namespace Database\Seeders;


use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NguoiDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nguoi_dung')->insert([
            [
                'id' => 1,
                'ten_dang_nhap' => 'admin',
                'email' => 'admin@company.com',
                'password' => Hash::make('123'),
                'vai_tro_id' => 1,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 1,
                'chuc_vu_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'ten_dang_nhap' => 'hr.manager',
                'email' => 'hr@company.com',
                'password' => Hash::make('123'),
                'vai_tro_id' => 2,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 2,
                'chuc_vu_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'ten_dang_nhap' => 'employee',
                'email' => 'employee@company.com',
                'password' => Hash::make('123'),
                'vai_tro_id' => 3,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 2,
                'chuc_vu_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'ten_dang_nhap' => 'it.manager',
                'email' => 'it.manager@company.com',
                'password' => Hash::make('password123'),
                'vai_tro_id' => 4,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 4,
                'chuc_vu_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'ten_dang_nhap' => 'dev.senior',
                'email' => 'dev.senior@company.com',
                'password' => Hash::make('password123'),
                'vai_tro_id' => 5,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 4,
                'chuc_vu_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'ten_dang_nhap' => 'dev.junior',
                'email' => 'dev.junior@company.com',
                'password' => Hash::make('password123'),
                'vai_tro_id' => 6,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 4,
                'chuc_vu_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'ten_dang_nhap' => 'acc.manager',
                'email' => 'acc.manager@company.com',
                'password' => Hash::make('password123'),
                'vai_tro_id' => 7,
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 3,
                'chuc_vu_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_dang_nhap' => 'test.nhanvien',
                'email' => 'test.nhanvien@company.com',
                'password' => Hash::make('matkhau123'),
                'vai_tro_id' => 3, // tùy theo hệ thống: 3 có thể là nhân viên?
                'email_verified_at' => true,
                'remember_token' => Str::random(10),
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 2, // phòng ban bạn muốn test
                'chuc_vu_id' => 5, // chức vụ bạn muốn test
                'da_hoan_thanh_ho_so' => 0,
                'dang_nhap_lan_dau' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
