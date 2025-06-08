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
        Schema::table('yeu_cau_tuyen_dung', function (Blueprint $table) {
            $table->enum('trang_thai_dang', ['chua_dang', 'da_dang'])->default('chua_dang')->after('trang_thai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yeu_cau_tuyen_dung', function (Blueprint $table) {
            $table->dropColumn('trang_thai_dang');
        });
    }
};
