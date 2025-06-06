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
        Schema::create('lich_su_duyet_yeu_cau_tuyen_dung', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yeu_cau_id');
            $table->unsignedBigInteger('nguoi_duyet_id');
            $table->enum('hanh_dong', ['tao', 'duyet', 'tu_choi', 'huy_bo', 'cap_nhat']);
            $table->text('ghi_chu')->nullable();
            $table->timestamp('thoi_gian');
            $table->timestamps();

            $table->foreign('yeu_cau_id')->references('id')->on('yeu_cau_tuyen_dung')->onDelete('cascade');
            $table->foreign('nguoi_duyet_id')->references('id')->on('nguoi_dung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_duyet_yeu_cau_tuyen_dung');
    }
};
