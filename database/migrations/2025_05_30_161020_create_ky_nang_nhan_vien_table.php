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
        Schema::create('ky_nang_nhan_vien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung');
            $table->foreignId('ky_nang_id')->constrained('ky_nang');
            $table->enum('trinh_do', ['moi_bat_dau', 'co_ban', 'trung_cap', 'nang_cao', 'chuyen_gia']);
            $table->decimal('so_nam_kinh_nghiem', 4, 1)->default(0);
            $table->string('chung_chi')->nullable();
            $table->date('ngay_cap_chung_chi')->nullable();
            $table->date('ngay_het_han')->nullable();
            $table->boolean('da_xac_minh')->default(false);
            $table->foreignId('nguoi_xac_minh_id')->nullable()->constrained('nguoi_dung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ky_nang_nhan_vien');
    }
};
