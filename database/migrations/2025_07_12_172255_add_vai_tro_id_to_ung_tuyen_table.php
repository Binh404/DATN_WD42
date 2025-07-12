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
            $table->unsignedBigInteger('vai_tro_id')->nullable()->after('nguoi_cap_nhat_cuoi_id');
            $table->foreign('vai_tro_id')->references('id')->on('vai_tro')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ung_tuyen', function (Blueprint $table) {
            $table->dropForeign(['vai_tro_id']);
            $table->dropColumn('vai_tro_id');
        });
    }
};
