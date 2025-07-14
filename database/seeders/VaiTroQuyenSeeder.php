<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaiTroQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('vai_tro_quyen')->insert([
            // Admin có tất cả quyền
            ['role_id' => 1, 'permission_id' => 1, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 2, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 3, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 4, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 5, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 6, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 7, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 8, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 9, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 10, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 11, 'created_at' => now()],
            ['role_id' => 1, 'permission_id' => 12, 'created_at' => now()],

            // HR Manager
            ['role_id' => 2, 'permission_id' => 1, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 5, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 6, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 7, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 8, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 9, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 11, 'created_at' => now()],
            ['role_id' => 2, 'permission_id' => 12, 'created_at' => now()],

            // Team Leader
            ['role_id' => 3, 'permission_id' => 1, 'created_at' => now()],
            ['role_id' => 3, 'permission_id' => 5, 'created_at' => now()],
            ['role_id' => 3, 'permission_id' => 8, 'created_at' => now()],
            ['role_id' => 3, 'permission_id' => 9, 'created_at' => now()],
            ['role_id' => 3, 'permission_id' => 10, 'created_at' => now()],

            // Employee
            ['role_id' => 4, 'permission_id' => 8, 'created_at' => now()],
            ['role_id' => 4, 'permission_id' => 10, 'created_at' => now()],
            ['role_id' => 4, 'permission_id' => 11, 'created_at' => now()],
        ]);
    }
}