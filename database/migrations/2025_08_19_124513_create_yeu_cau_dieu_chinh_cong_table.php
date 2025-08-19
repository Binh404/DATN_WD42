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
        Schema::create('yeu_cau_dieu_chinh_cong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')       // nhân viên gửi yêu cầu
                  ->constrained('nguoi_dung')
                  ->cascadeOnDelete();
            $table->date('ngay');                    // ngày cần điều chỉnh
            $table->time('gio_vao')->nullable();     // giờ vào đề xuất
            $table->time('gio_ra')->nullable();      // giờ ra đề xuất
            $table->text('ly_do');                   // lý do điều chỉnh
            $table->string('tep_dinh_kem')->nullable(); // minh chứng (nếu có)
            $table->enum('trang_thai', ['cho_duyet','da_duyet','tu_choi'])
                  ->default('cho_duyet');
            $table->foreignId('duyet_boi')           // người duyệt
                  ->nullable()
                  ->constrained('nguoi_dung')
                  ->nullOnDelete();
            $table->dateTime('duyet_vao')->nullable(); // thời gian duyệt
            $table->text('ghi_chu_duyet')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeu_cau_dieu_chinh_cong');
    }
};
