<?php

namespace Database\Seeders;

use App\Models\PhongBan;
use Illuminate\Database\Seeder;

class PhongBanSeeder extends Seeder
{
    public function run(): void
    {
        PhongBan::factory()->count(8)->create();
    }
} 