<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('yeu_cau_tuyen_dung', function (Blueprint $table) {
            DB::statement("ALTER TABLE yeu_cau_tuyen_dung MODIFY loai_hop_dong ENUM('thu_viec', 'xac_dinh_thoi_han', 'khong_xac_dinh_thoi_han') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yeu_cau_tuyen_dung', function (Blueprint $table) {
            //
        });
    }
};
