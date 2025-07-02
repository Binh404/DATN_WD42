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
        Schema::create('lich_su_duyet_don_nghi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('don_xin_nghi_id')->comment('ID đơn xin nghỉ');
            $table->unsignedTinyInteger('cap_duyet')->comment('Cấp duyệt: 1 - Trưởng phòng, 2 - HR');
            $table->unsignedBigInteger('nguoi_duyet_id')->comment('Người thực hiện duyệt');

            $table->enum('ket_qua', ['da_duyet', 'tu_choi'])->comment('Kết quả duyệt');
            $table->text('ghi_chu')->nullable()->comment('Ghi chú hoặc lý do từ chối');
            $table->timestamp('thoi_gian_duyet')->useCurrent()->comment('Thời gian duyệt');

            $table->timestamps();

            // Liên kết khóa ngoại
            $table->foreign('don_xin_nghi_id')
                ->references('id')
                ->on('don_xin_nghi')
                ->onDelete('cascade');

            $table->foreign('nguoi_duyet_id')
                ->references('id')
                ->on('nguoi_dung')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_duyet_don_nghi');
    }
};
