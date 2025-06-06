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
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->decimal('diem_danh_gia', 5, 2)->nullable()->comment('Điểm đánh giá tự động khi ứng tuyển');
            $table->enum('trang_thai_pv', ['Chưa phỏng vấn', 'Đã phỏng vấn', 'Đạt', 'Không đạt'])->default('Chưa phỏng vấn');
            $table->decimal('diem_phong_van', 5, 2)->nullable()->comment('Điểm phỏng vấn do người phỏng vấn chấm');
            $table->text('ghi_chu')->nullable()->comment('Ghi chú của người phỏng vấn');
            $table->unsignedBigInteger('nguoi_cap_nhat')->nullable();
            $table->foreign('nguoi_cap_nhat')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropForeign(['nguoi_cap_nhat']);
            $table->dropColumn([
                'diem_danh_gia',
                'trang_thai_pv',
                'diem_phong_van',
                'ghi_chu',
                'nguoi_cap_nhat'
            ]);
        });
    }
};
