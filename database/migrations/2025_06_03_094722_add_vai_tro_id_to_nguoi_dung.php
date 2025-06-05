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
        Schema::table('nguoi_dung', function (Blueprint $table) {
            //
            // Thêm cột khóa ngoại nếu chưa tồn tại
            if (!Schema::hasColumn('nguoi_dung', 'vai_tro_id')) {
                $table->unsignedBigInteger('vai_tro_id')->nullable()->after('password');

                // Khóa ngoại liên kết tới bảng nguoi_dung
                $table->foreign('vai_tro_id')
                    ->references('id')
                    ->on('vai_tro')
                    ->onDelete('set null'); // hoặc 'cascade', 'restrict' tùy logic
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
            //
            // Xóa ràng buộc foreign key trước
            if (Schema::hasColumn('nguoi_dung', 'vai_tro_id')) {
                $table->dropForeign(['vai_tro_id']);
                $table->dropColumn('vai_tro_id');
            }
        });
    }
};