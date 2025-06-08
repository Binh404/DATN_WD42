<?php

namespace Database\Seeders;

use DB;
use App\Models\NguoiDung;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'role_id' => 1, // Admin
                'model_type' => NguoiDung::class,
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 2,
                'role_id' => 2, // HR Manager
                'model_type' => NguoiDung::class,
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 3,
                'role_id' => 3, // Team Leader
                'model_type' => NguoiDung::class,
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 4,
                'role_id' => 4, // Employee
                'model_type' => NguoiDung::class,
                'created_at' => now(),

            ],
            [
                'nguoi_dung_id' => 8,
                'role_id' => 3, // Employee
                'model_type' => NguoiDung::class,
                'created_at' => now(),

            ],
        ]);
    }
}