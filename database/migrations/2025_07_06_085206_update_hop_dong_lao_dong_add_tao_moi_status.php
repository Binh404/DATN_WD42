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
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            // Thay đổi enum để thêm trạng thái "tao_moi"
            $table->enum('trang_thai_hop_dong', ['tao_moi', 'chua_hieu_luc', 'hieu_luc', 'het_han', 'huy_bo'])->default('tao_moi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            // Khôi phục lại enum ban đầu
            $table->enum('trang_thai_hop_dong', ['chua_hieu_luc', 'hieu_luc', 'het_han', 'huy_bo'])->default('chua_hieu_luc')->change();
        });
    }
};
