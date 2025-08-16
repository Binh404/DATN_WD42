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
            // Thay đổi duong_dan_file từ varchar(255) thành text
            $table->text('duong_dan_file')->nullable()->change();
            
            // Thay đổi file_hop_dong_da_ky từ varchar(255) thành text
            $table->text('file_hop_dong_da_ky')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hop_dong_lao_dong', function (Blueprint $table) {
            // Khôi phục về varchar(255)
            $table->string('duong_dan_file', 255)->nullable()->change();
            $table->string('file_hop_dong_da_ky', 255)->nullable()->change();
        });
    }
};
