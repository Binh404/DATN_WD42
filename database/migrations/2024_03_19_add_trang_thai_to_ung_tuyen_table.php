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
        Schema::table('ung_tuyen', function (Blueprint $table) {
            // Kiểm tra xem cột đã tồn tại chưa trước khi thêm
            if (!Schema::hasColumn('ung_tuyen', 'trang_thai')) {
                $table->string('trang_thai')->default('cho_xu_ly')->after('diem_danh_gia');
            }
            if (!Schema::hasColumn('ung_tuyen', 'ly_do')) {
                $table->text('ly_do')->nullable()->after('trang_thai');
            }
            if (!Schema::hasColumn('ung_tuyen', 'nguoi_cap_nhat_id')) {
                $table->unsignedBigInteger('nguoi_cap_nhat_id')->nullable()->after('ly_do');
                $table->foreign('nguoi_cap_nhat_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            if (Schema::hasColumn('ung_tuyen', 'nguoi_cap_nhat_id')) {
                $table->dropForeign(['nguoi_cap_nhat_id']);
            }
            $table->dropColumn(['trang_thai', 'ly_do', 'nguoi_cap_nhat_id']);
        });
    }
}; 