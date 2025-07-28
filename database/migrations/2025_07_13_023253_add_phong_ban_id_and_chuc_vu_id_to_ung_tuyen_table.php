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
            $table->unsignedBigInteger('phong_ban_id')->nullable()->after('vai_tro_id');
            $table->unsignedBigInteger('chuc_vu_id')->nullable()->after('phong_ban_id');
            
            $table->foreign('phong_ban_id')->references('id')->on('phong_ban')->onDelete('set null');
            $table->foreign('chuc_vu_id')->references('id')->on('chuc_vu')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropForeign(['phong_ban_id']);
            $table->dropForeign(['chuc_vu_id']);
            $table->dropColumn(['phong_ban_id', 'chuc_vu_id']);
        });
    }
};
