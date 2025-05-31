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
        Schema::create('phancong_congviec', function (Blueprint $table) {
            $table->id();  // Tạo khóa chính
            $table->foreignId('nguoi_giao_id')->nullable()->constrained('users')->onDelete('set null');  // Khóa ngoại tham chiếu đến bảng users (người giao công việc)
            $table->foreignId('nguoi_nhan_id')->nullable()->constrained('users')->onDelete('set null');  // Khóa ngoại tham chiếu đến bảng users (người nhận công việc)
            $table->foreignId('phong_ban_id')->nullable()->constrained('phongban')->onDelete('set null');  // Khóa ngoại tham chiếu đến bảng phongban
            $table->foreignId('cong_viec_id')->constrained('congviec')->onDelete('cascade');  // Khóa ngoại tham chiếu đến bảng congviec (công việc)
            $table->timestamps();  // Tạo created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phancong_congviec');
    }
};
