<?php

namespace Database\Seeders;

use DB;
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
            ['vai_tro_id' => 1, 'quyen_id' => 1, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 2, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 3, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 4, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 5, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 6, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 7, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 8, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 9, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 10, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 11, 'created_at' => now()],
            ['vai_tro_id' => 1, 'quyen_id' => 12, 'created_at' => now()],

            // HR Manager
            ['vai_tro_id' => 2, 'quyen_id' => 1, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 5, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 6, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 7, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 8, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 9, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 11, 'created_at' => now()],
            ['vai_tro_id' => 2, 'quyen_id' => 12, 'created_at' => now()],

            // Team Leader
            ['vai_tro_id' => 3, 'quyen_id' => 1, 'created_at' => now()],
            ['vai_tro_id' => 3, 'quyen_id' => 5, 'created_at' => now()],
            ['vai_tro_id' => 3, 'quyen_id' => 8, 'created_at' => now()],
            ['vai_tro_id' => 3, 'quyen_id' => 9, 'created_at' => now()],
            ['vai_tro_id' => 3, 'quyen_id' => 10, 'created_at' => now()],

            // Employee
            ['vai_tro_id' => 4, 'quyen_id' => 8, 'created_at' => now()],
            ['vai_tro_id' => 4, 'quyen_id' => 10, 'created_at' => now()],
            ['vai_tro_id' => 4, 'quyen_id' => 11, 'created_at' => now()],
        ]);
    }
}
