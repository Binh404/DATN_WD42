<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('luong', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nguoi_dung_id');
            $table->unsignedBigInteger('hop_dong_lao_dong_id');

            $table->decimal('luong_co_ban', 15, 2)->default(0);
            $table->decimal('phu_cap', 15, 2)->default(0);
            $table->decimal('tien_thuong', 15, 2)->default(0);
            $table->decimal('tien_phat', 15, 2)->default(0);
            // $table->decimal('tong_luong', 15, 2)->default(0);

            // $table->date('thang_luong'); // Ví dụ: 2025-08-01 để biết lương tháng nào

            $table->timestamps();

            // Khóa ngoại
            $table->foreign('nguoi_dung_id')->references('id')->on('nguoi_dung')->onDelete('cascade');
            $table->foreign('hop_dong_lao_dong_id')->references('id')->on('hop_dong_lao_dong')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('luong');
    }
};
