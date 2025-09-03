<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GioLamViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gio_lam_viec')->insert([
            [
                'gio_bat_dau' => '08:30:00',
                'gio_ket_thuc' => '17:30:00',
                'gio_nghi_trua' => 1,
                'so_phut_cho_phep_di_tre' => 15,
                'so_phut_cho_phep_ve_som' => 15,
                'gio_bat_dau_tang_ca' => '18:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
