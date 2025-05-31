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
        Schema::create('phong_ban', function (Blueprint $table) {
            $table->id();
            $table->string('ten_phong_ban');
            $table->string('ma_phong_ban')->unique();
            $table->text('mo_ta')->nullable();
            $table->unsignedBigInteger('truong_phong_id')->nullable();
            $table->foreignId('chi_nhanh_id')->constrained('chi_nhanh');
            $table->unsignedBigInteger('phong_ban_cha_id')->nullable();
            $table->decimal('ngan_sach', 15, 2)->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();

            $table->foreign('phong_ban_cha_id')->references('id')->on('phong_ban');
            $table->index('truong_phong_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phong_ban');
    }
};
