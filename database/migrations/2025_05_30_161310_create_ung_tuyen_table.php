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
        Schema::create('ung_tuyen', function (Blueprint $table) {
            $table->id();
            $table->string('ma_ung_tuyen', 20)->nullable();
            $table->unsignedBigInteger('tin_tuyen_dung_id')->nullable();
            $table->string('ten_ung_vien');
            $table->string('email');
            $table->string('so_dien_thoai');
            $table->string('kinh_nghiem')->nullable();
            $table->string('ky_nang')->nullable();
            $table->text('thu_gioi_thieu')->nullable();
            $table->string('tai_cv')->nullable();
            $table->timestamps(); // created_at + updated_at

            $table->decimal('diem_danh_gia', 5, 2)->nullable()->comment('Điểm đánh giá tự động khi ứng tuyển');

            $table->enum('trang_thai_pv', ['chưa phỏng vấn', 'đã phỏng vấn', 'pass','fail'])->default('chưa phỏng vấn');
            $table->decimal('diem_phong_van', 5, 2)->nullable()->comment('Điểm phỏng vấn do người phỏng vấn chấm');
            $table->text('ghi_chu')->nullable()->comment('Ghi chú của người phỏng vấn');

            $table->enum('trang_thai', ['cho_xu_ly', 'phe_duyet', 'tu_choi'])->default('cho_xu_ly');

            $table->text('ly_do')->nullable()->comment('Lý do phê duyệt hoặc từ chối');
            $table->timestamp('ngay_cap_nhat')->nullable()->comment('Thời gian cập nhật trạng thái');

            $table->unsignedBigInteger('nguoi_cap_nhat')->nullable();
            $table->unsignedBigInteger('nguoi_cap_nhat_id')->nullable();
            $table->unsignedBigInteger('nguoi_cap_nhat_cuoi_id')->nullable();

            $table->foreign('tin_tuyen_dung_id')->references('id')->on('tin_tuyen_dung')->onDelete('set null');

            $table->foreign('nguoi_cap_nhat')->references('id')->on('nguoi_dung')->onDelete('set null');
            $table->foreign('nguoi_cap_nhat_id')->references('id')->on('nguoi_dung')->onDelete('set null');
            $table->foreign('nguoi_cap_nhat_cuoi_id')->references('id')->on('nguoi_dung')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ung_tuyen');
    }
};
