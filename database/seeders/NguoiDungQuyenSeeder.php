<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB; // ✅ Import đúng DB
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NguoiDungQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nguoi_dung_quyen')->insert([
            [
                'nguoi_dung_id' => 1,
                'quyen_id' => 1,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'quyen_id' => 2,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 1,
                'quyen_id' => 3,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'quyen_id' => 4,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 2,
                'quyen_id' => 5,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'quyen_id' => 6,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 3,
                'quyen_id' => 7,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 4,
                'quyen_id' => 8,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'quyen_id' => 9,
                'created_at' => now(),
            ],
            [
                'nguoi_dung_id' => 5,
                'quyen_id' => 10,
                'created_at' => now(),
            ],
        ]);
    }
}