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
            $table->string('ten_ung_vien');
            $table->string('email');
            $table->string('so_dien_thoai');
            $table->string('kinh_nghiem')->nullable();
            $table->string('ky_nang')->nullable();
            $table->text('thu_gioi_thieu')->nullable();
            $table->string('tai_cv')->nullable();
            // $table->foreignId('cong_viec_id')->constrained('cong_viec')->onDelete('cascade');
            $table->timestamps();
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
