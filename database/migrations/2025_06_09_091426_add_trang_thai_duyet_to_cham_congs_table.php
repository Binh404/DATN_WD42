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
        Schema::table('cham_cong', function (Blueprint $table) {
            $table->boolean('trang_thai_duyet')->after('nguoi_phe_duyet_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cham_congs', function (Blueprint $table) {
            $table->dropColumn('trang_thai_duyet');
        });
    }
};
