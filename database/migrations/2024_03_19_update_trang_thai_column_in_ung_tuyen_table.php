<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            // Đổi kiểu dữ liệu của cột trang_thai thành enum
            DB::statement("ALTER TABLE ung_tuyen MODIFY COLUMN trang_thai ENUM('cho_xu_ly', 'phe_duyet', 'tu_choi') DEFAULT 'cho_xu_ly'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            // Đổi lại kiểu dữ liệu của cột trang_thai thành string
            DB::statement("ALTER TABLE ung_tuyen MODIFY COLUMN trang_thai VARCHAR(255) DEFAULT 'cho_xu_ly'");
        });
    }
}; 