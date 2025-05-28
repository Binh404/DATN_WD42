<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Quản trị hệ thống',
                'level' => 10,
                'is_system' => true,
                'guard_name' => 'web', // BẮT BUỘC PHẢI CÓ
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Quản lý',
                'level' => 5,
                'is_system' => false,
                'guard_name' => 'web', // BẮT BUỘC PHẢI CÓ
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'Người dùng thông thường',
                'level' => 1,
                'is_system' => false,
                'guard_name' => 'web', // BẮT BUỘC PHẢI CÓ
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 