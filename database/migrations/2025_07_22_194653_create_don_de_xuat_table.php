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
        Schema::create('don_de_xuat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_tao_id')->constrained('nguoi_dung')->onDelete('cascade'); // Người tạo đề xuất (HR, trưởng phòng, hoặc nhân viên)
            $table->foreignId('nguoi_duoc_de_xuat_id')->constrained('nguoi_dung')->onDelete('cascade'); // Người được đề xuất (thường là chính nhân viên nếu xin nghỉ)
            $table->enum('loai_de_xuat', [
                'de_cu_truong_phong',
                'mien_nhiem_truong_phong',
                'de_cu_nhan_vien',
                'mien_nhiem_nhan_vien',
                'xin_nghi' // Thêm loại xin nghỉ
            ])->default('de_cu_nhan_vien');
            $table->string('vai_tro_nguoi_tao')->nullable(); // Thêm vai trò nhân viên
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'tu_choi','huy'])->default('cho_duyet'); // Trạng thái
            $table->string('ghi_chu')->nullable(); // Ghi chú (lý do xin nghỉ, ví dụ)
            $table->text('ly_do_tu_choi')->nullable(); // Lý do từ chối
            $table->foreignId('nguoi_duyet_id')->nullable()->constrained('nguoi_dung')->onDelete('set null'); // Người duyệt (Admin hoặc HR)
            $table->timestamp('thoi_gian_duyet')->nullable();
            $table->date('ngay_nghi_du_kien')->nullable(); // Ngày nghỉ dự kiến, dùng cho xin nghỉ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('don_de_xuat');
    }
};
