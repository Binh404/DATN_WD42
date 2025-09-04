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
        Schema::table('nguoi_dung', function (Blueprint $table) {
        $table->boolean('da_hoan_thanh_ho_so')->default(false);
        $table->boolean('dang_nhap_lan_dau')->default(true);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nguoi_dung', function (Blueprint $table) {
             $table->dropColumn(['da_hoan_thanh_ho_so', 'dang_nhap_lan_dau']);
        });
    }
};
