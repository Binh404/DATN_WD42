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
        Schema::create('so_du_nghi_phep_nhan_vien', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dung');
            $table->foreignId('loai_nghi_phep_id')->constrained('loai_nghi_phep');
            $table->year('nam');
            $table->decimal('so_ngay_duoc_cap', 5, 1)->default(0);
            $table->decimal('so_ngay_da_dung', 5, 1)->default(0);
            $table->decimal('so_ngay_cho_duyet', 5, 1)->default(0);
            $table->decimal('so_ngay_con_lai', 5, 1)->default(0);
            $table->decimal('so_ngay_chuyen_tu_nam_truoc', 5, 1)->default(0);
            $table->timestamps();

            $table->index(['nguoi_dung_id', 'nam']);
            $table->unique(['nguoi_dung_id', 'loai_nghi_phep_id', 'nam'], 'nghiphep_nd_ln_nam_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_du_nghi_phep_nhan_vien');
    }
};
