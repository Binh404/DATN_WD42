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
        Schema::table('don_xin_nghi', function (Blueprint $table) {
            // Xóa các cột liên quan duyệt cuối
            $table->dropForeign(['nguoi_duyet_id']);
            $table->dropColumn(['nguoi_duyet_id', 'thoi_gian_duyet', 'ly_do_tu_choi']);

            // Thêm cột cấp duyệt hiện tại (1: trưởng phòng, 2: HR)
            $table->tinyInteger('cap_duyet_hien_tai')->default(1)->after('trang_thai')->comment('1: Trưởng phòng, 2: HR');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('don_xin_nghi', function (Blueprint $table) {
            // Thêm lại các cột đã xóa
            $table->foreignId('nguoi_duyet_id')->nullable()->constrained('nguoi_dung');
            $table->timestamp('thoi_gian_duyet')->nullable();
            $table->text('ly_do_tu_choi')->nullable();

            // Xóa cột cấp duyệt
            $table->dropColumn('cap_duyet_hien_tai');
        });
    }
};
