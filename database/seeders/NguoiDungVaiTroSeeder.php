<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NguoiDungVaiTroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('nguoi_dung_vai_tro')->insert([
            [
                'nguoi_dung_id' => 1,
                'vai_tro_id' => 1, // Admin
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 2,
                'vai_tro_id' => 2, // HR Manager
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 3,
                'vai_tro_id' => 3, // Team Leader
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 4,
                'vai_tro_id' => 4, // Employee
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 5,
                'vai_tro_id' => 4, // Employee
                'created_at' => now(),

            ],
        ]);
    }
}
