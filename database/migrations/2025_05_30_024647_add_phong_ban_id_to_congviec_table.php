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
        Schema::table('congviec', function (Blueprint $table) {
            $table->unsignedBigInteger('phong_ban_id')->nullable()->after('ten_cong_viec');
            $table->foreign('phong_ban_id')->references('id')->on('phong_ban')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('congviec', function (Blueprint $table) {
            $table->dropForeign(['phong_ban_id']);
            $table->dropColumn('phong_ban_id');
        });
    }
};
