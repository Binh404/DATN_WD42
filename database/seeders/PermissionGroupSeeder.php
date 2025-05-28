<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionGroupSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permission_groups')->insert([
            [
                'name' => 'User Management',
                'description' => 'Quản lý người dùng',
                'color' => '#007bff',
                'icon' => 'users',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Role Management',
                'description' => 'Quản lý vai trò',
                'color' => '#28a745',
                'icon' => 'shield-alt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Permission Management',
                'description' => 'Quản lý quyền',
                'color' => '#ffc107',
                'icon' => 'key',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 