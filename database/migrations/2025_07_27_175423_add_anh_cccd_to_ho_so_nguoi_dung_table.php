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
        Schema::table('ho_so_nguoi_dung', function (Blueprint $table) {
            $table->string('anh_cccd_truoc')->nullable();
            $table->string('anh_cccd_sau')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ho_so_nguoi_dung', function (Blueprint $table) {
            $table->dropColumn(['anh_cccd_truoc', 'anh_cccd_sau']);
        });
    }
};
