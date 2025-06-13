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
        Schema::create('nguoi_dung_vai_tro', function (Blueprint $table) {
            $table->unsignedBigInteger('vai_tro_id');
            $table->string('model_type'); // ví dụ: App\Models\NguoiDung
            $table->unsignedBigInteger('nguoi_dung_id');
            $table->timestamps();

            $table->index(['vai_tro_id', 'nguoi_dung_id', 'model_type'], 'ndvt_index');

            // Thiết lập khóa ngoại nếu bạn dùng bảng vai_tro thay vì roles
            $table->foreign('vai_tro_id')->references('id')->on('vai_tro')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung_vai_tro');
    }
};