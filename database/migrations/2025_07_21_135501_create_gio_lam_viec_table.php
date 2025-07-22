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
        Schema::create('gio_lam_viec', function (Blueprint $table) {
            $table->id();
            $table->time('gio_bat_dau')->default('08:30');           // Giờ bắt đầu làm việc
            $table->time('gio_ket_thuc')->default('17:30');          // Giờ kết thúc làm việc
            $table->decimal('gio_nghi_trua', 3, 1)->default(1.0);
            $table->integer('so_phut_cho_phep_di_tre')->default(15); // Số phút cho phép đi trễ
            $table->integer('so_phut_cho_phep_ve_som')->default(15); // Số phút cho phép về sớm
            $table->time('gio_bat_dau_tang_ca')->default('18:30');   // Giờ bắt đầu tính tăng ca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gio_lam_viec');
    }
};
