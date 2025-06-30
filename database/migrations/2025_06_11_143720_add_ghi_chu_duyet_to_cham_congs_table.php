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
            $table->string('ghi_chu_duyet')->after('trang_thai_duyet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cham_cong', function (Blueprint $table) {
            $table->dropColumn('ghi_chu_duyet');
        });
    }
};
