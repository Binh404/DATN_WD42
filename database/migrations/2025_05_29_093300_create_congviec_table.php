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
        Schema::create('congviec', function (Blueprint $table) {
            $table->id();  // Tạo khóa chính
            $table->string('ten_cong_viec');  // Tên công việc
            $table->text('mo_ta');  // Mô tả công việc
            $table->enum('trang_thai', ['Chưa bắt đầu', 'Đang làm', 'Hoàn thành', 'Quá hạn']);  // Trạng thái công việc
            $table->enum('do_uu_tien', ['Cao', 'Trung bình', 'Thấp']);  // Độ ưu tiên
            $table->dateTime('ngay_bat_dau');  // Ngày bắt đầu công việc
            $table->dateTime('deadline');  // Thời hạn công việc
            $table->dateTime('ngay_hoan_thanh')->nullable();  // Ngày hoàn thành công việc (nullable)
            $table->timestamps();  // Tạo created_at và updated_a
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congviec');
    }
};
