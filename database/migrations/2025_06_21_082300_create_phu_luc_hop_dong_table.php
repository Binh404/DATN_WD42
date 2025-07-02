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
        Schema::create('phu_luc_hop_dong', function (Blueprint $table) {
            $table->id();
            $table->string('so_phu_luc')->unique();
            $table->string('ten_phu_luc')->nullable();
            $table->date('ngay_ky');
            $table->date('ngay_hieu_luc');
            $table->enum('trang_thai_ky', ['cho_ky', 'da_ky'])->default('cho_ky');

            $table->foreignId('hop_dong_id')->constrained('hop_dong_lao_dong')->onDelete('cascade');
            $table->foreignId('nguoi_tao_id')->constrained('nguoi_dung')->onDelete('cascade');
            
            // Changed information
            $table->foreignId('chuc_vu_id')->constrained('chuc_vu')->onDelete('cascade');
            $table->string('loai_hop_dong');
            $table->date('ngay_ket_thuc');
            $table->decimal('luong_co_ban', 15, 2);
            $table->decimal('phu_cap', 15, 2)->nullable();
            $table->string('hinh_thuc_lam_viec');
            $table->string('dia_diem_lam_viec');
            $table->string('tep_dinh_kem')->nullable();

            $table->text('noi_dung_thay_doi');
            $table->text('ghi_chu')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phu_luc_hop_dong');
    }
};
