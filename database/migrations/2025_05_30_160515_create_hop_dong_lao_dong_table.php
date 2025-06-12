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
        Schema::create('hop_dong_lao_dong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung');
            $table->string('so_hop_dong')->unique();
            $table->enum('loai_hop_dong', ['thu_viec', 'xac_dinh_thoi_han', 'khong_xac_dinh_thoi_han', 'mua_vu']);
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc')->nullable();
            $table->decimal('luong_co_ban', 12, 2);
            $table->string('duong_dan_file')->nullable();
            $table->text('dieu_khoan')->nullable();
            $table->enum('trang_thai_hop_dong', ['hieu_luc', 'het_han', 'huy_bo'])->default('hieu_luc');
            $table->enum('trang_thai_ky', ['cho_ky', 'da_ky'])->default('cho_ky');
            $table->foreignId('nguoi_ky_id')->nullable()->constrained('nguoi_dung');
            $table->timestamp('thoi_gian_ky')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hop_dong_lao_dong');
    }
};
