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
        Schema::create('chi_nhanh', function (Blueprint $table) {
             $table->id();
            $table->string('ten');
            $table->string('ma')->unique();
            $table->text('dia_chi')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->nullable();
            $table->string('thanh_pho')->nullable();
            $table->string('tinh_thanh')->nullable();
            $table->string('ma_buu_dien')->nullable();
            $table->unsignedBigInteger('quan_ly_id')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();

            $table->index('quan_ly_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_nhanh');
    }
};
