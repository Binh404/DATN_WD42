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
        Schema::table('chuc_vu', function (Blueprint $table) {
            $table->decimal('luong_theo_ngay', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chuc_vu', function (Blueprint $table) {
            $table->dropColumn('luong_theo_ngay');
        });
    }
};
