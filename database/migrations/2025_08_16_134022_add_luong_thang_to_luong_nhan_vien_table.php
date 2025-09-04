<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('luong_nhan_vien', function (Blueprint $table) {
            $table->tinyInteger('luong_thang')->after('bang_luong_id')->comment('Tháng lương (1-12)');
            $table->year('luong_nam')->after('luong_thang')->comment('Năm lương');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('luong_nhan_vien', function (Blueprint $table) {
            $table->dropColumn(['luong_thang', 'luong_nam']);
        });
    }
};
