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
        Schema::create('phan_cong_cong_viec', function (Blueprint $table) {
            $table->id();
             $table->foreignId('nguoi_giao_id')->constrained('nguoi_dung');
            $table->foreignId('nguoi_nhan_id')->constrained('nguoi_dung');
            $table->foreignId('cong_viec_id')->constrained('cong_viec');
            $table->foreignId('phong_ban_id')->constrained('phong_ban');
            $table->enum('vai_tro_trong_cv', ['chu_tri', 'phoi_hop', 'theo_doi'])->default('chu_tri');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phan_cong_cong_viec');
    }
    // hehe
};
