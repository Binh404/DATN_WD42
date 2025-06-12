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
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            $table->string('chuc_vu', 100)->nullable()->after('nguoi_dung_id');
            $table->decimal('phu_cap', 15, 2)->nullable()->after('luong_co_ban');
            $table->string('hinh_thuc_lam_viec', 50)->nullable()->after('phu_cap');
            $table->string('dia_diem_lam_viec', 100)->nullable()->after('hinh_thuc_lam_viec');
            $table->text('ghi_chu')->nullable()->after('dia_diem_lam_viec');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            $table->dropColumn([
                'chuc_vu',
                'phu_cap',
                'hinh_thuc_lam_viec',
                'dia_diem_lam_viec',
                'ghi_chu'
            ]);
        });
    }
}; 