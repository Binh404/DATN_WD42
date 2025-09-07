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
            $table->text('file_dinh_kem')->nullable()->after('duong_dan_file')->comment('Đường dẫn file đính kèm hợp đồng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            $table->dropColumn('file_dinh_kem');
        });
    }
};
