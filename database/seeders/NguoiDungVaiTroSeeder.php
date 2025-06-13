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
                'vai_tro_id' => 1, // Admin
                'model_type' => NguoiDung::class,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'vai_tro_id' => 2, // HR Manager
                'model_type' => NguoiDung::class,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'vai_tro_id' => 3, // Team Leader
                'model_type' => NguoiDung::class,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'vai_tro_id' => 4, // Employee
                'model_type' => NguoiDung::class,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 8,
                'vai_tro_id' => 3, // Employee
                'model_type' => NguoiDung::class,
                'created_at' => now(),
            ]
        ]);
    }
}
