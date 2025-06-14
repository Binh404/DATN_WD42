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
            $table->unsignedBigInteger('chuc_vu_id')->nullable()->after('trang_thai_email_trungtuyen');
            $table->unsignedBigInteger('vai_tro_id')->nullable()->after('chuc_vu_id');
            $table->unsignedBigInteger('phong_ban_id')->nullable()->after('vai_tro_id');

            $table->foreign('chuc_vu_id')->references('id')->on('chuc_vu')->onDelete('set null');
            $table->foreign('vai_tro_id')->references('id')->on('vai_tro')->onDelete('set null');
            $table->foreign('phong_ban_id')->references('id')->on('phong_ban')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropForeign(['chuc_vu_id']);
            $table->dropForeign(['vai_tro_id']);
            $table->dropForeign(['phong_ban_id']);

            $table->dropColumn(['chuc_vu_id', 'vai_tro_id', 'phong_ban_id']);
        });
    }
};
