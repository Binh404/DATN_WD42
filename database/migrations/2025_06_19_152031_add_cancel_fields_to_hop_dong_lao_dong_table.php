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
            $table->text('ly_do_huy')->nullable()->after('ghi_chu');
            $table->foreignId('nguoi_huy_id')->nullable()->constrained('nguoi_dung')->after('ly_do_huy');
            $table->timestamp('thoi_gian_huy')->nullable()->after('nguoi_huy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            $table->dropForeign(['nguoi_huy_id']);
            $table->dropColumn(['ly_do_huy', 'nguoi_huy_id', 'thoi_gian_huy']);
        });
    }
};
