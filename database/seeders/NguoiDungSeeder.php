<?php

namespace Database\Seeders;


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
                'password' => Hash::make('password123'),
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
                'email' => 'hr.manager@company.com',
                'password' => Hash::make('password123'),
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
                'ten_dang_nhap' => 'hr.staff',
                'email' => 'hr.staff@company.com',
                'password' => Hash::make('password123'),
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
                'id' => 8,
                'ten_dang_nhap' => 'acc.staff',
                'email' => 'acc.staff@company.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => true,
                'remember_token' => null,
                'trang_thai' => 1,
                'lan_dang_nhap_cuoi' => now(),
                'ip_dang_nhap_cuoi' => '127.0.0.1',
                'phong_ban_id' => 3,
                'chuc_vu_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
